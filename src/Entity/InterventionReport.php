<?php

namespace App\Entity;

use App\Repository\InterventionReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InterventionReportRepository::class)
 * @ORM\Table(name="tbl_intervention_report")
 */
class InterventionReport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToOne(targetEntity=Intervention::class, mappedBy="intervention_report", cascade={"persist", "remove"})
     */
    private $intervention;

    /**
     * @ORM\Column(type="integer")
     */
    private $step;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $severity;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $windows_install = [];

    /**
     * @ORM\ManyToMany(targetEntity=Booklet::class, inversedBy="interventionReports")
     */
    private $booklets;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $severity_problem = [];

    /**
     * @ORM\ManyToMany(targetEntity=Action::class, inversedBy="interventionReports")
     */
    private $actions;

    /**
     * @ORM\OneToMany(targetEntity=SoftwareInterventionReport::class, mappedBy="intervention_report", orphanRemoval=true)
     */
    private $softwareInterventionReports;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $internal_analysis;

    /**
     * @ORM\ManyToMany(targetEntity=Technician::class, inversedBy="interventionReports")
     */
    private $technicians;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $windows_version;

    public function __construct()
    {
        $this->softwares = new ArrayCollection();
        $this->booklets = new ArrayCollection();
        $this->actions = new ArrayCollection();
        $this->softwareInterventionReports = new ArrayCollection();
        $this->technicians = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(Intervention $intervention): self
    {
        $this->intervention = $intervention;

        // set the owning side of the relation if necessary
        if ($intervention->getInterventionReport() !== $this) {
            $intervention->setInterventionReport($this);
        }

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getSeverity(): ?string
    {
        return $this->severity;
    }

    public function setSeverity(?string $severity): self
    {
        $this->severity = $severity;

        return $this;
    }

    public function getWindowsInstall(): ?array
    {
        return $this->windows_install;
    }

    public function setWindowsInstall(?array $windows_install): self
    {
        $this->windows_install = $windows_install;

        return $this;
    }

    /**
     * @return Collection|Booklet[]
     */
    public function getBooklets(): \Doctrine\Common\Collections\Collection
    {
        return $this->booklets;
    }

    public function addBooklet(Booklet $booklet): self
    {
        if (!$this->booklets->contains($booklet)) {
            $this->booklets[] = $booklet;
        }

        return $this;
    }

    public function removeBooklet(Booklet $booklet): self
    {
        if ($this->booklets->contains($booklet)) {
            $this->booklets->removeElement($booklet);
        }

        return $this;
    }

    public function getSeverityProblem(): ?array
    {
        return $this->severity_problem;
    }

    public function setSeverityProblem(?array $severity_problem): self
    {
        $this->severity_problem = $severity_problem;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): \Doctrine\Common\Collections\Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
        }

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
            $softwareInterventionReport->setInterventionReport($this);
        }

        return $this;
    }

    public function removeSoftwareInterventionReport(SoftwareInterventionReport $softwareInterventionReport): self
    {
        if ($this->softwareInterventionReports->contains($softwareInterventionReport)) {
            $this->softwareInterventionReports->removeElement($softwareInterventionReport);
            // set the owning side to null (unless already changed)
            if ($softwareInterventionReport->getInterventionReport() === $this) {
                $softwareInterventionReport->setInterventionReport(null);
            }
        }

        return $this;
    }

    public function getInternalAnalysis(): ?string
    {
        return $this->internal_analysis;
    }

    public function setInternalAnalysis(?string $internal_analysis): self
    {
        $this->internal_analysis = $internal_analysis;

        return $this;
    }

    /**
     * @return Collection|Technician[]
     */
    public function getTechnicians(): \Doctrine\Common\Collections\Collection
    {
        return $this->technicians;
    }

    public function addTechnician(Technician $technician): self
    {
        if (!$this->technicians->contains($technician)) {
            $this->technicians[] = $technician;
        }

        return $this;
    }

    public function removeTechnician(Technician $technician): self
    {
        if ($this->technicians->contains($technician)) {
            $this->technicians->removeElement($technician);
        }

        return $this;
    }

    public function getWindowsVersion(): ?string
    {
        return $this->windows_version;
    }

    public function setWindowsVersion(?string $windows_version): self
    {
        $this->windows_version = $windows_version;

        return $this;
    }
}
