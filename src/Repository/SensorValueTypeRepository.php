<?php

namespace App\Repository;

use App\Entity\SensorValueType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SensorValueType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SensorValueType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SensorValueType[]    findAll()
 * @method SensorValueType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorValueTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SensorValueType::class);
    }
}
