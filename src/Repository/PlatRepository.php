<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plat>
 */
class PlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }

    public function findByCategorieId(int $categorieId): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.categorie', 'c') // Соединяем с сущностью Categorie
            ->where('c.id = :categorieId') // Фильтруем по ID категории
            ->setParameter('categorieId', $categorieId) // Передаем параметр
            ->getQuery() // Формируем запрос
            ->getResult(); // Выполняем запрос и возвращаем результат
    }
}

    //    /**
    //     * @return Plat[] Returns an array of Plat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Plat
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

