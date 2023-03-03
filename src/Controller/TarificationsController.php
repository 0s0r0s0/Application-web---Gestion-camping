<?php

namespace App\Controller;

use App\Entity\Tarifications;
use App\Form\TarificationsType;
use App\Repository\TarificationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/tarifications")
 */
class TarificationsController extends AbstractController
{
    /**
     * @Route("/", name="tarifications_index", methods={"GET"})
     */
    public function index(TarificationsRepository $tarificationsRepository): Response
    {
        return $this->render('admin/tarifications/index.html.twig', [
            'tarifications' => $tarificationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tarifications_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tarification = new Tarifications();
        $form = $this->createForm(TarificationsType::class, $tarification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tarification);
            $entityManager->flush();

            return $this->redirectToRoute('tarifications_index');
        }

        return $this->render('admin/tarifications/new.html.twig', [
            'tarification' => $tarification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tarifications_show", methods={"GET"})
     */
    public function show(Tarifications $tarification): Response
    {
        return $this->render('admin/tarifications/show.html.twig', [
            'tarification' => $tarification,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tarifications_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tarifications $tarification): Response
    {
        $form = $this->createForm(TarificationsType::class, $tarification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tarifications_index');
        }

        return $this->render('admin/tarifications/edit.html.twig', [
            'tarification' => $tarification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tarifications_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tarifications $tarification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tarification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tarification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/tarifications_index');
    }
}
