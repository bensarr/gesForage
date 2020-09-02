<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
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
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $pu;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $montant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=Releve::class, mappedBy="Facture")
     */
    private $releves;

    /**
     * @ORM\Column(type="date")
     */
    private $dateLimite;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="factures")
     */
    private $user;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $taxe;

    public function __construct()
    {
        $this->releves = new ArrayCollection();
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

    public function getPu(): ?string
    {
        return $this->pu;
    }

    public function setPu(string $pu): self
    {
        $this->pu = $pu;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

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
            $relefe->setFacture($this);
        }

        return $this;
    }

    public function removeRelefe(Releve $relefe): self
    {
        if ($this->releves->contains($relefe)) {
            $this->releves->removeElement($relefe);
            // set the owning side to null (unless already changed)
            if ($relefe->getFacture() === $this) {
                $relefe->setFacture(null);
            }
        }

        return $this;
    }

    public function getDateLimite(): ?\DateTimeInterface
    {
        return $this->dateLimite;
    }

    public function setDateLimite(\DateTimeInterface $dateLimite): self
    {
        $this->dateLimite = $dateLimite;

        return $this;
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

    public function getTaxe(): ?string
    {
        return $this->taxe;
    }

    public function setTaxe(string $taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }
    function datefr()
    {
        $Mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        //$madate=new \DateTime(date("Y-m-t",date($this->date->format('Y-m-t'))));
        $madate=\DateTime::createFromFormat('d-m-Y',$this->dateLimite->format('d-m-Y'));
        $m = $madate->format("d")." ".$Mois[$madate->format("m")-1]." ".$madate->format("Y");
        return $m;
    }
}
