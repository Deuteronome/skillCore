<?php

namespace App\Entity;

use App\Repository\AlertTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AlertTypeRepository::class)]
#[UniqueEntity('name')]
class AlertType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, AdminAlert>
     */
    #[ORM\OneToMany(targetEntity: AdminAlert::class, mappedBy: 'type')]
    private Collection $adminAlerts;

    public function __construct()
    {
        $this->adminAlerts = new ArrayCollection();
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

    /**
     * @return Collection<int, AdminAlert>
     */
    public function getAdminAlerts(): Collection
    {
        return $this->adminAlerts;
    }

    public function addAdminAlert(AdminAlert $adminAlert): static
    {
        if (!$this->adminAlerts->contains($adminAlert)) {
            $this->adminAlerts->add($adminAlert);
            $adminAlert->setType($this);
        }

        return $this;
    }

    public function removeAdminAlert(AdminAlert $adminAlert): static
    {
        if ($this->adminAlerts->removeElement($adminAlert)) {
            // set the owning side to null (unless already changed)
            if ($adminAlert->getType() === $this) {
                $adminAlert->setType(null);
            }
        }

        return $this;
    }
}
