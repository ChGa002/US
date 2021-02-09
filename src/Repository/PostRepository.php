<?php

namespace App\Repository;

use App\Entity\Module;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	
	
	/**
	 * @return Post[] Returns an array of Post objects
	 */
	 public function findByModule($id)
	 {
		 // Récupération du gestionnaire d'entité 

		$gestionnaireEntite = $this->getEntityManager ();

		//Construction de la requête

		$requete = $gestionnaireEntite->createQuery('SELECT p
													FROM App\Entity\Post p 
													JOIN  p.modules m
													WHERE m.id = :identifiant'); 
		
		// Définiton des paramètres de la requête
		$requete->setParameters('identifiant', $id);
		
		// Exécution de la requête et envoi des résultats 
		return $requete->execute (); 
		 
		 
	 }
}
