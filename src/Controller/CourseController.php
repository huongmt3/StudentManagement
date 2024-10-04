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
    public function edit(Request $request, CourseRepository $courseRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $course = $courseRepository->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        $students = $entityManager->getRepository(Student::class)->findAll();

        $enrolledStudents = $course->getStudentCourseDetails()->map(function ($detail) {
            return $detail->getStudent();
        })->toArray();

        $form = $this->createForm(CourseType::class, $course, [
            'students' => $students,
            'enrolled_students' => $enrolledStudents,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($course->getStudentCourseDetails() as $detail) {
                $course->removeStudentCourseDetail($detail);
            }

            $selectedStudents = $form->get('students')->getData();

            foreach ($selectedStudents as $student) {
                $detail = new StudentCourseDetails();
                $detail->setCourse($course);
                $detail->setStudent($student);
                $course->addStudentCourseDetail($detail);
            }

            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/edit.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
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
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        if ($this->isCsrfTokenValid('delete' . $course->getId(), $request->request->get('_token'))) {
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('course_index');
    }
}

