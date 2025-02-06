<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use ReflectionProperty;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        include 'resto.php';

        $categorieMap = [];

        // Загружаем категории с принудительным присвоением ID
        foreach ($categorie as $cat) {
            $categorieDB = new Categorie();
            
            // Принудительно устанавливаем ID
            $reflection = new ReflectionProperty(Categorie::class, 'id');
            $reflection->setAccessible(true);
            $reflection->setValue($categorieDB, (int) $cat['id']);
        
            $categorieDB
                ->setLibelle($cat['libelle'])
                ->setImage($cat['image'])
                ->setActive($cat['active'] === 'Yes');
        
            $manager->persist($categorieDB);
            
            // 🔥 Фикс: сохраняем категорию в массив для связи с блюдами
            $categorieMap[$cat['id']] = $categorieDB;
        }
        
        $manager->flush(); // Сохраняем категории в БД

        // Загружаем блюда
        foreach ($plat as $dish) {
            if (!isset($categorieMap[$dish['id_categorie']])) {
                dump("❌ Ошибка: Категория с ID {$dish['id_categorie']} не найдена!");
                continue;
            }

            $platDB = new Plat();
            $platDB
                ->setTitle($dish['libelle'])
                ->setDescription($dish['description'])
                ->setPrix($dish['prix'])
                ->setImage($dish['image'])
                ->setCategorie($categorieMap[$dish['id_categorie']]);

            $manager->persist($platDB);
        }

        $manager->flush(); // Сохраняем блюда
    }
}
