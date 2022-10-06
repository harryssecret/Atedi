<?php

namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    public function findAll()
    {
        return $this->findBy(
            [],
            ['id' => 'DESC'],
        );
    }

    public function findAllOngoingByStatus()
    {
        return $this->createQueryBuilder('i')
            ->andWhere("i.status != 'Terminée'")
            ->orderBy('i.status', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllOngoingByDate()
    {
        return $this->createQueryBuilder('i')
            ->andWhere("i.status != 'Terminée'")
            ->orderBy('i.deposit_date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneById($id): ?Intervention
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAllByClient($id)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.client = :id')
            ->setParameter('id', $id)
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByEquipment($id)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.equipment = :id')
            ->setParameter('id', $id)
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByOperatingSystem($id)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.operating_system = :id')
            ->setParameter('id', $id)
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByTask($id)
    {
        return $this->createQueryBuilder('i')
            ->andWhere(':id MEMBER OF i.tasks')
            ->setParameter('id', $id)
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
