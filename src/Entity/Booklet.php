<?php

namespace App\Entity;

use App\Repository\BookletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookletRepository::class)
 * @UniqueEntity(fields={"title"}, message="Il existe déjà une brochure avec ce nom")
 * @ORM\Table(name="tbl_booklet")
 */
class Booklet
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
     * @ORM\ManyToMany(targetEntity=InterventionReport::class, mappedBy="booklets")
     */
    private $interventionReports;

    public function __construct()
    {
        $this->interventionReports = new ArrayCollection();
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

    /**
     * @return Collection|InterventionReport[]
     */
    public function getInterventionReports(): \Doctrine\Common\Collections\Collection
    {
        return $this->interventionReports;
    }

    public function addInterventionReport(InterventionReport $interventionReport): self
    {
        if (!$this->interventionReports->contains($interventionReport)) {
            $this->interventionReports[] = $interventionReport;
            $interventionReport->addBooklet($this);
        }

        return $this;
    }

    public function removeInterventionReport(InterventionReport $interventionReport): self
    {
        if ($this->interventionReports->contains($interventionReport)) {
            $this->interventionReports->removeElement($interventionReport);
            $interventionReport->removeBooklet($this);
        }

        return $this;
    }
}
