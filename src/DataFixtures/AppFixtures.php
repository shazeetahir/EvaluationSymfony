<?php

namespace App\DataFixtures;

use App\Entity\Decouvert;
use Faker\Factory as Faker;
use App\DataFixtures\ContinentFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();
        for ($i = 0; $i < 5; $i++){
            $decouvert = new Decouvert();
            $decouvert->setDescription($faker->text(200));

            $randomPhoto = random_int(1, 3);
            $decouvert->setImage("default$randomPhoto.jpg");


            $randomContinent = random_int(0, 4);
            $decouvert->setContinent($this->getReference("continent$randomContinent"));
            
            $manager->persist($decouvert);
        }
            // $product = new Product();
            // $manager->persist($product);
            
            $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ContinentFixtures::class,
        );
    }
}
