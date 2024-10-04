<?php

namespace App\Entity;

use App\Repository\AssignmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssignmentRepository::class)
 */
class Assignment
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
    private $assignmentName;

    /**
     * @ORM\Column(type="date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="assignments")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentAsmDetails", mappedBy="assignment")
     */
    private $studentAsmDetails;

    public function __construct()
    {
        $this->studentAsmDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssignmentName(): ?string
    {
        return $this->assignmentName;
    }

    public function setAssignmentName(string $assignmentName): self
    {
        $this->assignmentName = $assignmentName;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection|StudentAsmDetails[]
     */
    public function getStudentAsmDetails(): Collection
    {
        return $this->studentAsmDetails;
    }

    public function addStudentAsmDetail(StudentAsmDetails $studentAsmDetail): self
    {
        if (!$this->studentAsmDetails->contains($studentAsmDetail)) {
            $this->studentAsmDetails[] = $studentAsmDetail;
            $studentAsmDetail->setAssignment($this);
        }

        return $this;
    }

    public function removeStudentAsmDetail(StudentAsmDetails $studentAsmDetail): self
    {
        if ($this->studentAsmDetails->removeElement($studentAsmDetail)) {
            // set the owning side to null (unless already changed)
            if ($studentAsmDetail->getAssignment() === $this) {
                $studentAsmDetail->setAssignment(null);
            }
        }

        return $this;
    }
}
