<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Создаём пользователя с ролью ROLE_ADMIN
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpassword'));
        $manager->persist($admin);

        // Создаём пользователя с ролью ROLE_CHEF
        $chef = new User();
        $chef->setEmail('chef@example.com');
        $chef->setRoles(['ROLE_CHEF']);
        $chef->setPassword($this->passwordHasher->hashPassword($chef, 'chefpassword'));
        $manager->persist($chef);

        // Создаём пользователя с ролью ROLE_CLIENT
        $client = new User();
        $client->setEmail('client@example.com');
        $client->setRoles(['ROLE_CLIENT']);
        $client->setPassword($this->passwordHasher->hashPassword($client, 'clientpassword'));
        $manager->persist($client);

        // Сохраняем пользователей в базу данных
        $manager->flush();
    }
    
}
