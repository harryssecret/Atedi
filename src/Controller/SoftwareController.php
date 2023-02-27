<?php

namespace App\Controller;

use App\Entity\Software;
use App\Form\SoftwareType;
use App\Repository\SoftwareRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/software")
 */
class SoftwareController extends AbstractController
{
    /**
     * @Route("/", name="software_index", methods={"GET"})
     */
    public function index(SoftwareRepository $softwareRepository): Response
    {
        return $this->render('software/index.html.twig', [
            'softwares' => $softwareRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="software_new", methods={"GET","POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $software = new Software();

        $entityManager = $doctrine()->getManager();
        $form = $this->createForm(SoftwareType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($software);
            $entityManager->flush();

            if ($request->query->has('s') == 'report') {
                return $this->redirectToRoute('intervention_report', [
                    'id' => $request->query->get('id'),
                ]);
            }

            return $this->redirectToRoute('software_index');
        }

        return $this->render('software/new.html.twig', [
            'software' => $software,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="software_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Software $software, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(SoftwareType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('software_index');
        }

        return $this->render('software/edit.html.twig', [
            'software' => $software,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="software_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Software $software, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $software->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($software);
            $entityManager->flush();
        }

        return $this->redirectToRoute('software_index');
    }
}
