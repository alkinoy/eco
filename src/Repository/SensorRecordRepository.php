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

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array|SensorRecord[]
     */
    public function getRecordsFromPeriod(\DateTime $from, \DateTime $to):array
    {
        return $this->createQueryBuilder('r')
            ->where('r.measuredAt >= :from AND r.measuredAt <= :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()->getResult();
    }
}
