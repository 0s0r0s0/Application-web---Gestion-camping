<?php

namespace App\Controller;

use App\Entity\Templates;
use App\Form\TemplatesType;
use App\Repository\TemplatesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/templates")
 */
class TemplatesController extends AbstractController
{
    /**
     * @Route("/", name="templates", methods={"GET"})
     */
    public function index(TemplatesRepository $templatesRepository): Response
    {
        return $this->render('admin/templates/index.html.twig', [
            'templates' => $templatesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="templates_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $template = new Templates();
        $form = $this->createForm(TemplatesType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($template);
            $entityManager->flush();

            return $this->redirectToRoute('templates');
        }

        return $this->render('admin/templates/new.html.twig', [
            'template' => $template,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="templates_show", methods={"GET"})
     */
    public function show(Templates $template): Response
    {
        return $this->render('admin/templates/show.html.twig', [
            'template' => $template,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="templates_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Templates $template): Response
    {
        $form = $this->createForm(TemplatesType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('templates');
        }

        return $this->render('admin/templates/edit.html.twig', [
            'template' => $template,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="templates_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Templates $template): Response
    {
        if ($this->isCsrfTokenValid('delete'.$template->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($template);
            $entityManager->flush();
        }

        return $this->redirectToRoute('templates');
    }
}
