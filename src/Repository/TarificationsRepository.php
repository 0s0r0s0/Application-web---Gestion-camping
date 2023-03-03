<?php

namespace App\Repository;

use App\Entity\Tarifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tarifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tarifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tarifications[]    findAll()
 * @method Tarifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarifications::class);
    }

    // /**
    //  * @return Tarifications[] Returns an array of Tarifications objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tarifications
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
