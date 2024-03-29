<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     */
    private $typeDeFichier;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $emplacement;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="ressources", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

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

    public function getTypeDeFichier(): ?string
    {
        return $this->typeDeFichier;
    }

    public function setTypeDeFichier(string $typeDeFichier): self
    {
        $this->typeDeFichier = $typeDeFichier;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function __toString()
    {
        return $this->emplacement;
    }

}
