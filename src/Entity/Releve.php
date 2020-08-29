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
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="releves")
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="releves")
     */
    private $User;

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

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

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
}
