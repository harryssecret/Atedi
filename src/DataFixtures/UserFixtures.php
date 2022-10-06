<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $data = new User();
        $data->setEmail('admin@gmail.com');
        $data->setRoles(['ROLE_ADMIN']);
        $data->setPassword($this->passwordEncoder->encodePassword($data,'admin'));
        $manager->persist($data);

        $manager->flush();
    }
}
