<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = ['Notebook', 'Ipad', 'Mobile Phone', 'Smart Watch', 'Headset'];
        for ($i = 0; $i < 5; $i++) {
            $product = new Product();
            $product->setName($products[array_rand($products)]);
            $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
