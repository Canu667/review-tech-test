<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function getAverageForHotel(Uuid $hotelUuid, string $since = null): float
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('avg(r.score)')
            ->from('App:Review', 'r')
            ->where('r.hotel = ?1')
            ->setParameter(1, $hotelUuid->toString());

        if ($since !== null) {
            $qb->andWhere('r.createdAt > ?2')->setParameter(2, $since);
        }

        return (float) $qb->getQuery()->getSingleScalarResult();
    }
}
