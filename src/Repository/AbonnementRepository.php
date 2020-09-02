<?php

namespace App\Repository;

use App\Entity\Abonnement;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Abonnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonnement[]    findAll()
 * @method Abonnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonnement::class);
    }
    public function getByFacture($id)
    {
        $qb=$this->createQueryBuilder('a')
            ->join('a.compteur','c')
            ->join('c.releves','r')
            ->join('r.Facture','f')
            ->where('f.id=:val')
            ->setParameter('val',$id);
        return$qb->getQuery()->getResult();
    }
    public function search($numero=null,$nomClient=null,$villageId=null,$compteurId=null):array
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.client','c');
            if($compteurId)
            {
                $qb = $qb
                    ->leftJoin('a.compteur','cmp')
                    ->andWhere('cmp.id = :compteurId')
                    ->setParameter('compteurId', $compteurId);
            }
            if($villageId)
            {
                $qb = $qb
                    ->leftJoin('c.village','v')
                    ->andWhere('v.id = :villageId')
                    ->setParameter('villageId', $villageId);
            }

            if($numero!="")
            {
                $qb=$qb
                ->andWhere('a.numero LIKE :numero')
                ->setParameter('numero', $numero);
            }
            if($nomClient!="")
            {
                $qb = $qb
                    ->andWhere('c.nom LIKE :nom')
                    ->setParameter('nom', $nomClient);
            }
            return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Abonnement[] Returns an array of Abonnement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Abonnement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
