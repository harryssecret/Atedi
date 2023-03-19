<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\InterventionRepository;

class InterventionControllerTest extends WebTestCase
{

    public function testInterventionHomepage(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $client->followRedirects();

        $testUser = $userRepository->findOneByEmail("admin@gmail.com");

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/intervention');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des interventions', "Homepage is accessible");
    }

    public function testNewInterventionPage(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail("admin@gmail.com");
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/intervention/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains("h1", "Nouvelle demande d'intervention", "Intervention creation page is available");

        $form = $crawler->filter('form[name=intervention]')->form();

        $this->assertTrue($form->has('intervention[client]'));
        $this->assertTrue($form->has('intervention[equipment]'));
        $this->assertTrue($form->has('intervention[equipment_complete]'));
        $this->assertTrue($form->has('intervention[operating_system]'));
        $this->assertTrue($form->has('intervention[tasks]'));
        $this->assertTrue($form->has('intervention[return_date]'));
        $this->assertTrue($form->has('intervention[comment]'));

        $form['intervention[client]'] = '1'; // dylan hochet
        $form['intervention[equipment]'] = '1'; // téléphone
        $form['intervention[equipment_complete]'] = "Oui";
        $form['intervention[operating_system]'] = '1'; // linux
        $form['intervention[tasks]'] = '1'; // réparation
        $form['intervention[return_date]'] = '2022-01-01';
        $form['intervention[comment]'] = 'Commentaire de test';

        $crawler = $client->submit($form);

        $interventionRepository = static::getContainer()->get(InterventionRepository::class);
        $intervention = $interventionRepository->findOneBy(['client' => 'Dylan HOCHET']);

        $this->assertNotNull($intervention);
        $this->assertSame('Ordinateur portable', $intervention->getEquipment());
        $this->assertTrue($intervention->getEquipmentComplete());
        $this->assertSame('Windows 10', $intervention->getOperatingSystem());
        $this->assertSame('Réparation de la carte mère', $intervention->getTasks());
        $this->assertSame('2022-01-01', $intervention->getReturnDate()->format('Y-m-d'));
        $this->assertSame('Commentaire de test', $intervention->getComment());
    }
}
