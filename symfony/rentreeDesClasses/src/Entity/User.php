<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profile_pic;

    /**
     * @ORM\Column(type="date")
     */
    private $dob;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street_num;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zip;

    /**
     * @ORM\Column(type="integer")
     */
    private $search_range;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ethnicity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hair;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserRelation", mappedBy="user_a")
     */
    private $userRelations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserRelation", mappedBy="user_b")
     */
    private $userRelationsB;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RelationRequest", mappedBy="sender")
     */
    private $requestsSent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RelationRequest", mappedBy="receiver")
     */
    private $requestsReceived;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conversation", mappedBy="userA")
     */
    private $conversations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender")
     */
    private $messages;

    public function __construct()
    {
        $this->userRelations = new ArrayCollection();
        $this->userRelationsB = new ArrayCollection();
        $this->requestsSent = new ArrayCollection();
        $this->requestsReceived = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profile_pic;
    }

    public function setProfilePic(string $profile_pic): self
    {
        $this->profile_pic = $profile_pic;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNum(): ?string
    {
        return $this->street_num;
    }

    public function setStreetNum(string $street_num): self
    {
        $this->street_num = $street_num;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getSearchRange(): ?int
    {
        return $this->search_range;
    }

    public function setSearchRange(int $search_range): self
    {
        $this->search_range = $search_range;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getEthnicity(): ?string
    {
        return $this->ethnicity;
    }

    public function setEthnicity(string $ethnicity): self
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    public function getHair(): ?string
    {
        return $this->hair;
    }

    public function setHair(string $hair): self
    {
        $this->hair = $hair;

        return $this;
    }

    /**
     * @return Collection|UserRelation[]
     */
    public function getUserRelations(): Collection
    {
        return $this->userRelations;
    }

    public function addUserRelation(UserRelation $userRelation): self
    {
        if (!$this->userRelations->contains($userRelation)) {
            $this->userRelations[] = $userRelation;
            $userRelation->setUserA($this);
        }

        return $this;
    }

    public function removeUserRelation(UserRelation $userRelation): self
    {
        if ($this->userRelations->contains($userRelation)) {
            $this->userRelations->removeElement($userRelation);
            // set the owning side to null (unless already changed)
            if ($userRelation->getUserA() === $this) {
                $userRelation->setUserA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserRelation[]
     */
    public function getUserRelationsB(): Collection
    {
        return $this->userRelationsB;
    }

    public function addUserRelationsB(UserRelation $userRelationsB): self
    {
        if (!$this->userRelationsB->contains($userRelationsB)) {
            $this->userRelationsB[] = $userRelationsB;
            $userRelationsB->setUserB($this);
        }

        return $this;
    }

    public function removeUserRelationsB(UserRelation $userRelationsB): self
    {
        if ($this->userRelationsB->contains($userRelationsB)) {
            $this->userRelationsB->removeElement($userRelationsB);
            // set the owning side to null (unless already changed)
            if ($userRelationsB->getUserB() === $this) {
                $userRelationsB->setUserB(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RelationRequest[]
     */
    public function getRequestsSent(): Collection
    {
        return $this->requestsSent;
    }

    public function addRequestsSent(RelationRequest $requestsSent): self
    {
        if (!$this->requestsSent->contains($requestsSent)) {
            $this->requestsSent[] = $requestsSent;
            $requestsSent->setSender($this);
        }

        return $this;
    }

    public function removeRequestsSent(RelationRequest $requestsSent): self
    {
        if ($this->requestsSent->contains($requestsSent)) {
            $this->requestsSent->removeElement($requestsSent);
            // set the owning side to null (unless already changed)
            if ($requestsSent->getSender() === $this) {
                $requestsSent->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RelationRequest[]
     */
    public function getRequestsReceived(): Collection
    {
        return $this->requestsReceived;
    }

    public function addRequestsReceived(RelationRequest $requestsReceived): self
    {
        if (!$this->requestsReceived->contains($requestsReceived)) {
            $this->requestsReceived[] = $requestsReceived;
            $requestsReceived->setReceiver($this);
        }

        return $this;
    }

    public function removeRequestsReceived(RelationRequest $requestsReceived): self
    {
        if ($this->requestsReceived->contains($requestsReceived)) {
            $this->requestsReceived->removeElement($requestsReceived);
            // set the owning side to null (unless already changed)
            if ($requestsReceived->getReceiver() === $this) {
                $requestsReceived->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
            $conversation->setUserA($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->contains($conversation)) {
            $this->conversations->removeElement($conversation);
            // set the owning side to null (unless already changed)
            if ($conversation->getUserA() === $this) {
                $conversation->setUserA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    public function getAge()
    {
        $now = new \DateTime('now');
        $age = $this->getDob();
        $difference = $now->diff($age);

        return $difference->format('%y ans');
    }
}
