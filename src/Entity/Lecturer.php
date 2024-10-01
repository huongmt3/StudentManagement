<?php

namespace App\Entity;

use App\Repository\LecturerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=10)
     */
    private $lecturerGender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Course", mappedBy="instructor")
     */
    private $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

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

    public function getLecturerGender(): ?string
    {
        return $this->lecturerGender;
    }

    public function setLecturerGender(string $lecturerGender): self
    {
        $this->lecturerGender = $lecturerGender;

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setInstructor($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getInstructor() === $this) {
                $course->setInstructor(null);
            }
        }

        return $this;
    }
}
