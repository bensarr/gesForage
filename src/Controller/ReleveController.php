<?php

namespace App\Controller;

use App\Entity\Compteur;
use App\Entity\Releve;
use App\Form\RelevesType;
use DateInterval;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReleveController extends AbstractController
{
    /**
     * @Route("/Releve/get/{id}", name="liste_releve")
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        $em = $this->getDoctrine()->getManager();
        $c=$em->getRepository(Compteur::class)->find($id);
        $r=new Releve();
        $form=$this->createForm(RelevesType::class,
            $r,
            array('action'=>$this->generateUrl('add_releve',['id'=>$id]))
        );
        $data['form']=$form->createView();

        $data['c'] = $c;
        $data['releves'] = $c->getReleves();
        return $this->render('releve/index.html.twig', $data);
    }

    /**
     * @Route("/Releve/add/{id}", name="add_releve")
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function add($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $c=$em->getRepository(Compteur::class)->find($id);
        $r=new Releve();
        $form = $this->createForm(RelevesType::class, $r);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $r = $form->getData();
            $r->setUser($this->getUser());
            $r->getFacture()->setUser($this->getUser());

            $r->getFacture()->setNumero($this->genererChaineAleatoire());

            //Générer Montant(pu*cons)
            $lastReleve=$c->getReleves()->getValues();
            $last=0;
            if(count($lastReleve)>=1)
                $last=array_pop($lastReleve)->getValeurEnChiffre();
            $r->getFacture()->setMontant($r->getFacture()->getPu()*($r->getValeurEnChiffre()-$last));

            //Générer une date
            //$dateLimite=new \DateTime($r->getDate());
            $dateLimite=new \DateTime(date("Y-m-t", strtotime($r->getDate()->format('Y-m-t'))));
            $dateLimite->add(new DateInterval('P5D'));
            $r->getFacture()->setDateLimite(new \DateTime($dateLimite->format('Y-m-d')));

            $r->getFacture()->setEtat(false);
            $r->getFacture()->setTaxe(0);
            $r->setCompteur($c);
            $em->persist($r->getFacture());
            $em->persist($r);
            $em->flush();
        }
        $data['id']=$c->getId();
        return $this->redirectToRoute('liste_releve', $data);
    }
    /**
     * @Route("/Releve/edit/{id}", name="edit_releve")
     */
    public function edit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $r=$em->getRepository(Releve::class)->find($id);


        $form=$this->createForm(RelevesType::class,
            $r,
            array('action'=>$this->generateUrl('update_releve',['id'=>$id]))
        );
        $data['form']=$form->createView();

        $data['c'] = $r->getCompteur();
        $data['releves'] = $r->getCompteur()->getReleves();
        $data['id']=$r->getCompteur()->getId();
        return $this->render('releve/index.html.twig', $data);
    }
    /**
     * @Route("/Releve/update/{id}", name="update_releve")
     */
    public function update($id, Request $request)
    {
        $id=0;
        $r=new Releve();
        $form = $this->createForm(RelevesType::class, $r);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $r = $form->getData();
            $r->setId($id);
            //Récupération valeurs
            $em = $this->getDoctrine()->getManager();
            $releve=$em->getRepository(Releve::class)->find($r->getId());
            $releve->setDate($r->getDate());
            $releve->setValeurEnChiffre($r->getValeurEnChiffre());
            $releve->setValeurEnLettre($r->getValeurEnLettre());
            $em->flush();
            $id=$r->getCompteur()->getId();
        }
        $data['id']=$id;
        return $this->redirectToRoute('liste_releve',$data);
    }
    /**
     * @Route("/Releve/delete/{id}", name="delete_releve")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $r=$em->getRepository(Releve::class)->find($id);
        if($r!=null)
        {
            $id=$r->getCompteur()->getId();
            $em->remove($r);
            $em->flush();
        }
        $data['id']=$id;
        return $this->redirectToRoute('liste_releve',$data);
    }

    function genererChaineAleatoire($longueur = 10)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        $chaineAleatoire = '';
        for ($i = 0; $i < $longueur; $i++)
        {
            $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
        }
        return $chaineAleatoire;
    }
}
