<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new Users();
        $user -> setEmail('test@test.ru');
        $user -> setPassword('$2y$13$gn2zk/DoZkg8.dgQi5/jMeBSZBtGvCvkADvAL5qHa/BKftrbZz3WS');
        $user -> setRoles (['ROLE_USER']);

        $manager -> persist($user);

        $manager->flush();
    }
}
