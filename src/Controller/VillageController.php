<?php

namespace App\Controller;

use App\Entity\Village;
use App\Form\VillageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VillageController extends AbstractController
{
    /**
     * @Route("/Village/liste", name="liste_village")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $v=new Village();
        $form=$this->createForm(VillageType::class,
            $v,
            array('action'=>$this->generateUrl('add_village'))
        );
        $data['form']=$form->createView();

        $data['villages'] = $em->getRepository(Village::class)->findAll();
        return $this->render('village/index.html.twig', $data);
    }

    /**
     * @Route("/Village/add", name="add_village")
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request)
    {
        $v=new Village();
        $form = $this->createForm(VillageType::class, $v);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $v = $form->getData();
            $v->setUser($this->getUser());
            $v->getChef()->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($v->getChef());
            $em->persist($v);
            $em->flush();
        }
        return $this->redirectToRoute('liste_village');
    }
    /**
     * @Route("/Village/edit/{id}", name="edit_village")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $v=$em->getRepository(Village::class)->find($id);

        $form=$this->createForm(VillageType::class,
            $v,
            array('action'=>$this->generateUrl('update_village',['id'=>$id]))
        );
        $data['form']=$form->createView();

        $data['villages'] = $em->getRepository(Village::class)->findAll();
        return $this->render('village/index.html.twig', $data);
    }
    /**
     * @Route("/Village/update/{id}", name="update_village")
     */
    public function update($id, Request $request)
    {
        $v=new Village();
        $form = $this->createForm(VillageType::class, $v);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $v = $form->getData();
            $v->setId($id);
            //Récupération valeurs
            $em = $this->getDoctrine()->getManager();
            $village=$em->getRepository(Village::class)->find($v->getId());
            $village->setNom($v->getNom());
            $village->getChef()->setNom($v->getChef()->getNom());
            $village->getChef()->setPrenom($v->getChef()->getPrenom());
            $em->flush();
        }
        return $this->redirectToRoute('liste_village');
    }
    /**
     * @Route("/Village/delete/{id}", name="delete_village")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $v=$em->getRepository(Village::class)->find($id);
        if($v!=null)
        {
            $em->remove($v);
            $em->flush();
        }
        return $this->redirectToRoute('liste_village');
    }
}
