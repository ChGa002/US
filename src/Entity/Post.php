<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="date")
     */
    private $datePubli;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $signale = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emplacementPhoto;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="post", orphanRemoval=true, cascade={"persist"})
     */
    private $ressources;

    /**
     * @ORM\ManyToMany(targetEntity=MotCle::class, inversedBy="posts")
     */
    private $motsCles;

    /**
     * @ORM\ManyToMany(targetEntity=Module::class, mappedBy="posts",cascade={"persist"})
     */
    private $modules;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="post", orphanRemoval=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;

    public function __construct()
    {
        $this->ressources = new ArrayCollection();
        $this->motsCles = new ArrayCollection();
        $this->modules = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDatePubli(): ?\DateTimeInterface
    {
        return $this->datePubli;
    }

    public function setDatePubli(\DateTimeInterface $datePubli): self
    {
        $this->datePubli = $datePubli;

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

    public function getSignale(): ?bool
    {
        return $this->signale;
    }

    public function setSignale(bool $signale): self
    {
        $this->signale = $signale;

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
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setPost($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getPost() === $this) {
                $ressource->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MotCle[]
     */
    public function getMotsCles(): Collection
    {
        return $this->motsCles;
    }

    public function addMotsCle(MotCle $motsCle): self
    {
        if (!$this->motsCles->contains($motsCle)) {
            $this->motsCles[] = $motsCle;
        }

        return $this;
    }

    public function removeMotsCle(MotCle $motsCle): self
    {
        $this->motsCles->removeElement($motsCle);

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->addPost($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            $module->removePost($this);
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setPost($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getPost() === $this) {
                $note->setPost(null);
            }
        }

        return $this;
    }

    public function getCreateur(): ?Utilisateur
    {
        return $this->createur;
    }

    public function setCreateur(?Utilisateur $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    // Retourne true si l'utilisateur en question a ce post en favori
    public function estUnFavori(Utilisateur $user): bool
    {
        foreach($user->getPostsFavoris() as $post)
        {
            if ($post == $this) return true;
        }

        return false;
    }
}
