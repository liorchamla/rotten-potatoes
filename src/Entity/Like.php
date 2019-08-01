<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 * @ORM\Table(name="`like`")
 */
class Like
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $positive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rating", inversedBy="likes")
     */
    private $rating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likes")
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPositive(): ?bool
    {
        return $this->positive;
    }

    public function setPositive(bool $positive): self
    {
        $this->positive = $positive;

        return $this;
    }

    public function getRating(): ?Rating
    {
        return $this->rating;
    }

    public function setRating(?Rating $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
