<?php

namespace App\Entity;

use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
class Domain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'domains')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SkillFramework $framework = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\OneToMany(targetEntity: Skill::class, mappedBy: 'domain')]
    private Collection $skills;

    /**
     * @var Collection<int, PlanStep>
     */
    #[ORM\ManyToMany(targetEntity: PlanStep::class, mappedBy: 'domain')]
    private Collection $planSteps;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
        $this->planSteps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getFramework(): ?SkillFramework
    {
        return $this->framework;
    }

    public function setFramework(?SkillFramework $framework): static
    {
        $this->framework = $framework;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setDomain($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getDomain() === $this) {
                $skill->setDomain(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlanStep>
     */
    public function getPlanSteps(): Collection
    {
        return $this->planSteps;
    }

    public function addPlanStep(PlanStep $planStep): static
    {
        if (!$this->planSteps->contains($planStep)) {
            $this->planSteps->add($planStep);
            $planStep->addDomain($this);
        }

        return $this;
    }

    public function removePlanStep(PlanStep $planStep): static
    {
        if ($this->planSteps->removeElement($planStep)) {
            $planStep->removeDomain($this);
        }

        return $this;
    }
}
