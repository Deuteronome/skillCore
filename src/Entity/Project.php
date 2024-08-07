<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectFrame $projectFrame = null;

    /**
     * @var Collection<int, Validation>
     */
    #[ORM\OneToMany(targetEntity: Validation::class, mappedBy: 'project')]
    private Collection $validation;

    public function __construct()
    {
        $this->validation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getProjectFrame(): ?ProjectFrame
    {
        return $this->projectFrame;
    }

    public function setProjectFrame(?ProjectFrame $projectFrame): static
    {
        $this->projectFrame = $projectFrame;

        return $this;
    }

    /**
     * @return Collection<int, Validation>
     */
    public function getValidation(): Collection
    {
        return $this->validation;
    }

    public function addValidation(Validation $validation): static
    {
        if (!$this->validation->contains($validation)) {
            $this->validation->add($validation);
            $validation->setProject($this);
        }

        return $this;
    }

    public function removeValidation(Validation $validation): static
    {
        if ($this->validation->removeElement($validation)) {
            // set the owning side to null (unless already changed)
            if ($validation->getProject() === $this) {
                $validation->setProject(null);
            }
        }

        return $this;
    }
}
