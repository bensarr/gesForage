<?php

namespace App\Entity;

use App\Repository\CompteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompteurRepository::class)
 */
class Compteur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $numero;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=Releve::class, mappedBy="compteur")
     */
    private $releves;
    /**
     * @ORM\OneToOne(targetEntity=Abonnement::class, cascade={"persist", "remove"})
     */
    private $abonnement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="compteurs")
     */
    private $user;

    public function __construct()
    {
        $this->releves = new ArrayCollection();
    }

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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Releve[]
     */
    public function getReleves(): Collection
    {
        return $this->releves;
    }

    public function addRelefe(Releve $relefe): self
    {
        if (!$this->releves->contains($relefe)) {
            $this->releves[] = $relefe;
            $relefe->setCompteur($this);
        }

        return $this;
    }

    public function removeRelefe(Releve $relefe): self
    {
        if ($this->releves->contains($relefe)) {
            $this->releves->removeElement($relefe);
            // set the owning side to null (unless already changed)
            if ($relefe->getCompteur() === $this) {
                $relefe->setCompteur(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAbonnement()
    {
        return $this->abonnement;
    }

    /**
     * @param mixed $abonnement
     */
    public function setAbonnement($abonnement): void
    {
        $this->abonnement = $abonnement;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return $this->numero;
    }

}
