<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Lecturer;
use App\Repository\LecturerRepository;
use App\Form\LecturerType;

/**
 * @Route("/lecturers")
 */
class LecturerController extends AbstractController
{
    /**
     * @Route("", name="lecturer_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lecturers = $em->getRepository(Lecturer::class)->findAll();

        return $this->render('lecturer/index.html.twig', [
            'lecturers' => $lecturers,
        ]);
    }

    /**
     * @Route("/{id}", name="lecturer_details", requirements={"id"="\d+"})
     */
    public function showAction(LecturerRepository $lecturerRepository, int $id): Response
    {
        $lecturer = $lecturerRepository->find($id);

        if (!$lecturer) {
            throw $this->createNotFoundException('The lecturer does not exist');
        }

        return $this->render('lecturer/details.html.twig', [
            'lecturer' => $lecturer,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="lecturer_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function editAction(int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $lecturer = $em->getRepository(Lecturer::class)->find($id);

        if (!$lecturer) {
            throw $this->createNotFoundException('Lecturer not found');
        }

        $form = $this->createForm(LecturerType::class, $lecturer);

        if ($this->handleForm($form, $request, $lecturer)) {
            $this->addFlash('notice', 'Lecturer Edited');

            return $this->redirectToRoute('lecturer_index');
        }

        return $this->render('lecturer/edit.html.twig', [
            'form' => $form->createView(),
            'lecturer' => $lecturer,
        ]);
    }

    /**
     * @Route("/create", name="lecturer_create", methods={"GET", "POST"})
     */
    public function createAction(Request $request): Response
    {
        $lecturer = new Lecturer();
        $form = $this->createForm(LecturerType::class, $lecturer);

        if ($this->handleForm($form, $request, $lecturer)) {
            $this->addFlash('notice', 'Lecturer Added');

            return $this->redirectToRoute('lecturer_index');
        }

        return $this->render('lecturer/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function handleForm($form, Request $request, $lecturer): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lecturer);
            $em->flush();

            return true;
        }

        return false;
    }

    /**
     * @Route("/delete/{id}", name="lecturer_delete", methods={"POST"})
     */
    public function deleteAction(int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $lecturer = $em->getRepository(Lecturer::class)->find($id);

        if (!$lecturer) {
            throw $this->createNotFoundException('Lecturer not found');
        }

        if ($this->isCsrfTokenValid('delete' . $lecturer->getId(), $request->request->get('_token'))) {
            $em->remove($lecturer);
            $em->flush();

            $this->addFlash('notice', 'Lecturer Deleted');
        }

        return $this->redirectToRoute('lecturer_index');
    }

}
