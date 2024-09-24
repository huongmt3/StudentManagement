<?php

namespace App\Entity;

use App\Repository\StudentRepository;
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
}
