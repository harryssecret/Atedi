<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use App\Repository\EquipmentRepository;
use App\Repository\TechnicianRepository;
use App\Repository\InterventionRepository;
use App\Repository\OperatingSystemRepository;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InterventionReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/statistics")
 */
class StatisticsController extends AbstractController
{
    /**
     * @Route("/", name="statistics_index", methods={"GET"})
     */
    public function index(InterventionReportRepository $irr, InterventionRepository $ir, TechnicianRepository $ter, TaskRepository $tar, EquipmentRepository $er, OperatingSystemRepository $osr)
    {
        // Load interventions by technicians chart
        $chart1 = new Highchart();

        $chart1->chart->renderTo('interventionTechnicians');
        $chart1->title->text('Interventions par techniciens');
        $chart1->tooltip->hideDelay(100);
        $chart1->tooltip->borderRadius(15);
        $chart1->tooltip->shadow(false);
        $chart1->tooltip->backgroundColor('#264653');
        $chart1->tooltip->borderColor('#000000');
        $chart1->tooltip->style(array(
            'color' => "#FFFFFF",
            'fontSize' => "14px",
        ));
        
        $chart1->legend->itemStyle(array(
            'color' => "#000000",
            'fontSize' => "14px",
            'fontWeight' => 'normal',
        ));

        $chart1->plotOptions->pie(array(
            'allowPointSelect'  => false,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));

        $data = array();
        $technicians = $ter->findAll();

        foreach ( $technicians as $technician ) {
            $interventions = $irr->findAllByTechnician($technician->getId());
            $count = count($interventions);
            $name = $technician->getLastName().' '.$technician->getFirstName();

            $dataEntry = array();
            array_push($dataEntry,$name);
            array_push($dataEntry,$count);
            
            array_push($data,$dataEntry);
        }

        $chart1->series(array(array(
            'type' => 'pie',
            'name' => 'Interventions', 
            'data' => $data
        )));



        // Load interventions by tasks chart
        $chart2 = new Highchart();

        $chart2->chart->renderTo('interventionTasks');
        $chart2->title->text('Interventions par tâches');
        $chart2->tooltip->hideDelay(100);
        $chart2->tooltip->borderRadius(15);
        $chart2->tooltip->shadow(false);
        $chart2->tooltip->backgroundColor('#264653');
        $chart2->tooltip->borderColor('#000000');
        $chart2->tooltip->style(array(
            'color' => "#FFFFFF",
            'fontSize' => "14px",
        ));
        
        $chart2->legend->itemStyle(array(
            'color' => "#000000",
            'fontSize' => "14px",
            'fontWeight' => 'normal',
        ));

        $chart2->plotOptions->pie(array(
            'allowPointSelect'  => false,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));

        $data = array();
        $tasks = $tar->findAll();

        foreach ( $tasks as $task ) {
            $interventions = $ir->findAllByTask($task->getId());
            $count = count($interventions);
            $name = $task->getTitle();

            $dataEntry = array();
            array_push($dataEntry,$name);
            array_push($dataEntry,$count);
            
            array_push($data,$dataEntry);
        }

        $chart2->series(array(array(
            'type' => 'pie',
            'name' => 'Interventions', 
            'data' => $data
        )));



        // Load interventions by equipment chart
        $chart3 = new Highchart();

        $chart3->chart->renderTo('interventionEquipment');
        $chart3->title->text('Interventions par équipements');
        $chart3->tooltip->hideDelay(100);
        $chart3->tooltip->borderRadius(15);
        $chart3->tooltip->shadow(false);
        $chart3->tooltip->backgroundColor('#264653');
        $chart3->tooltip->borderColor('#000000');
        $chart3->tooltip->style(array(
            'color' => "#FFFFFF",
            'fontSize' => "14px",
        ));
        
        $chart3->legend->itemStyle(array(
            'color' => "#000000",
            'fontSize' => "14px",
            'fontWeight' => 'normal',
        ));

        $chart3->plotOptions->pie(array(
            'allowPointSelect'  => false,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));

        $data = array();
        $equipments = $er->findAll();

        foreach ( $equipments as $equipment ) {
            $interventions = $ir->findAllByEquipment($equipment->getId());
            $count = count($interventions);
            $name = $equipment->getTitle();

            $dataEntry = array();
            array_push($dataEntry,$name);
            array_push($dataEntry,$count);
            
            array_push($data,$dataEntry);
        }

        $chart3->series(array(array(
            'type' => 'pie',
            'name' => 'Interventions', 
            'data' => $data
        )));


        // Load interventions by tasks chart
        $chart4 = new Highchart();

        $chart4->chart->renderTo('interventionOperatingSystems');
        $chart4->title->text("Interventions par systèmes d'exploitation");
        $chart4->tooltip->hideDelay(100);
        $chart4->tooltip->borderRadius(15);
        $chart4->tooltip->shadow(false);
        $chart4->tooltip->backgroundColor('#264653');
        $chart4->tooltip->borderColor('#000000');
        $chart4->tooltip->style(array(
            'color' => "#FFFFFF",
            'fontSize' => "14px",
        ));
        
        $chart4->legend->itemStyle(array(
            'color' => "#000000",
            'fontSize' => "14px",
            'fontWeight' => 'normal',
        ));

        $chart4->plotOptions->pie(array(
            'allowPointSelect'  => false,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));

        $data = array();
        $operatingSystems = $osr->findAll();

        foreach ( $operatingSystems as $operatingSystem ) {
            $interventions = $ir->findAllByOperatingSystem($operatingSystem->getId());
            $count = count($interventions);
            $name = $operatingSystem->getTitle();

            $dataEntry = array();
            array_push($dataEntry,$name);
            array_push($dataEntry,$count);
            
            array_push($data,$dataEntry);
        }

        $chart4->series(array(array(
            'type' => 'pie',
            'name' => 'Interventions', 
            'data' => $data
        )));

        $interventions = $ir->findAll();

        return $this->render('statistics/index.html.twig', [
            'chart1' => $chart1,
            'chart2' => $chart2,
            'chart3' => $chart3,
            'chart4' => $chart4,
            'interventions' => $interventions,
        ]);
    }
}