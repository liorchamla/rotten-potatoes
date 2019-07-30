<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poster;

    /**
     * @ORM\Column(type="datetime")
     */
    private $releasedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $synopsis;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="movies")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\People", mappedBy="actedIn")
     */
    private $actors;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\People", inversedBy="directed", fetch="EAGER")
     */
    private $director;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rating", mappedBy="movie", fetch="EAGER")
     */
    private $ratings;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    public function getAvgRatings(): float
    {
        return array_reduce(
            $this->ratings->toArray(),
            function ($total, Rating $rating) {
                return $total + $rating->getNotation();
            },
            0
        ) / count($this->ratings);
    }

    public function getSomeActors(?int $count = 3): array
    {
        return $this->actors->slice(0, $count);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeInterface
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeInterface $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|People[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(People $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
            $actor->addActedIn($this);
        }

        return $this;
    }

    public function removeActor(People $actor): self
    {
        if ($this->actors->contains($actor)) {
            $this->actors->removeElement($actor);
            $actor->removeActedIn($this);
        }

        return $this;
    }

    public function getDirector(): ?People
    {
        return $this->director;
    }

    public function setDirector(?People $director): self
    {
        $this->director = $director;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setMovie($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getMovie() === $this) {
                $rating->setMovie(null);
            }
        }

        return $this;
    }
}
