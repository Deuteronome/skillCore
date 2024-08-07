<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
#[UniqueEntity('name')]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true, options:['default' => 'default.webp'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    /**
     * @var Collection<int, Site>
     */
    #[ORM\OneToMany(targetEntity: Site::class, mappedBy: 'structure')]
    private Collection $sites;

    /**
     * @var Collection<int, SkillFramework>
     */
    #[ORM\ManyToMany(targetEntity: SkillFramework::class, mappedBy: 'structures')]
    private Collection $skillFrameworks;

    public function __construct()
    {
        $this->logo = 'default.webp';
        $this->sites = new ArrayCollection();
        $this->skillFrameworks = new ArrayCollection();
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): static
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
            $site->setStructure($this);
        }

        return $this;
    }

    public function removeSite(Site $site): static
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getStructure() === $this) {
                $site->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SkillFramework>
     */
    public function getSkillFrameworks(): Collection
    {
        return $this->skillFrameworks;
    }

    public function addSkillFramework(SkillFramework $skillFramework): static
    {
        if (!$this->skillFrameworks->contains($skillFramework)) {
            $this->skillFrameworks->add($skillFramework);
            $skillFramework->addStructure($this);
        }

        return $this;
    }

    public function removeSkillFramework(SkillFramework $skillFramework): static
    {
        if ($this->skillFrameworks->removeElement($skillFramework)) {
            $skillFramework->removeStructure($this);
        }

        return $this;
    }
}
