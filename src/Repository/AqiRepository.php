<?php

namespace App\Repository;

use App\Entity\Aqi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Aqi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aqi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aqi[]    findAll()
 * @method Aqi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AqiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Aqi::class);
    }

    /**
     * @param Aqi $aqi
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function storeAqi(Aqi $aqi)
    {
        $this->getEntityManager()->persist($aqi);
        $this->getEntityManager()->flush($aqi);
    }


    /**
     * @param \DateTime $from
     * @return array|Aqi[]
     */
    public function getAqiFrom(\DateTime $from): array
    {
        return $this->createQueryBuilder('a')->where('a.createdAt >= :from')->setParameter('from', $from)
            ->getQuery()->getResult();
    }
}
