<?php

namespace App\Repository;

use App\Entity\OperatingSystem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperatingSystem|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperatingSystem|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperatingSystem[]    findAll()
 * @method OperatingSystem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperatingSystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperatingSystem::class);
    }

    public function findAll()
    {
        return $this->findBy(
            [],
            ['id' => 'DESC'],
        );
    }
}
