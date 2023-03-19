<?php

namespace App\Repository;

use App\Entity\Software;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Software|null find($id, $lockMode = null, $lockVersion = null)
 * @method Software|null findOneBy(array $criteria, array $orderBy = null)
 * @method Software[]    findAll()
 * @method Software[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoftwareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Software::class);
    }

    public function findAll(): array
    {
        return $this->findBy(
            [],
            ['id' => 'DESC'],
        );
    }

    public function findAllByType($type)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.type = :type')
            ->setParameter('type', $type)
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findOneById($id)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }
}
