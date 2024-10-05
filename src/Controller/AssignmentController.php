<?php

namespace App\Controller;

use App\Entity\Assignment;
use App\Entity\Course;
use App\Form\AssignmentType;
use App\Entity\StudentAsmDetails;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssignmentController extends AbstractController
{
    /**
     * @Route("/assignment", name="assignment_index")
     */
    public function index(): Response
    {
        $assignments = $this->getDoctrine()->getRepository(Assignment::class)->findAll();

        return $this->render('assignment/index.html.twig', [
            'assignments' => $assignments,
        ]);
    }

    /**
     * @Route("/assignment/create", name="assignment_create")
     */
    public function create(Request $request): Response
    {
        $assignment = new Assignment();
        $form = $this->createForm(AssignmentType::class, $assignment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCourse = $assignment->getCourse();

            if ($selectedCourse) {
                $students = $selectedCourse->getStudents();

                foreach ($students as $student) {
                    $studentAsmDetail = new StudentAsmDetails();
                    $studentAsmDetail->setAssignment($assignment);
                    $studentAsmDetail->setStudent($student);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($studentAsmDetail);
                }
            }

            $entityManager->persist($assignment);
            $entityManager->flush();

            return $this->redirectToRoute('assignment_index');
        }

        return $this->render('assignment/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/assignment/{id}", name="assignment_details")
     */
    public function details($id): Response
    {
        $assignment = $this->getDoctrine()->getRepository(Assignment::class)->find($id);

        if (!$assignment) {
            throw $this->createNotFoundException('No assignment found for id ' . $id);
        }

        $studentAsmDetails = $this->getDoctrine()->getRepository(StudentAsmDetails::class)->findBy(['assignment' => $assignment]);

        return $this->render('assignment/details.html.twig', [
            'assignment' => $assignment,
            'studentAsmDetails' => $studentAsmDetails,
        ]);
    }

    /**
     * @Route("/assignment/edit/{id}", name="assignment_edit")
     */
    public function edit(Request $request, int $id): Response
    {
        $assignment = $this->getDoctrine()->getRepository(Assignment::class)->find($id);

        if (!$assignment) {
            throw $this->createNotFoundException('No assignment found for id ' . $id);
        }

        $form = $this->createForm(AssignmentType::class, $assignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $selectedCourse = $assignment->getCourse();
            $students = $selectedCourse ? $selectedCourse->getStudents() : [];

            foreach ($assignment->getStudentAsmDetails() as $detail) {
                $entityManager->remove($detail);
            }

            foreach ($students as $student) {
                $studentAsmDetail = new StudentAsmDetails();
                $studentAsmDetail->setAssignment($assignment);
                $studentAsmDetail->setStudent($student);
                $entityManager->persist($studentAsmDetail);
                $assignment->addStudentAsmDetail($studentAsmDetail);
            }

            $entityManager->persist($assignment);
            $entityManager->flush();

            return $this->redirectToRoute('assignment_index');
        }

        return $this->render('assignment/edit.html.twig', [
            'form' => $form->createView(),
            'assignment' => $assignment,
        ]);
    }

    /**
     * @Route("/assignment/delete/{id}", name="assignment_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $assignment = $entityManager->getRepository(Assignment::class)->find($id);

        if (!$assignment) {
            throw $this->createNotFoundException('No assignment found for id ' . $id);
        }

        foreach ($assignment->getStudentAsmDetails() as $detail) {
            $entityManager->remove($detail);
        }

        $entityManager->remove($assignment);
        $entityManager->flush();

        return $this->redirectToRoute('assignment_index');
    }
}