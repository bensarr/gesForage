<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity=Roles::class, inversedBy="users")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Chef::class, mappedBy="user")
     */
    private $chefs;

    /**
     * @ORM\OneToMany(targetEntity=Village::class, mappedBy="user")
     */
    private $villages;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="user")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=Abonnement::class, mappedBy="user")
     */
    private $abonnements;

    /**
     * @ORM\OneToMany(targetEntity=Compteur::class, mappedBy="user")
     */
    private $compteurs;

    /**
     * @ORM\OneToMany(targetEntity=Releve::class, mappedBy="User")
     */
    private $releves;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="user")
     */
    private $factures;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->chefs = new ArrayCollection();
        $this->villages = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->abonnements = new ArrayCollection();
        $this->compteurs = new ArrayCollection();
        $this->releves = new ArrayCollection();
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        $roles = array();
        foreach ($this->roles as $r)
        {
            $roles[]=$r->getName();
        }
        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addRole(Roles $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Roles $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Chef[]
     */
    public function getChefs(): Collection
    {
        return $this->chefs;
    }

    public function addChef(Chef $chef): self
    {
        if (!$this->chefs->contains($chef)) {
            $this->chefs[] = $chef;
            $chef->setUser($this);
        }

        return $this;
    }

    public function removeChef(Chef $chef): self
    {
        if ($this->chefs->contains($chef)) {
            $this->chefs->removeElement($chef);
            // set the owning side to null (unless already changed)
            if ($chef->getUser() === $this) {
                $chef->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Village[]
     */
    public function getVillages(): Collection
    {
        return $this->villages;
    }

    public function addVillage(Village $village): self
    {
        if (!$this->villages->contains($village)) {
            $this->villages[] = $village;
            $village->setUser($this);
        }

        return $this;
    }

    public function removeVillage(Village $village): self
    {
        if ($this->villages->contains($village)) {
            $this->villages->removeElement($village);
            // set the owning side to null (unless already changed)
            if ($village->getUser() === $this) {
                $village->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setUser($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getUser() === $this) {
                $client->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Abonnement[]
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(Abonnement $abonnement): self
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements[] = $abonnement;
            $abonnement->setUser($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnement $abonnement): self
    {
        if ($this->abonnements->contains($abonnement)) {
            $this->abonnements->removeElement($abonnement);
            // set the owning side to null (unless already changed)
            if ($abonnement->getUser() === $this) {
                $abonnement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Compteur[]
     */
    public function getCompteurs(): Collection
    {
        return $this->compteurs;
    }

    public function addCompteur(Compteur $compteur): self
    {
        if (!$this->compteurs->contains($compteur)) {
            $this->compteurs[] = $compteur;
            $compteur->setUser($this);
        }

        return $this;
    }

    public function removeCompteur(Compteur $compteur): self
    {
        if ($this->compteurs->contains($compteur)) {
            $this->compteurs->removeElement($compteur);
            // set the owning side to null (unless already changed)
            if ($compteur->getUser() === $this) {
                $compteur->setUser(null);
            }
        }

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
            $relefe->setUser($this);
        }

        return $this;
    }

    public function removeRelefe(Releve $relefe): self
    {
        if ($this->releves->contains($relefe)) {
            $this->releves->removeElement($relefe);
            // set the owning side to null (unless already changed)
            if ($relefe->getUser() === $this) {
                $relefe->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setUser($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->contains($facture)) {
            $this->factures->removeElement($facture);
            // set the owning side to null (unless already changed)
            if ($facture->getUser() === $this) {
                $facture->setUser(null);
            }
        }

        return $this;
    }

}
