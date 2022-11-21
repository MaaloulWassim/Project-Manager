<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom_project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="startp")
     *  @ORM\Column(type="json")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pmembers=[];

    /**
     * @ORM\OneToMany(targetEntity=Tasks::class, mappedBy="project_tasks", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $ptasks;

    public function __construct()
    {
        $this->pmembers = new ArrayCollection();
        $this->ptasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumProject(): ?int
    {
        return $this->num_project;
    }

    public function setNumProject(int $num_project): self
    {
        $this->num_project = $num_project;

        return $this;
    }

    public function getNomProject(): ?string
    {
        return $this->Nom_project;
    }

    public function setNomProject(string $Nom_project): self
    {
        $this->Nom_project = $Nom_project;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPmembers(): ArrayCollection
    {
        return $this->pmembers;
    }

    /**
     * @param ArrayCollection $pmembers
     */
    public function setPmembers(ArrayCollection $pmembers): void
    {
        $this->pmembers = $pmembers;
    }


    /**
     * @return Collection|Tasks[]
     */
    public function getPtasks(): Collection
    {
        return $this->ptasks;
    }

    public function addPtask(Tasks $ptask): self
    {
        if (!$this->ptasks->contains($ptask)) {
            $this->ptasks[] = $ptask;
            $ptask->setProjectTasks($this);
        }

        return $this;
    }

    public function removePtask(Tasks $ptask): self
    {
        if ($this->ptasks->removeElement($ptask)) {
            // set the owning side to null (unless already changed)
            if ($ptask->getProjectTasks() === $this) {
                $ptask->setProjectTasks(null);
            }
        }

        return $this;
    }
}
