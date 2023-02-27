<?php

namespace App\Controller;

use App\Entity\Technician;
use App\Form\TechnicianType;
use App\Repository\TechnicianRepository;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InterventionReportRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/technician")
 */
class TechnicianController extends AbstractController
{
    /**
     * @Route("/", name="technician_index", methods={"GET"})
     */
    public function index(TechnicianRepository $technicianRepository): Response
    {
        return $this->render('technician/index.html.twig', [
            'technicians' => $technicianRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="technician_new", methods={"GET","POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $technician = new Technician();
        $form = $this->createForm(TechnicianType::class, $technician);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($technician);
            $entityManager->flush();

            if ($request->query->has('s') == 'report') {
                return $this->redirectToRoute('intervention_report', [
                    'id' => $request->query->get('id'),
                ]);
            }

            return $this->redirectToRoute('technician_show', [
                'id' => $technician->getId(),
            ]);
        }

        return $this->render('technician/new.html.twig', [
            'technician' => $technician,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technician_show", methods={"GET"})
     */
    public function show(Technician $technician, InterventionReportRepository $interventionReportRepository): Response
    {
        $interventions = $interventionReportRepository->findAllByTechnician($technician->getId());

        return $this->render('technician/show.html.twig', [
            'technician' => $technician,
            'interventions' => $interventions,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="technician_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Technician $technician, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(TechnicianType::class, $technician);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('technician_show', [
                'id' => $technician->getId(),
            ]);
        }

        return $this->render('technician/edit.html.twig', [
            'technician' => $technician,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technician_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Technician $technician, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $technician->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($technician);
            $entityManager->flush();
        }

        return $this->redirectToRoute('technician_index');
    }
}
