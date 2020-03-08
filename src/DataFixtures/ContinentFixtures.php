<?php

namespace App\DataFixtures;

use App\Entity\Continent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;


class ContinentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $continentNames = ['Afrique', 'Amérique', 'Asie', 'Europe', 'Océanie'];
		 
    	for($i = 0; $i < sizeof($continentNames); $i++){
		    $continent = new Continent();
		    $continent->setName($continentNames[$i]);

			// créer une référence pour mettre en relation les entités : mise en mémoire de l'instance
			$this->addReference("continent$i", $continent);
		    $manager->persist($continent);
	    }

        $manager->flush();
    }
}
