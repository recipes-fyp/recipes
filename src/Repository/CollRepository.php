<?php

namespace App\Repository;

use App\Entity\Coll;
use App\Entity\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Collektion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collektion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collektion[]    findAll()
 * @method Collektion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Coll::class);
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
                ->orderBy('r.created', 'DESC') // most recent first
                ->getQuery()
                ->getResult();
        
        } else {
            // public recipes only
            return $this->createQueryBuilder('r')
                ->andWhere('r.isPublic = 1')
                ->orderBy('r.created', 'DESC')  // most recent first
                ->getQuery()
                ->getResult();
        }

    }


//    /**
//     * @return Coll[] Returns an array of Coll objects
//     */
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
    public function findOneBySomeField($value): ?Coll
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
