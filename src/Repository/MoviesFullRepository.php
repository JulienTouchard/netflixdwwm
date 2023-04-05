<?php

namespace App\Repository;

use App\Entity\MoviesFull;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoviesFull>
 *
 * @method MoviesFull|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoviesFull|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoviesFull[]    findAll()
 * @method MoviesFull[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviesFullRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoviesFull::class);
    }

    public function save(MoviesFull $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MoviesFull $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return MoviesFull[] Returns an array of MoviesFull objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MoviesFull
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    /**
     * Ma jolie méthode pour sélectionner des films par genre
     */
    public function findByGenres($genre)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.genres LIKE :genre')
            ->setParameter('genre', "%$genre%")
            ->getQuery()
            ->getResult();
    }

    public function findRand($nb)
    {
        return $this->createQueryBuilder('m')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }
}
