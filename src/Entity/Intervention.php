<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterventionRepository")
 * @ORM\Table(name="tbl_intervention")
 */
class Intervention
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $deposit_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $return_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OperatingSystem", inversedBy="interventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operating_system;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment", inversedBy="interventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Task", inversedBy="interventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tasks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="interventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $equipment_complete;

    /**
     * @ORM\OneToOne(targetEntity=InterventionReport::class, inversedBy="intervention", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $intervention_report;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $total_price;

    /**
     * @ORM\OneToMany(targetEntity=BillingLine::class, mappedBy="intervention")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billing_lines;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->setDepositDate(new \DateTime());
        $this->setStatus('En attente');
        $this->billing_lines = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepositDate(): ?\DateTimeInterface
    {
        return $this->deposit_date;
    }

    public function setDepositDate(\DateTimeInterface $deposit_date): self
    {
        $this->deposit_date = $deposit_date;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->return_date;
    }

    public function setReturnDate(?\DateTimeInterface $return_date): self
    {
        $this->return_date = $return_date;

        return $this;
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

    public function getOperatingSystem(): ?OperatingSystem
    {
        return $this->operating_system;
    }

    public function setOperatingSystem(?OperatingSystem $operating_system): self
    {
        $this->operating_system = $operating_system;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): \Doctrine\Common\Collections\Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEquipmentComplete(): ?string
    {
        return $this->equipment_complete;
    }

    public function setEquipmentComplete(string $equipment_complete): self
    {
        $this->equipment_complete = $equipment_complete;

        return $this;
    }

    public function getInterventionReport(): ?InterventionReport
    {
        return $this->intervention_report;
    }

    public function setInterventionReport(InterventionReport $intervention_report): self
    {
        $this->intervention_report = $intervention_report;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->total_price;
    }

    public function setTotalPrice(string $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    /**
     * @return Collection|BillingLine[]
     */
    public function getBillingLines(): \Doctrine\Common\Collections\Collection
    {
        return $this->billing_lines;
    }

    public function addBillingLine(BillingLine $billingLine): self
    {
        if (!$this->billing_lines->contains($billingLine)) {
            $this->billing_lines[] = $billingLine;
            $billingLine->setIntervention($this);
        }

        return $this;
    }

    public function removeBillingLine(BillingLine $billingLine): self
    {
        if ($this->billing_lines->contains($billingLine)) {
            $this->billing_lines->removeElement($billingLine);
            // set the owning side to null (unless already changed)
            if ($billingLine->getIntervention() === $this) {
                $billingLine->setIntervention(null);
            }
        }

        return $this;
    }
}
