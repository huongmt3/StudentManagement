<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Form\StudentType;

/**
 * @Route("/students")
 */
class StudentController extends AbstractController
{
    /**
     * Display all students
     * 
     * @Route("", name="student_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository('App\Entity\Student')->findAll();

        return $this->render('student/index.html.twig', array(
            'students' => $students,
        ));
    }

    /**
     * Finds and displays a student entity.
     *
     * @Route("/{id}", name="student_details", requirements={"id"="\d+"})
     */
    public function showAction(StudentRepository $studentRepository, int $id): Response
    {
        $student = $studentRepository->find($id);

        if (!$student) {
            throw $this->createNotFoundException('The student does not exist');
        }

        return $this->render('student/details.html.twig', [
            'student' => $student,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="student_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function editAction(int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(Student::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        $form = $this->createForm(StudentType::class, $student);

        if ($this->handleForm($form, $request, $student)) {
            $this->addFlash('notice', 'Student Edited');

            return $this->redirectToRoute('student_index');
        }

        return $this->render('student/edit.html.twig', [
            'form' => $form->createView(),
            'student' => $student,
        ]);
    }

    /**
     * @Route("/create", name="student_create", methods={"GET", "POST"})
     */
    public function createAction(Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        if ($this->handleForm($form, $request, $student)) {
            $this->addFlash('notice', 'Student Added');

            return $this->redirectToRoute('student_index');
        }

        return $this->render('student/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function handleForm($form, Request $request, $student): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return true;
        }

        return false;
    }

    /**
     * @Route("/delete/{id}", name="student_delete", methods={"POST"})
     */
    public function deleteAction(int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository(Student::class)->find($id);

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        if ($this->isCsrfTokenValid('delete' . $student->getId(), $request->request->get('_token'))) {
            $em->remove($student);
            $em->flush();

            $this->addFlash('notice', 'Student Deleted');
        }

        return $this->redirectToRoute('student_index');
    }

}