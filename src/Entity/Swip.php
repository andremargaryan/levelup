<?php

namespace App\Entity;

use App\Repository\SwipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SwipRepository::class)]
class Swip
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Offre::class, inversedBy: 'swips')]
    #[ORM\JoinColumn(nullable: false)]
    private Offre $offre;

    #[ORM\Column(type: 'boolean')]
    private bool $liked; // true = like, false = dislike

    #[ORM\Column(type: 'datetime')]
    private \DateTime $swipedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getOffre(): Offre
    {
        return $this->offre;
    }

    public function setOffre(Offre $offre): static
    {
        $this->offre = $offre;
        return $this;
    }

    public function isLiked(): bool
    {
        return $this->liked;
    }

    public function setLiked(bool $liked): static
    {
        $this->liked = $liked;
        return $this;
    }

    public function getSwipedAt(): \DateTime
    {
        return $this->swipedAt;
    }

    public function setSwipedAt(\DateTime $swipedAt): static
    {
        $this->swipedAt = $swipedAt;
        return $this;
    }
}
