<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

// *
//  * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
//  * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
//  * @method Recipe[]    findAll()
//  * @method Recipe[]    findAllVisble($user)
//  * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 
class RecipeRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    // user is null if not logged in
    public function findAllVisible(User $user = null)  
    {
        // determine the user type
        if($user) {
            // get all recipes whuch are public, shared or owned by this user            
            return $this->createQueryBuilder('r')
                ->andWhere('r.user = :id')
                ->orWhere('r.isPublic = 1')
                ->orWhere('r.isShared = 1')
                ->setParameter('id', $user->getId())
                ->orderBy('r.created', 'DESC')
                ->getQuery()
                ->getResult();
        
        } else {
            // public recipes only
            return $this->createQueryBuilder('r')
                ->andWhere('r.isPublic = 1')
                ->orderBy('r.created', 'ASC')
                ->getQuery()
                ->getResult();
        }

    }


//    /**
//     * @return Recipe[] Returns an array of Recipe objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recipe
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
