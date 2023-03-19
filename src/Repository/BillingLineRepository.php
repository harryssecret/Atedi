<?php

namespace App\Repository;

use App\Entity\BillingLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BillingLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method BillingLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method BillingLine[]    findAll()
 * @method BillingLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BillingLine::class);
    }

    public function findAll(): array
    {
        return $this->findBy(
            [],
            ['id' => 'DESC'],
        );
    }

    public function findOneById($id)
    {
        return $this->createQueryBuilder('bl')
            ->andWhere('bl.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function findAllByIntervention($id)
    {
        return $this->createQueryBuilder('bl')
            ->andWhere("bl.intervention = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
