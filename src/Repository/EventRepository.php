<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventByName($query) : array
    {
        
        return $this->createQueryBuilder('e')
            ->andWhere('e.event_name LIKE :val')
            ->setParameter('val', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }

       /**
        * @return Event[] Returns an array of Event objects
        */
       public function findEventByCategory($value): array
       {
           return $this->createQueryBuilder('e')

           ->select('e') // Sélectionne tous les champs de Entity1 et le champ spécifique de Entity2

              

               ->andWhere('e.category = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }

       public function findCategory($value): array
       {
           return $this->createQueryBuilder('e')

              ->select('c.category_name') // Sélectionne tous les champs de Entity1 et le champ spécifique de Entity2

              
               ->join('App\Entity\Category', 'c', 'WITH', 'e.category = c.id')

               ->andWhere('e.category = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
