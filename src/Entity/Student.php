<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
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
    private $studentName; 

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $studentEmail; 

    /**
     * @ORM\Column(type="boolean")
     */
    private $studentGender; 

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth; 

    /**
     * @ORM\Column(type="date")
     */
    private $registrationDate; 

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentCourseDetails", mappedBy="student")
     */
    private $studentCourseDetails;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentAsmDetails", mappedBy="student")
     */
    private $studentAsmDetails;

    public function __construct()
    {
        $this->studentCourseDetails = new ArrayCollection();
        $this->studentAsmDetails = new ArrayCollection(); // Khởi tạo tập hợp StudentAsmDetails
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentName(): ?string
    {
        return $this->studentName; 
    }

    public function setStudentName(string $studentName): self 
    {
        $this->studentName = $studentName; 

        return $this;
    }

    public function getStudentEmail(): ?string
    {
        return $this->studentEmail; 
    }

    public function setStudentEmail(string $studentEmail): self 
    {
        $this->studentEmail = $studentEmail; 

        return $this;
    }

    public function isStudentGender(): ?bool
    {
        return $this->studentGender; 
    }

    public function setStudentGender(bool $studentGender): self 
    {
        $this->studentGender = $studentGender; 

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth; 
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self 
    {
        $this->dateOfBirth = $dateOfBirth; 

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate; 
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self 
    {
        $this->registrationDate = $registrationDate; 

        return $this;
    }

    /**
     * @return Collection|StudentCourseDetails[]
     */
    public function getStudentCourseDetails(): Collection
    {
        return $this->studentCourseDetails;
    }

    public function addStudentCourseDetail(StudentCourseDetails $studentCourseDetail): self
    {
        if (!$this->studentCourseDetails->contains($studentCourseDetail)) {
            $this->studentCourseDetails[] = $studentCourseDetail;
            $studentCourseDetail->setStudent($this);
        }

        return $this;
    }

    public function removeStudentCourseDetail(StudentCourseDetails $studentCourseDetail): self
    {
        if ($this->studentCourseDetails->removeElement($studentCourseDetail)) {
            // set the owning side to null (unless already changed)
            if ($studentCourseDetail->getStudent() === $this) {
                $studentCourseDetail->setStudent(null);
            }
        }

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
            $studentAsmDetail->setStudent($this);
        }

        return $this;
    }

    public function removeStudentAsmDetail(StudentAsmDetails $studentAsmDetail): self
    {
        if ($this->studentAsmDetails->removeElement($studentAsmDetail)) {
            // set the owning side to null (unless already changed)
            if ($studentAsmDetail->getStudent() === $this) {
                $studentAsmDetail->setStudent(null);
            }
        }

        return $this;
    }
}
