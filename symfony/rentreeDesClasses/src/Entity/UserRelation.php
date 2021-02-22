<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRelationRepository")
 */
class UserRelation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userRelations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_a;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userRelationsB")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_b;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserA(): ?User
    {
        return $this->user_a;
    }

    public function setUserA(?User $user_a): self
    {
        $this->user_a = $user_a;

        return $this;
    }

    public function getUserB(): ?User
    {
        return $this->user_b;
    }

    public function setUserB(?User $user_b): self
    {
        $this->user_b = $user_b;

        return $this;
    }
}
