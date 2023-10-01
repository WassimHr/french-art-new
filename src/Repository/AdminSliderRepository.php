<?php

namespace App\Repository;

use App\Entity\AdminSlider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdminSlider>
 *
 * @method AdminSlider|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminSlider|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminSlider[]    findAll()
 * @method AdminSlider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminSliderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminSlider::class);
    }

//    /**
//     * @return AdminSlider[] Returns an array of AdminSlider objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AdminSlider
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
