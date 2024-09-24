<?php

namespace App\Entity;

use App\Repository\LecturerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LecturerRepository::class)
 */
class Lecturer
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
    private $lecturerName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lecturerEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lecturerSpecialisation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lecturerGender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLecturerName(): ?string
    {
        return $this->lecturerName;
    }

    public function setLecturerName(string $lecturerName): self
    {
        $this->lecturerName = $lecturerName;

        return $this;
    }

    public function getLecturerEmail(): ?string
    {
        return $this->lecturerEmail;
    }

    public function setLecturerEmail(string $lecturerEmail): self
    {
        $this->lecturerEmail = $lecturerEmail;

        return $this;
    }

    public function getLecturerSpecialisation(): ?string
    {
        return $this->lecturerSpecialisation;
    }

    public function setLecturerSpecialisation(string $lecturerSpecialisation): self
    {
        $this->lecturerSpecialisation = $lecturerSpecialisation;

        return $this;
    }

    public function isLecturerGender(): ?bool
    {
        return $this->lecturerGender;
    }

    public function setLecturerGender(bool $lecturerGender): self
    {
        $this->lecturerGender = $lecturerGender;

        return $this;
    }
}
