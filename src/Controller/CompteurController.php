<?php

namespace App\Controller;

use App\Entity\Compteur;
use App\Form\CompteurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompteurController extends AbstractController
{
    /**
     * @Route("/Compteur/liste", name="liste_compteur")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $c=new Compteur();
        $form=$this->createForm(CompteurType::class,
            $c,
            array('action'=>$this->generateUrl('add_compteur'))
        );
        $data['form']=$form->createView();

        $data['compteurs'] = $em->getRepository(Compteur::class)->findAll();
        return $this->render('compteur/index.html.twig', $data);
    }
    /**
     * @Route("/Compteur/add", name="add_compteur")
     */
    public function add(Request $request)
    {
        $c=new Compteur();
        $form = $this->createForm(CompteurType::class, $c);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $c = $form->getData();
            $c->setUser($this->getUser());
            $c->setEtat(false);//false=>bloqué
            $em = $this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();
        }
        return $this->redirectToRoute('liste_compteur');
    }
    /**
     * @Route("/Compteur/edit/{id}", name="edit_compteur")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $c=$em->getRepository(Compteur::class)->find($id);

        $form=$this->createForm(CompteurType::class,
            $c,
            array('action'=>$this->generateUrl('update_compteur',['id'=>$id]))
        );
        $data['form']=$form->createView();

        $data['compteurs'] = $em->getRepository(Compteur::class)->findAll();
        return $this->render('compteur/index.html.twig', $data);
    }
    /**
     * @Route("/Compteur/update/{id}", name="update_compteur")
     */
    public function update($id, Request $request)
    {
        $c=new Compteur();
        $form = $this->createForm(CompteurType::class, $c);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $c = $form->getData();
            $c->setId($id);
            //Récupération valeurs
            $em = $this->getDoctrine()->getManager();
            $compteur=$em->getRepository(Compteur::class)->find($c->getId());
            $compteur->setNumero($c->getNumero());
            $em->flush();
        }
        return $this->redirectToRoute('liste_compteur');
    }
    /**
     * @Route("/Compteur/action/{id}", name="action_compteur")
     */
    public function action($id)
    {
        $em = $this->getDoctrine()->getManager();
        $c=$em->getRepository(Compteur::class)->find($id);
        $c->setEtat(!$c->getEtat());//false=>bloqué
        $em->flush();
        return $this->redirectToRoute('liste_compteur');
    }
    /**
     * @Route("/Compteur/delete/{id}", name="delete_compteur")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $c=$em->getRepository(Compteur::class)->find($id);
        if($c!=null)
        {
            $em->remove($c);
            $em->flush();
        }
        return $this->redirectToRoute('liste_compteur');
    }
}
