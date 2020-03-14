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
     * @param \DateTime $date
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function isExist(\DateTime $date): bool
    {
        return !!$this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.createdAt = :date')->setParameter('date', $date)
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * @param \DateTime $from
     * @param string $lat
     * @param string $lng
     * @return array|Aqi[]
     */
    public function getAqiFrom(\DateTime $from, string $lat = null, string $lng = null): array
    {
        $query = $this->createQueryBuilder('a');
        $query->where('a.createdAt >= :from')->setParameter('from', $from);

        if ($lat) {
            $query->andWhere('a.latitude = :lat')->setParameter('lat', $lat);
        }

        if ($lng) {
            $query->andWhere('a.longitude = :lng')->setParameter('lng', $lng);
        }

        return $query->getQuery()->getResult();
    }
}
