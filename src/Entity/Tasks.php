<?php

namespace App\Entity;

use App\Entity\Users;
use App\Repository\TasksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=TasksRepository::class)
 */
class Tasks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $task_statue = False;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="usertask")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tmaker;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="ptasks")
     * @ORM\JoinColumn(nullable=true)
     */
    private $project_tasks;

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

    public function getTaskStatue(): ?bool
    {
        return $this->task_statue;
    }

    public function setTaskStatue(bool $task_statue): self
    {
        $this->task_statue = $task_statue;

        return $this;
    }

    public function getTmaker(): ?Users
    {
        return $this->tmaker;
    }

    public function setTmaker(?Users $tmaker): self
    {
        $this->tmaker = $tmaker;
        return $this;
    }

    public function getProjectTasks(): ?Project
    {
        return $this->project_tasks;
    }

    public function setProjectTasks(?Project $project_tasks): self
    {
        $this->project_tasks = $project_tasks;
        return $this;
    }

}
