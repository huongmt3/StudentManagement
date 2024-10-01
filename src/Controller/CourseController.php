<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Lecturer;
use App\Form\CourseType;
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
    public function create(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/course/{id}", name="course_details")
     */
    public function details(int $id): Response
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        return $this->render('course/details.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/course/edit/{id}", name="course_edit")
     */
    public function edit(Request $request, int $id): Response
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/edit.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
        ]);
    }

    /**
     * @Route("/course/delete/{id}", name="course_delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $course = $entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id ' . $id);
        }

        $entityManager->remove($course);
        $entityManager->flush();

        return $this->redirectToRoute('course_index');
    }
}

