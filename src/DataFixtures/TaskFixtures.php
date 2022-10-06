<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Task;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new Task();
        $data->setTitle('Réparation');
        $data->setPrice('49');
        $data->setColor('ff0000');
        $manager->persist($data);

        $data = new Task();
        $data->setTitle('Formatage');
        $data->setPrice('59');
        $data->setColor('00ff00');
        $manager->persist($data);

        $data = new Task();
        $data->setTitle('Nettoyage');
        $data->setPrice('39');
        $data->setColor('0000ff');
        $manager->persist($data);

        $manager->flush();
    }
}
