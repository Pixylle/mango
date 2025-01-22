<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function findActiveCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.active = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }

    public function findTopCategories(int $limit): array
    {
        return $this->createQueryBuilder('c')
            // Присоединяем блюда (Plat)
            ->leftJoin('c.plats', 'p')
            // Присоединяем детали (Detail)
            ->leftJoin('p.details', 'd')
            // Присоединяем заказы (Commande) через детали
            ->leftJoin('d.commande', 'com')
            // Добавляем поле libelle категории
            ->addSelect('c.libelle')
            // Добавляем поле image категории
            ->addSelect('c.image') 
            // Суммируем количество для каждой категории через связи с деталями
            ->addSelect('SUM(d.quantite) AS total_quantite') // Суммируем количество
            // Группируем по ID категории
            ->groupBy('c.id')
            // Сортируем по сумме количеств по убыванию
            ->orderBy('total_quantite', 'DESC')
            // Ограничиваем 6 результатами
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    
    
    


    

    public function activateAllCategories(): void
{
    $qb = $this->createQueryBuilder('c');
    $qb->update()
        ->set('c.active', ':active')
        ->setParameter('active', true)
        ->getQuery()
        ->execute();
}

}
