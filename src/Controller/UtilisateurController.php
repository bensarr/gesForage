<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/Utilisateur/liste", name="liste_utilisateurs")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $u=new User();
        $form=$this->createForm(RegistrationFormType::class,
            $u,
            array('action'=>$this->generateUrl('add_utilisateur'))
        );
        $data['form']=$form->createView();

        $data['utilisateurs'] = $em->getRepository(User::class)->findAll();
        return $this->render('registration/register.html.twig', $data);
    }
    /**
     * @Route("/Utilisateur/add", name="add_utilisateur")
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $u=new User();
        $form = $this->createForm(RegistrationFormType::class, $u);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $u = $form->getData();
            $u->setPassword(
                $passwordEncoder->encodePassword(
                    $u,
                    'passer123'
                    //$form->get('plainPassword')->getData()
                )
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($u);
            $em->flush();
        }
        return $this->redirectToRoute('liste_utilisateurs');
    }
    /**
     * @Route("/Utilisateur/get/{id}", name="edit_utilisateur")
     */
    public function getUtilisateur($id)
    {
        $em = $this->getDoctrine()->getManager();
        $u=$em->getRepository(User::class)->find($id);

        $form=$this->createForm(RegistrationFormType::class,
            $u,
            array('action'=>$this->generateUrl('update_utilisateur',['id'=>$id]))
        );
        $data['form']=$form->createView();
        $roles = $em->getRepository(Roles::class)->findAll();
        $data['roles']=$roles;
        $data['utilisateur'] = $u;
        $data['idUser'] = $id;

        return $this->render('registration/parameter.html.twig', $data);
    }
    /**
     * @Route("/Utilisateur/affecter", name="affecter")
     */
    public function affecter(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $u =$em->getRepository(User::class)->find($request->request->get('idUser'));

        if($request->request->count()>0)
        {
            if($request->request->get('roles[]')>0)
            {
                $roles = array();
                foreach ($request->request->get('roles') as $nom)
                {
                    array_push($roles, $em->getRepository(Roles::class)->findOneBy(['name'=>$nom]));
                }
                $u->setRoles($roles[]);//Modification des roles
                $em->flush();
            }
            else
            {
                $roles=array();
                $u->setRoles($roles);//Modification des roles
                $em->flush();
            }
        }
        return $this->redirectToRoute('edit_utilisateur',['id'=> $u->getId()]);
    }
    /**
     * @Route("/Utilisateur/update/{id}", name="update_utilisateur")
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
     * @Route("/Utilisateur/delete/{id}", name="delete_utilisateur")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $u=$em->getRepository(User::class)->find($id);
        if($u!=null)
        {
            $em->remove($u);
            $em->flush();
        }
        return $this->redirectToRoute('liste_roles');
    }
}
