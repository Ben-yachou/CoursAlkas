<?php

namespace App\Repository;

use App\Entity\RelationRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RelationRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelationRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelationRequest[]    findAll()
 * @method RelationRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelationRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelationRequest::class);
    }

    //returns all requests from sender
    public function findBySender($id)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.sender = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    //returns all requests received
    public function findByReceiver($id)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.receiver = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?RelationRequest
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
