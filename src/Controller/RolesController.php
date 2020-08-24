<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Form\RolesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RolesController extends AbstractController
{
    /**
     * @Route("/Role/liste", name="liste_roles")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $r=new Roles();
        $form=$this->createForm(RolesType::class,
            $r,
            array('action'=>$this->generateUrl('add_role'))
        );
        $data['form']=$form->createView();

        $data['roles'] = $em->getRepository(Roles::class)->findAll();
        return $this->render('roles/index.html.twig', $data);
    }
    /**
     * @Route("/Role/add", name="add_role")
     */
    public function add(Request $request)
    {
        $r=new Roles();
        $form = $this->createForm(RolesType::class, $r);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $r = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($r);
            $em->flush();
        }
        return $this->redirectToRoute('liste_roles');
    }
    /**
     * @Route("/Role/edit/{id}", name="edit_role")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $r=$em->getRepository(Roles::class)->find($id);

        $form=$this->createForm(RolesType::class,
            $r,
            array('action'=>$this->generateUrl('update_role',['id'=>$id]))
        );
        $data['form']=$form->createView();

        $data['roles'] = $em->getRepository(Roles::class)->findAll();
        return $this->render('roles/index.html.twig', $data);
    }
    /**
     * @Route("/Role/update/{id}", name="update_role")
     */
    public function update($id, Request $request)
    {
        $r=new Roles();
        $form = $this->createForm(RolesType::class, $r);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $r = $form->getData();
            $r->setId($id);
            //Récupération valeurs
            $em = $this->getDoctrine()->getManager();
            $role=$em->getRepository(Roles::class)->find($r->getId());
            $role->setName($r->getName());
            $em->flush();
        }
        return $this->redirectToRoute('liste_roles');
    }
    /**
     * @Route("/Role/delete/{id}", name="delete_role")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $r=$em->getRepository(Roles::class)->find($id);
        if($r!=null)
        {
            $em->remove($r);
            $em->flush();
        }
        return $this->redirectToRoute('liste_roles');
    }
}
