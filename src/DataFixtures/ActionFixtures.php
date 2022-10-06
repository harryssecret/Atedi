<?php

namespace App\DataFixtures;

use App\Entity\Action;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ActionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new Action();
        $data->setTitle('Optimisation au démarrage');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Réinitialisation navigateurs web');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Suppression antivirus client');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Suppresion du proxy');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Installation antivirus');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Mise à jour antivirus');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Installation spybot');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Mise à jour spybot');
        $manager->persist($data);

        $data = new Action();
        $data->setTitle('Présence de toolbars');
        $manager->persist($data);

        $manager->flush();
    }
}
