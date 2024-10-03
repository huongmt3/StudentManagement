<?php

namespace App\Controller;

use App\Entity\Assignment;
use App\Entity\Course;
use App\Form\AssignmentType;
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
            $students = $selectedCourse->getStudents();

            foreach ($students as $student) {
                $assignment->addJoinedStudent($student);
            }

            $entityManager = $this->getDoctrine()->getManager();
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
    public function details(int $id): Response
    {
        $assignment = $this->getDoctrine()->getRepository(Assignment::class)->find($id);

        if (!$assignment) {
            throw $this->createNotFoundException('No assignment found for id ' . $id);
        }

        return $this->render('assignment/details.html.twig', [
            'assignment' => $assignment,
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
            $selectedCourse = $assignment->getCourse();
            $students = $selectedCourse->getStudents();

            $assignment->clearJoinedStudents();

            foreach ($students as $student) {
                $assignment->addJoinedStudent($student);
            }

            $this->getDoctrine()->getManager()->flush();

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

        $entityManager->remove($assignment);
        $entityManager->flush();

        return $this->redirectToRoute('assignment_index');
    }
}
