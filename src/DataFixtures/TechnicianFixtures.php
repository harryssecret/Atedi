<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Technician;

class TechnicianFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new Technician();
        $data->setLastName('DORIAUX');
        $data->setFirstName('Marc');
        $data->setEmail('doriauxM50@gmail.com');
        $manager->persist($data);

        $data = new Technician();
        $data->setLastName('GOUDAL');
        $data->setFirstName('Yannis');
        $data->setEmail('yannisgoudal@hotmail.com');
        $manager->persist($data);

        $manager->flush();
    }
}
