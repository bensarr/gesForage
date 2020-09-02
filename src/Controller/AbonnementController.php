<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Client;
use App\Entity\PropertySearch;
use App\Entity\Village;
use App\Form\AbonnementType;
use App\Form\PropertySearchType;
use App\Form\SearchType;
use App\Repository\AbonnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbonnementController extends AbstractController
{
    /*
     * @var AbonnementRepository*/
    private $repository;

    /**
     * AbonnementController constructor.
     * @param AbonnementRepository $repository
     */
    public function __construct(AbonnementRepository $repository)
    {
        $this->repository=$repository;
    }

    /**
     * @Route("/Abonnement/liste", name="liste_abonnement")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $a=new Abonnement();
        $form=$this->createForm(AbonnementType::class,
            $a,
            array('action'=>$this->generateUrl('add_abonnement'))
        );
        $data['form']=$form->createView();
        //Form Recherche
        $search=new PropertySearch();
        $formSearch=$this->createForm(PropertySearchType::class,$search);
        $formSearch->handleRequest($request);
        $data['formSearch']=$formSearch->createView();
        if($formSearch->isSubmitted()&& $formSearch->isValid())
            $data['abonnements'] = $this->repository->search($search->getNumeroAbonnement(),$search->getNomClient(),$search->getVillage(),$search->getCompteur());
        else
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
            $a->getClient()->setAbonnement($a);

            $em = $this->getDoctrine()->getManager();
            $em->persist($a->getClient());
            $em->persist($a);
            $em->flush();
        }
        return $this->redirectToRoute('liste_abonnement');
    }

    /**
     * @Route("/Abonnement/edit/{id}", name="edit_abonnement")
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function edit($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $a=$em->getRepository(Abonnement::class)->find($id);

        $form=$this->createForm(AbonnementType::class,
            $a,
            array('action'=>$this->generateUrl('update_abonnement',['id'=>$id]))
        );
        $data['form']=$form->createView();
        //Form Recherche
        $search=new PropertySearch();
        $formSearch=$this->createForm(PropertySearchType::class,$search);
        $formSearch->handleRequest($request);
        $data['formSearch']=$formSearch->createView();

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
        $v=$em->getRepository(Abonnement::class)->find($id);
        if($v!=null)
        {
            $em->remove($v);
            $em->flush();
        }
        return $this->redirectToRoute('liste_village');
    }
}
