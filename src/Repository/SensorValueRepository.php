<?php

namespace App\Repository;

use App\Entity\SensorValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SensorValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method SensorValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method SensorValue[]    findAll()
 * @method SensorValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorValueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SensorValue::class);
    }

    // /**
    //  * @return SensorValue[] Returns an array of SensorValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SensorValue
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
