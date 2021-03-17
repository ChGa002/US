<?php

namespace App\Repository;

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

      public function findPostsRecherche($mot)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('utilisateur')
            ->addSelect('modules')
            ->join('p.createur','utilisateur')
            ->join('p.modules','modules')
            ->join('modules.semestre','semestre')
            ->join('p.motsCles','motsCles')
            ->join('p.ressources','ressources')
            ->andWhere('motsCles.motCle LIKE :mot 
                        or p.titre LIKE :mot 
                        or p.description LIKE :mot 
                        or modules.nom LIKE :mot
                        or ressources.nom LIKE :mot
                        or ressources.typeDeFichier LIKE :mot
                        or utilisateur.pseudo LIKE :mot')
            ->setParameter('mot', '%'.$mot.'%')
            ->orderBy('p.datePubli', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findPostsRechercheAvancee($mot, $champ1, $choix1, $champ2, $choix2, $champ3, $choix3, $semestre, $tdf)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('utilisateur')
            ->addSelect('modules')
            ->addSelect('AVG(n.note) AS note')
            ->join('p.createur','utilisateur')
            ->join('p.modules','modules')
            ->join('modules.semestre','semestre')
            ->join('p.motsCles','motsCles')
            ->join('p.ressources','ressources')
            ->join('p.notes','n')
            ->Where('semestre.sigle LIKE :semestre and 
                        ressources.typeDeFichier LIKE :tdf and(
                        motsCles.motCle LIKE :mot 
                        or p.titre LIKE :mot 
                        or p.description LIKE :mot 
                        or modules.nom LIKE :mot
                        or ressources.nom LIKE :mot
                        or ressources.typeDeFichier LIKE :mot
                        or utilisateur.pseudo LIKE :mot)')
            ->setParameter('mot', '%'.$mot.'%')
            ->setParameter('semestre', $semestre.'%')
            ->setParameter('tdf', $tdf.'%')
            ->groupBy('p, utilisateur, modules')
            ->orderBy($champ1, $choix1)
            ->addOrderBy($champ2, $choix2)
            ->addOrderBy($champ3, $choix3)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findPostsAccueil($user, $favorisU, $favorisM, $favorisS)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('utilisateur')
            ->addSelect('modules')
            ->join('p.createur','utilisateur')
            ->join('p.modules','modules')
            ->join('modules.semestre','semestre')
            ->andWhere('utilisateur IN (:favorisU) OR modules IN (:favorisM) OR semestre IN (:favorisS)')
            ->andWhere('utilisateur != :user')
            ->setParameter('favorisU', $favorisU)
            ->setParameter('favorisM', $favorisM)
            ->setParameter('favorisS', $favorisS)
            ->setParameter('user', $user)
            ->orderBy('p.titre')
            ->getQuery()
            ->getResult()
        ;
    }

     public function findPostOptimise($id)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('utilisateur')
            ->addSelect('modules')
            ->addSelect('motsCles')    
            ->addSelect('ressources')     
            ->join('p.createur','utilisateur')
            ->join('p.modules','modules')
            ->leftjoin('p.motsCles','motsCles')
            ->join('p.ressources','ressources')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()

        ;
    }
	
	
	public function findByModule($module)
	 {
        return $this->createQueryBuilder('p')
			->join('p.modules','m')
            ->andWhere('m.id = :val')
            ->setParameter('val', $module)
            ->getQuery()
            ->getResult()
        ;
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
}
