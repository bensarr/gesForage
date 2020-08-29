<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Village;
use App\Form\AbonnementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/Abonnement/liste", name="liste_abonnement")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $a=new Abonnement();
        $form=$this->createForm(AbonnementType::class,
            $a,
            array('action'=>$this->generateUrl('add_abonnement'))
        );
        $data['form']=$form->createView();

        $data['abonnements'] = $em->getRepository(Abonnement::class)->findAll();
        return $this->render('abonnement/index.html.twig', $data);
    }
    /**
     * @Route("/Abonnement/add", name="add_abonnement")
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request)
    {
        $a=new Abonnement();
        $form = $this->createForm(AbonnementType::class, $a);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $a = $form->getData();
            $a->setUser($this->getUser());
            $a->getClient()->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($a->getClient());
            $em->persist($a);
            $em->flush();
        }
        return $this->redirectToRoute('liste_abonnement');
    }
    /**
     * @Route("/Abonnement/edit/{id}", name="edit_abonnement")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $a=$em->getRepository(Abonnement::class)->find($id);

        $form=$this->createForm(AbonnementType::class,
            $a,
            array('action'=>$this->generateUrl('update_abonnement',['id'=>$id]))
        );
        $data['form']=$form->createView();

        $data['abonnements'] = $em->getRepository(Abonnement::class)->findAll();
        return $this->render('abonnement/index.html.twig', $data);
    }
    /**
     * @Route("/Abonnement/update/{id}", name="update_abonnement")
     */
    public function update($id, Request $request)
    {
        $a=new Abonnement();
        $form = $this->createForm(AbonnementType::class, $a);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $a = $form->getData();
            $a->setId($id);
            //Récupération valeurs
            $em = $this->getDoctrine()->getManager();
            $abonnemente=$em->getRepository(Abonnement::class)->find($a->getId());
            $abonnemente->setNumero($a->getNumero());
            $abonnemente->setDate($a->getDate());
            $abonnemente->setCompteur($a->getCompteur());
            $abonnemente->getClient()->setNom($a->getClient()->getNom());
            $abonnemente->getClient()->setTel($a->getClient()->getTel());
            $abonnemente->getClient()->setAdresse($a->getClient()->getAdresse());
            $abonnemente->getClient()->setVillage($a->getClient()->getVillage());
            $em->flush();
        }
        return $this->redirectToRoute('liste_abonnement');
    }
    /**
     * @Route("/Abonnement/delete/{id}", name="delete_abonnement")
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
