<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Domain $domain = null;

    /**
     * @var Collection<int, Descriptor>
     */
    #[ORM\OneToMany(targetEntity: Descriptor::class, mappedBy: 'skill')]
    private Collection $descriptors;

    /**
     * @var Collection<int, ProjectFrame>
     */
    #[ORM\ManyToMany(targetEntity: ProjectFrame::class, mappedBy: 'targetSkill')]
    private Collection $projectFrames;

    public function __construct()
    {
        $this->descriptors = new ArrayCollection();
        $this->projectFrames = new ArrayCollection();
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

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection<int, Descriptor>
     */
    public function getDescriptors(): Collection
    {
        return $this->descriptors;
    }

    public function addDescriptor(Descriptor $descriptor): static
    {
        if (!$this->descriptors->contains($descriptor)) {
            $this->descriptors->add($descriptor);
            $descriptor->setSkill($this);
        }

        return $this;
    }

    public function removeDescriptor(Descriptor $descriptor): static
    {
        if ($this->descriptors->removeElement($descriptor)) {
            // set the owning side to null (unless already changed)
            if ($descriptor->getSkill() === $this) {
                $descriptor->setSkill(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProjectFrame>
     */
    public function getProjectFrames(): Collection
    {
        return $this->projectFrames;
    }

    public function addProjectFrame(ProjectFrame $projectFrame): static
    {
        if (!$this->projectFrames->contains($projectFrame)) {
            $this->projectFrames->add($projectFrame);
            $projectFrame->addTargetSkill($this);
        }

        return $this;
    }

    public function removeProjectFrame(ProjectFrame $projectFrame): static
    {
        if ($this->projectFrames->removeElement($projectFrame)) {
            $projectFrame->removeTargetSkill($this);
        }

        return $this;
    }
}
