<?php

namespace App\Repository;

use App\Entity\Compteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Compteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compteur[]    findAll()
 * @method Compteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compteur::class);
    }

    public function getByFacture($id)
    {
        $qb=$this->createQueryBuilder('c')
            ->join('c.releves','r')
            ->join('r.Facture','f')
            ->where('f.id=:val')
            ->setParameter('val',$id);
        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }
    // /**
    //  * @return Compteur[] Returns an array of Compteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Compteur
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
