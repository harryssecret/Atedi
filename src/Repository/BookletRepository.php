<?php

namespace App\Repository;

use App\Entity\Booklet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booklet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booklet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booklet[]    findAll()
 * @method Booklet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booklet::class);
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
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }
}
