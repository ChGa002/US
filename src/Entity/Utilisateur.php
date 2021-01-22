<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $derniereConnexion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valide;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emplacementPhoto;

    /**
     * @ORM\ManyToMany(targetEntity=Semestre::class)
     */
    private $semestresFavoris;

    /**
     * @ORM\ManyToMany(targetEntity=Module::class)
     */
    private $modulesFavoris;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class)
     */
    private $postsFavoris;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class)
     */
    private $utilisateursFavoris;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="createur", orphanRemoval=true)
     */
    private $posts;

    public function __construct()
    {
        $this->semestresFavoris = new ArrayCollection();
        $this->modulesFavoris = new ArrayCollection();
        $this->postsFavoris = new ArrayCollection();
        $this->utilisateursFavoris = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getDerniereConnexion(): ?\DateTimeInterface
    {
        return $this->derniereConnexion;
    }

    public function setDerniereConnexion(?\DateTimeInterface $derniereConnexion): self
    {
        $this->derniereConnexion = $derniereConnexion;

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(?string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getEmplacementPhoto(): ?string
    {
        return $this->emplacementPhoto;
    }

    public function setEmplacementPhoto(?string $emplacementPhoto): self
    {
        $this->emplacementPhoto = $emplacementPhoto;

        return $this;
    }

    /**
     * @return Collection|Semestre[]
     */
    public function getSemestresFavoris(): Collection
    {
        return $this->semestresFavoris;
    }

    public function addSemestresFavori(Semestre $semestresFavori): self
    {
        if (!$this->semestresFavoris->contains($semestresFavori)) {
            $this->semestresFavoris[] = $semestresFavori;
        }

        return $this;
    }

    public function removeSemestresFavori(Semestre $semestresFavori): self
    {
        $this->semestresFavoris->removeElement($semestresFavori);

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModulesFavoris(): Collection
    {
        return $this->modulesFavoris;
    }

    public function addModulesFavori(Module $modulesFavori): self
    {
        if (!$this->modulesFavoris->contains($modulesFavori)) {
            $this->modulesFavoris[] = $modulesFavori;
        }

        return $this;
    }

    public function removeModulesFavori(Module $modulesFavori): self
    {
        $this->modulesFavoris->removeElement($modulesFavori);

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostsFavoris(): Collection
    {
        return $this->postsFavoris;
    }

    public function addPostsFavori(Post $postsFavori): self
    {
        if (!$this->postsFavoris->contains($postsFavori)) {
            $this->postsFavoris[] = $postsFavori;
        }

        return $this;
    }

    public function removePostsFavori(Post $postsFavori): self
    {
        $this->postsFavoris->removeElement($postsFavori);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUtilisateursFavoris(): Collection
    {
        return $this->utilisateursFavoris;
    }

    public function addUtilisateursFavori(self $utilisateursFavori): self
    {
        if (!$this->utilisateursFavoris->contains($utilisateursFavori)) {
            $this->utilisateursFavoris[] = $utilisateursFavori;
        }

        return $this;
    }

    public function removeUtilisateursFavori(self $utilisateursFavori): self
    {
        $this->utilisateursFavoris->removeElement($utilisateursFavori);

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCreateur($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getCreateur() === $this) {
                $post->setCreateur(null);
            }
        }

        return $this;
    }
}
