<?php

namespace App\Controller;

use App\Entity\Booklet;
use App\Form\BookletType;
use App\Repository\BookletRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booklet")
 */
class BookletController extends AbstractController
{
    /**
     * @Route("/", name="booklet_index", methods={"GET"})
     */
    public function index(BookletRepository $bookletRepository): Response
    {
        return $this->render('booklet/index.html.twig', [
            'booklets' => $bookletRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="booklet_new", methods={"GET","POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $booklet = new Booklet();
        $form = $this->createForm(BookletType::class, $booklet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($booklet);
            $entityManager->flush();

            if ($request->query->has('s') == 'report') {
                return $this->redirectToRoute('intervention_report', [
                    'id' => $request->query->get('id'),
                ]);
            }

            return $this->redirectToRoute('booklet_index');
        }

        return $this->render('booklet/new.html.twig', [
            'booklet' => $booklet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="booklet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booklet $booklet, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(BookletType::class, $booklet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();


            return $this->redirectToRoute('booklet_index');
        }

        return $this->render('booklet/edit.html.twig', [
            'booklet' => $booklet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booklet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booklet $booklet, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $booklet->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($booklet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booklet_index');
    }
}
