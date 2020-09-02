<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Entity\User;
use App\Form\ParameterUserType;
use App\Form\RegistrationFormType;
use App\Service\Securize;
use PhpParser\Node\Stmt\Global_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    private $mesroles=array();

    private $passwordEncoder;

    /**
     * UtilisateurController constructor.
     * @param $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

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
    public function add(Request $request)
    {
        $u=new User();
        $form = $this->createForm(RegistrationFormType::class, $u);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $u = $form->getData();
            $u->setPassword(
                $this->passwordEncoder->encodePassword(
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
     * @param $id
     * @param Securize $securizer
     * @return Response
     */
    public function getUtilisateur($id,Securize $securizer)
    {
        $em = $this->getDoctrine()->getManager();
        $u=$em->getRepository(User::class)->find($id);
        $data['utilisateur'] = $u;
        $roles = $em->getRepository(Roles::class)->findAll();
        $data['roles']=$roles;

        foreach ($roles as $role) {
            if($securizer->isGranted($u,$role->getName()))
                array_push($this->mesroles,$role);
        }

        $data['idUser'] = $id;

        $form=$this->createForm(ParameterUserType::class,
            $u,
            array('mesroles'=>$this->mesroles,'action'=>$this->generateUrl('update_utilisateur',['id'=>$id]))
        );
        $data['form']=$form->createView();


        return $this->render('registration/parameter.html.twig', $data);
    }

    /**
     * @Route("/Utilisateur/settings", name="settings_utilisateur")
     * @param Securize $securizer
     */
    public function settings(Securize $securizer)
    {
        $em = $this->getDoctrine()->getManager();
        $u=$this->getUser();
        $data['utilisateur'] = $u;
        $roles = $em->getRepository(Roles::class)->findAll();
        $data['roles']=$roles;

        foreach ($roles as $role) {
            if($securizer->isGranted($u,$role->getName()))
                array_push($this->mesroles,$role);
        }

        $form=$this->createForm(ParameterUserType::class,
            $u,
            array('mesroles'=>$this->mesroles,'action'=>$this->generateUrl('update_utilisateur',['id'=>$u->getId()]))
        );
        $data['form']=$form->createView();


        return $this->render('registration/parameter.html.twig', $data);
    }
    /**
     * @Route("/Utilisateur/update/{id}", name="update_utilisateur")
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $u=new User();
        $form = $this->createForm(ParameterUserType::class, $u,['mesroles'=>$this->mesroles]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $u = $form->getData();
            $u->setId($id);
            //Récupération valeurs
            $em = $this->getDoctrine()->getManager();
            $user=$em->getRepository(User::class)->find($u->getId());
            $em->getRepository(User::class)->upgradePassword($user,$this->passwordEncoder->encodePassword($u,$u->getPassword()));
            $roles=[];
            foreach ($u->getRoles() as $role) {
                $roles[]=$em->getRepository(Roles::class)->findOneBy(['name'=>$role]); //LE TYPE EN ARTGUMENT EST UN Tableau de STRING DOMMAGE
                }
            $user->setUsername($u->getUsername());
            $user->setRoles($roles);
            $em->flush();
        }
        return $this->redirectToRoute('liste_utilisateurs');
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
        return $this->redirectToRoute('liste_utilisateurs');
    }
}
