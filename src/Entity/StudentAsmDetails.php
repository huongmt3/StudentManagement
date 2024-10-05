<?php

namespace App\Entity;

use App\Repository\StudentAsmDetailsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentAsmDetailsRepository::class)
 */
class StudentAsmDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="studentAsmDetails")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=false)
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=Assignment::class, inversedBy="studentAsmDetails")
     * @ORM\JoinColumn(name="assignment_id", referencedColumnName="id", nullable=false)
     */
    private $assignment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getAssignment(): ?Assignment
    {
        return $this->assignment;
    }

    public function setAssignment(?Assignment $assignment): self
    {
        $this->assignment = $assignment;

        return $this;
    }
}
