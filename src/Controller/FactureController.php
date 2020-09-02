<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Client;
use App\Entity\Compteur;
use App\Entity\Facture;
use App\Entity\Releve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    private $c;
    private $factures;
    /**
     * @Route("/Facture/get/{id}", name="liste_factures")
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        $em = $this->getDoctrine()->getManager();
        $this->c=$em->getRepository(Compteur::class)->find($id);
        $data['c'] = $this->c;
        $this->factures=$em->getRepository(Facture::class)->findByAbonnement($id);
        $data['factures'] = $this->factures;
        return $this->render('facture/index.html.twig', $data);
    }

    /**
     * @Route("/Facture/afficher/{id}", name="afficher_facture")
     * @param $id
     */
    public function afficher($id)
    {
        $em = $this->getDoctrine()->getManager();
        $f=$em->getRepository(Facture::class)->find($id);
        $tab=$f->getReleves()->getValues();
        $r=end($tab);
        $c=$em->getRepository(Compteur::class)->find($r->getCompteur()->getId());
        $tab1=$c->getReleves()->getValues();
        array_pop($tab1);
        if(count($tab1)>=1)
        {
            $rb=end($tab1);
            if(!is_null($rb))
            {
                $data['rb'] = $rb;
            }
        }
        $auj=date('u', strtotime('now'));
        if($f->getDateLimite()->format('u')>=$auj)
        {
            $f->setTaxe($f->getMontant()*0.05);
        }
        $cl=$em->getRepository(Client::class)->getByFacture($id);
        $data['cl'] = $cl;
        $data['f'] = $f;
        $data['r'] = $r;
        return $this->render('facture/reglement.html.twig', $data);
    }
    /**
     * @Route("/Facture/regler/{id}", name="regler_facture")
     * @param $id
     */
    public function regler($id)
    {
        $em = $this->getDoctrine()->getManager();
        $c=$em->getRepository(Compteur::class)->getByFacture($id);
        $f=$em->getRepository(Facture::class)->find($id);
        $auj=date('u', strtotime('now'));
        if($f->getDateLimite()->format('u')>=$auj)
        {
            $f->setTaxe($f->getMontant()*0.05);
        }
        $f->setEtat(true);
        $em->flush();
        $data['c'] = $c;
        $data['id'] = $c->getId();
        $this->factures=$em->getRepository(Facture::class)->findByAbonnement($id);
        $data['factures'] = $this->factures;

        return $this->redirectToRoute('liste_factures',$data);
    }

}
