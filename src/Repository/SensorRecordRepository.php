<?php

namespace App\Repository;

use App\Entity\SensorRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SensorRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method SensorRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method SensorRecord[]    findAll()
 * @method SensorRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorRecordRepository extends ServiceEntityRepository
{
    /**
     * SensorRecordRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SensorRecord::class);
    }

    /**
     * @param SensorRecord $sensorRecord
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function storeSensorRecord(SensorRecord $sensorRecord): void
    {
        $this->getEntityManager()->persist($sensorRecord);
        $this->getEntityManager()->flush($sensorRecord);
    }

    // /**
    //  * @return SensorRecord[] Returns an array of SensorRecord objects
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
    public function findOneBySomeField($value): ?SensorRecord
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
