<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Decouvert;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Decouvert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decouvert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decouvert[]    findAll()
 * @method Decouvert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DecouvertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decouvert::class);
    }

    // /**
    //  * @return Decouvert[] Returns an array of Decouvert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Decouvert
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // public function test():Query{
    //     $results = $this->createQueryBuilder('decouvert') 
    //     ->select('decouvert.description, decouvert.image, continent.name AS cName')
    //     ->join('decouvert.continent', 'continent')
    //     ->orderBy('continent')
    //     ->getQuery()
    //     ;

    //     //retour des resultats
    //     return $results;
    // }

    
    public function findAllOrdered()
    {
        return $this->findBy(array(), array('continent' => 'ASC'));
    }
}
