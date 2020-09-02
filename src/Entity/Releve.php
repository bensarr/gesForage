<?php

namespace App\Entity;

use App\Repository\ReleveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReleveRepository::class)
 */
class Releve
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $valeurEnChiffre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valeurEnLettre;

    /**
     * @ORM\ManyToOne(targetEntity=Compteur::class, inversedBy="releves")
     */
    private $compteur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="releves")
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="releves")
     */
    private $Facture;

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getValeurEnChiffre(): ?string
    {
        return $this->valeurEnChiffre;
    }

    public function setValeurEnChiffre(string $valeurEnChiffre): self
    {
        $this->valeurEnChiffre = $valeurEnChiffre;

        return $this;
    }

    public function getValeurEnLettre(): ?string
    {
        return $this->valeurEnLettre;
    }

    public function setValeurEnLettre(string $valeurEnLettre): self
    {
        $this->valeurEnLettre = $valeurEnLettre;

        return $this;
    }

    public function getCompteur(): ?Compteur
    {
        return $this->compteur;
    }

    public function setCompteur(?Compteur $compteur): self
    {
        $this->compteur = $compteur;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->Facture;
    }

    public function setFacture(?Facture $Facture): self
    {
        $this->Facture = $Facture;

        return $this;
    }
    function datefr()
    {
        $Mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        //$madate=new \DateTime(date("Y-m-t",date($this->date->format('Y-m-t'))));
        $madate=\DateTime::createFromFormat('d-m-Y',$this->date->format('d-m-Y'));
        $m = $madate->format("d")." ".$Mois[$madate->format("m")-1]." ".$madate->format("Y");
        return $m;
    }
}
