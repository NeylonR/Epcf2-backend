<?php

namespace App\Repository;

use App\Data\FilterData;
use App\Entity\Appointment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Appointment>
 *
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    public function add(Appointment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Appointment $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Appointment[] Returns an array of Appointment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Appointment
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @return Appointment Returns an array of Appointment objects
     */
    public function findAppointment(FilterData $filter): array
    {
        $query = $this->createQueryBuilder('appointment')
        ->select('appointment')
        // ->orderBy('appointment.id', 'ASC')
        ->orderBy('appointment.beginDate', 'ASC')
        ;

        if(!empty($filter->name)){
            $query = $query->andWhere('appointment.name LIKE :name')
            ->setParameter('name', '%'.$filter->name.'%')
            ;
        }

        if(!empty($filter->place)){
            $query = $query->andWhere('appointment.place LIKE :place')
            ->setParameter('place', '%'.$filter->place.'%')
            ;
        }

        if(!empty($filter->priority)){
            $query = $query->andWhere('appointment.priority = :priority')
            ->setParameter('priority', $filter->priority)
            ;
        }

        if(!empty($filter->beginDate)){
            $query = $query->andWhere('appointment.beginDate >= :beginDate')
            ->setParameter('beginDate', $filter->beginDate->format('Y-m-d H:i:s'))
            ;
        }

        if(!empty($filter->endDate)){
            $query = $query->andWhere('appointment.endDate <= :endDate')
            ->setParameter('endDate', $filter->endDate->format('Y-m-d H:i:s'))
            ;
        }
        // dd($query->getDQL());

        return $query->getQuery()->getResult();
    }
}
