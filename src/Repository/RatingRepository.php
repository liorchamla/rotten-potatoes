<?php

namespace App\Repository;

use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Movie;
use App\Entity\User;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function findAllWithRelations()
    {
        return $this->createQueryBuilder("r")
            ->addSelect("m, a")
            ->innerJoin("r.movie", "m")
            ->innerJoin("r.author", "a")
            ->getQuery()
            ->getResult();
    }

    public function findRatingForMovieAndUser(Movie $movie, User $user)
    {
        return $this->createQueryBuilder("r")
            ->select("COUNT(r)")
            ->andWhere("r.author = :user")
            ->andWhere("r.movie = :movie")
            ->setParameters(["movie" => $movie, "user" => $user])
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return Rating[] Returns an array of Rating objects
    //  */
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
    public function findOneBySomeField($value): ?Rating
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
