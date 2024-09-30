<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
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
    private $courseName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $credits;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentCourseDetails", mappedBy="course")
     */
    private $studentCourseDetails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lecturer", inversedBy="courses")
     * @ORM\JoinColumn(name="lecturer_id", referencedColumnName="id")
     */
    private $instructor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Assignment", mappedBy="course")
     */
    private $assignments;

    public function __construct()
    {
        $this->studentCourseDetails = new ArrayCollection();
        $this->assignments = new ArrayCollection(); // Khởi tạo tập hợp assignments
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseName(): ?string
    {
        return $this->courseName;
    }

    public function setCourseName(string $courseName): self
    {
        $this->courseName = $courseName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCredits(): ?int
    {
        return $this->credits;
    }

    public function setCredits(int $credits): self
    {
        $this->credits = $credits;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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
            $studentCourseDetail->setCourse($this);
        }

        return $this;
    }

    public function removeStudentCourseDetail(StudentCourseDetails $studentCourseDetail): self
    {
        if ($this->studentCourseDetails->removeElement($studentCourseDetail)) {
            // set the owning side to null (unless already changed)
            if ($studentCourseDetail->getCourse() === $this) {
                $studentCourseDetail->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Assignment[]
     */
    public function getAssignments(): Collection
    {
        return $this->assignments;
    }

    public function addAssignment(Assignment $assignment): self
    {
        if (!$this->assignments->contains($assignment)) {
            $this->assignments[] = $assignment;
            $assignment->setCourse($this);
        }

        return $this;
    }

    public function removeAssignment(Assignment $assignment): self
    {
        if ($this->assignments->removeElement($assignment)) {
            // set the owning side to null (unless already changed)
            if ($assignment->getCourse() === $this) {
                $assignment->setCourse(null);
            }
        }

        return $this;
    }

    public function getInstructor(): ?Lecturer
    {
        return $this->instructor;
    }

    public function setInstructor(?Lecturer $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }
}
