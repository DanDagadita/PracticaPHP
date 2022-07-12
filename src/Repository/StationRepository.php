<?php

namespace App\Repository;

use App\Entity\Station;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Station>
 *
 * @method Station|null find($id, $lockMode = null, $lockVersion = null)
 * @method Station|null findOneBy(array $criteria, array $orderBy = null)
 * @method Station[]    findAll()
 * @method Station[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Station::class);
    }

    public function add(Station $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Station $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllStations(): array
    {
        return $this->createQueryBuilder('s')
            ->select('s', 'l')
            ->join('s.location', 'l')
            ->where('s.location = l.id')
            ->getQuery()
            ->getArrayResult();
    }

    public function findStationsByFilter($charge_start, $charge_end, $location_id, $type): array
    {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->join('s.location', 'l')
            ->where('s.location = l.id')
            ->andWhere('b.charge_end <= :charge_start OR b.charge_start >= :charge_end')
            ->andWhere('s.location = :location_id')
            ->andWhere('s.type = :type')
            ->setParameter('charge_start', $charge_start)
            ->setParameter('charge_end', $charge_end)
            ->setParameter('location_id', $location_id)
            ->setParameter('type', $type)
            ->getQuery()
            ->getArrayResult();
    }

//    /**
//     * @return Station[] Returns an array of Station objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Station
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
