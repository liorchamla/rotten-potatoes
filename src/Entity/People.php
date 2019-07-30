<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeopleRepository")
 */
class People
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"firstName","lastName"})
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", inversedBy="actors")
     */
    private $actedIn;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="director")
     */
    private $directed;

    public function __construct()
    {
        $this->actedIn = new ArrayCollection();
        $this->directed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getActedIn(): Collection
    {
        return $this->actedIn;
    }

    public function addActedIn(Movie $actedIn): self
    {
        if (!$this->actedIn->contains($actedIn)) {
            $this->actedIn[] = $actedIn;
        }

        return $this;
    }

    public function removeActedIn(Movie $actedIn): self
    {
        if ($this->actedIn->contains($actedIn)) {
            $this->actedIn->removeElement($actedIn);
        }

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getDirected(): Collection
    {
        return $this->directed;
    }

    public function addDirected(Movie $directed): self
    {
        if (!$this->directed->contains($directed)) {
            $this->directed[] = $directed;
            $directed->setDirector($this);
        }

        return $this;
    }

    public function removeDirected(Movie $directed): self
    {
        if ($this->directed->contains($directed)) {
            $this->directed->removeElement($directed);
            // set the owning side to null (unless already changed)
            if ($directed->getDirector() === $this) {
                $directed->setDirector(null);
            }
        }

        return $this;
    }
}
