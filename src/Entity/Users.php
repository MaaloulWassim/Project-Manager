<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @return string
     */
    public function getUsertype(): string
    {
        return $this->usertype;
    }

    /**
     * @param string $usertype
     */
    public function setUsertype(string $usertype): void
    {
        $this->usertype = $usertype;
    }

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $usertype;

    /**
     * @ORM\OneToMany(targetEntity=Messagerie::class, mappedBy="sender")
     */
    private $sent;

    /**
     * @ORM\OneToMany(targetEntity=Messagerie::class, mappedBy="recipient", orphanRemoval=true)
     */
    private $received;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="pmembers")
     */
    private $startp;


    /**
     * @ORM\OneToMany(targetEntity=Tasks::class, mappedBy="tmaker")
     */
    private $usertask;

    public function __construct()
    {
        $this->sent = new ArrayCollection();
        $this->received = new ArrayCollection();
        $this->usertask = new ArrayCollection();
        $this->startp=new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->email;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Messagerie[]
     */
    public function getSent(): Collection
    {
        return $this->sent;
    }

    public function addSent(Messagerie $sent): self
    {
        if (!$this->sent->contains($sent)) {
            $this->sent[] = $sent;
            $sent->setSender($this);
        }

        return $this;
    }

    public function removeSent(Messagerie $sent): self
    {
        if ($this->sent->removeElement($sent)) {
            // set the owning side to null (unless already changed)
            if ($sent->getSender() === $this) {
                $sent->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Messagerie[]
     */
    public function getReceived(): Collection
    {
        return $this->received;
    }

    public function addReceived(Messagerie $received): self
    {
        if (!$this->received->contains($received)) {
            $this->received[] = $received;
            $received->setRecipient($this);
        }

        return $this;
    }

    public function removeReceived(Messagerie $received): self
    {
        if ($this->received->removeElement($received)) {
            // set the owning side to null (unless already changed)
            if ($received->getRecipient() === $this) {
                $received->setRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getStartp(): self
    {
        return $this->startp;
    }

    public function setStartp(Project $startp): self
    {
        $this->startp = $startp;

        return $this;
    }

    /**
     * @return Collection|Tasks[]
     */
    public function getUsertask(): Collection
    {
        return $this->usertask;
    }

    public function addUsertask(Tasks $usertask): self
    {
        if (!$this->usertask->contains($usertask)) {
            $this->usertask[] = $usertask;
            $usertask->setTmaker($this);
        }

        return $this;
    }

    public function removeUsertask(Tasks $usertask): self
    {
        if ($this->usertask->removeElement($usertask)) {
            // set the owning side to null (unless already changed)
            if ($usertask->getTmaker() === $this) {
                $usertask->setTmaker(null);
            }
        }

        return $this;
    }
}
