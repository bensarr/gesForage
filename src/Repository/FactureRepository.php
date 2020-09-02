<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    // /**
    //  * @return Facture[] Returns an array of Facture objects
    //  */

    public function findByAbonnement($id,$etat=null)
    {
        $qb= $this->createQueryBuilder('f')
            ->leftJoin('f.releves', 'r')
            ->leftJoin('r.compteur','c' )
            ->andWhere('c.id = :val')
            ->setParameter('val', $id);
        if($etat)
        {
            $qb=$qb
                ->andWhere('f.etat = :etat')
                ->setParameter('etat', $etat);
        }

        return $qb->orderBy('f.dateLimite', 'DESC')
                ->getQuery()
                ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Facture
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
