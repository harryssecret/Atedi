<?php

namespace App\Entity;

use App\Repository\SoftwareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoftwareRepository::class)
 * @UniqueEntity(fields={"title"}, message="Il existe déjà un logiciel avec ce nom")
 * @ORM\Table(name="tbl_software")
 */
class Software
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=SoftwareInterventionReport::class, mappedBy="software", orphanRemoval=true)
     */
    private $softwareInterventionReports;

    public function __construct()
    {
        $this->interventionReports = new ArrayCollection();
        $this->softwareInterventionReports = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|SoftwareInterventionReport[]
     */
    public function getSoftwareInterventionReports(): \Doctrine\Common\Collections\Collection
    {
        return $this->softwareInterventionReports;
    }

    public function addSoftwareInterventionReport(SoftwareInterventionReport $softwareInterventionReport): self
    {
        if (!$this->softwareInterventionReports->contains($softwareInterventionReport)) {
            $this->softwareInterventionReports[] = $softwareInterventionReport;
            $softwareInterventionReport->setSoftware($this);
        }

        return $this;
    }

    public function removeSoftwareInterventionReport(SoftwareInterventionReport $softwareInterventionReport): self
    {
        if ($this->softwareInterventionReports->contains($softwareInterventionReport)) {
            $this->softwareInterventionReports->removeElement($softwareInterventionReport);
            // set the owning side to null (unless already changed)
            if ($softwareInterventionReport->getSoftware() === $this) {
                $softwareInterventionReport->setSoftware(null);
            }
        }

        return $this;
    }
}
