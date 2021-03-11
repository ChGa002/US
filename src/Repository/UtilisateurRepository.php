<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    /* Retourne la liste d'utilisateurs ayant des posts notés
    On recupere l'utilisateur, les notes qu'il a obtenu apres le reset de la date,
    et le nombre de posts notés depuis */

     public function findUtilisateursNotes($dateReset)
    {
      // Recuperer le gestionnaire d'entité
     $entityManager = $this->getEntityManager();

    // Construction de la requete
    $requete = $entityManager->createQuery(
        'SELECT u, avg(n.note), count(distinct(p))
        FROM App\Entity\Utilisateur u
        JOIN u.posts p
        JOIN p.notes n
        WHERE n.date >= :dateReset
    
        GROUP BY u
        ');

    $requete->setParameter('dateReset', $dateReset);
    // Retourner les resultats
    return $requete->getResult();
    }




    // /**
    //  * @return Utilisateur[] Returns an array of Utilisateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utilisateur
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
