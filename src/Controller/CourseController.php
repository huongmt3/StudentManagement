<?php 

namespace App\Controller;

use App\Entity\Course;
use App\Entity\StudentCourseDetails;
use App\Entity\Student;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    /**
     * @Route("/course", name="course_index")
     */
    public function index(): Response
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    /**
     * @Route("/course/create", name="course_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = new Course();
    
        $students = $entityManager->getRepository(Student::class)->findAll();
    
        $form = $this->createForm(CourseType::class, $course, [
            'students' => $students,
        ]);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedStudents = $form->get('students')->getData();
    
            $entityManager->persist($course);
            $entityManager->flush();
    
            foreach ($selectedStudents as $student) {
                $studentCourseDetail = new StudentCourseDetails();
                $studentCourseDetail->setCourse($course);
                $studentCourseDetail->setStudent($student);
                $entityManager->persist($studentCourseDetail);
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('course_index');
        }
    
        return $this->render('course/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/course/edit/{id}", name="course_edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $form = $this->createForm(CourseType::class, $course);
    
        $allStudents = $entityManager->getRepository(Student::class)->findAll();
        $registeredStudents = $course->getStudents();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('course_index');
        }

        $removeStudentId = $request->query->get('removeStudentId');
        if ($removeStudentId) {
            $student = $this->getDoctrine()->getRepository(Student::class)->find($removeStudentId);
            if ($student) {
                return $this->removeStudentFromCourse($request, $course, $student);
            }
        }

        $addStudentId = $request->query->get('addStudentId');
        if ($addStudentId) {
            $student = $this->getDoctrine()->getRepository(Student::class)->find($addStudentId);
            if ($student) {
                return $this->addStudentToCourse($request, $course, $student);
            }
        }

        return $this->render('course/edit.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
            'allStudents' => $allStudents,
            'registeredStudents' => $registeredStudents,
        ]);
    }

    /**
     * @Route("/course/details/{id}", name="course_details")
     */
    public function details(int $id, EntityManagerInterface $entityManager): Response
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        $studentCourseDetails = $entityManager->getRepository(StudentCourseDetails::class)
                                              ->findBy(['course' => $course]);

        $students = [];
        foreach ($studentCourseDetails as $detail) {
            $students[] = $detail->getStudent();
        }

        return $this->render('course/details.html.twig', [
            'course' => $course,
            'students' => $students,
        ]);
    }

    /**
     * @Route("/course/delete/{id}", name="course_delete", methods={"POST"})
     */
    public function deleteCourse($id, EntityManagerInterface $entityManager)
    {
        $course = $entityManager->getRepository(Course::class)->find($id);

        if ($course) {
            $studentsInCourse = $entityManager->getRepository(StudentCourseDetails::class)->findBy(['course' => $course]);

            foreach ($studentsInCourse as $studentCourse) {
                $entityManager->remove($studentCourse);
            }

            $entityManager->remove($course);
            $entityManager->flush();
        }
        return $this->redirectToRoute('course_index');
    }

    public function addStudentToCourse(Request $request, Course $course, Student $student): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $studentCourseDetail = new StudentCourseDetails();
        $studentCourseDetail->setCourse($course);
        $studentCourseDetail->setStudent($student);

        $entityManager->persist($studentCourseDetail);
        $entityManager->flush();

        return $this->redirectToRoute('course_edit', ['id' => $course->getId()]);
    }

    public function removeStudentFromCourse(Request $request, Course $course, Student $student): Response
    {
        $studentCourseDetail = $this->getDoctrine()->getRepository(StudentCourseDetails::class)
            ->findOneBy(['course' => $course, 'student' => $student]);

        if ($studentCourseDetail) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($studentCourseDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('course_edit', ['id' => $course->getId()]);
    }
}