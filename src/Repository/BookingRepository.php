<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function add(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBookingsInInterval($charge_start, $charge_end, $station_id): array
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->andWhere('b.charge_end >= :charge_start')
            ->andWhere('b.charge_start <= :charge_end')
            ->andWhere('b.station = :station_id')
            ->setParameter('charge_start', $charge_start)
            ->setParameter('charge_end', $charge_end)
            ->setParameter('station_id', $station_id)
            ->getQuery()
            ->getArrayResult();
    }

    public function findStationsByFilterType($charge_start, $charge_end, $location_id, $type): array
    {
        return $this->getEntityManager()->createQuery('SELECT s FROM App\Entity\Station s WHERE s.id NOT IN (SELECT DISTINCT st.id FROM App\Entity\Station st JOIN App\Entity\Booking b WHERE st.id=b.station
        AND (b.charge_end>=:charge_start AND b.charge_start<=:charge_end)) AND s.location=:location_id AND s.type=:type')
            ->setParameter('charge_start', $charge_start)
            ->setParameter('charge_end', $charge_end)
            ->setParameter('location_id', $location_id)
            ->setParameter('type', $type)
            /*
             * SELECT * FROM station WHERE station.id NOT IN (SELECT DISTINCT station.id FROM station JOIN booking WHERE station.id=booking.station_id
             * AND (booking.charge_end>='2022-07-12 00:44:48' AND booking.charge_start<='2022-07-12 02:44:48')) AND station.location_id=1 AND station.type='Type 2';
             */
            ->getArrayResult();
    }

    public function findStationsByFilter($charge_start, $charge_end, $location_id): array
    {
        return $this->getEntityManager()->createQuery('SELECT s FROM App\Entity\Station s WHERE s.id NOT IN (SELECT DISTINCT st.id FROM App\Entity\Station st JOIN App\Entity\Booking b WHERE st.id=b.station
        AND (b.charge_end>=:charge_start AND b.charge_start<=:charge_end)) AND s.location=:location_id')
            ->setParameter('charge_start', $charge_start)
            ->setParameter('charge_end', $charge_end)
            ->setParameter('location_id', $location_id)
            ->getArrayResult();
    }

//    /**
//     * @return Booking[] Returns an array of Booking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Booking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
