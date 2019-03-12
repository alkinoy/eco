<?php

namespace App\Repository;

use App\Entity\SensorValueBreakpoints;
use App\Entity\SensorValueType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SensorValueBreakpoints|null find($id, $lockMode = null, $lockVersion = null)
 * @method SensorValueBreakpoints|null findOneBy(array $criteria, array $orderBy = null)
 * @method SensorValueBreakpoints[]    findAll()
 * @method SensorValueBreakpoints[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorValueBreakpointsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SensorValueBreakpoints::class);
    }

    /**
     * @param SensorValueType $type
     * @param float $value
     * @return SensorValueBreakpoints
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getBreakpoint(SensorValueType $type, float $value): SensorValueBreakpoints
    {
        return $this->createQueryBuilder('svb')
            ->where('svb.valueMin <= :value')
            ->andWhere('svb.valueMax >= :value')
            ->andWhere('svb.sensorValueType = :type')
            ->setParameter('value', $value)
            ->setParameter('type', $type)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
