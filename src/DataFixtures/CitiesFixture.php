<?php

namespace App\DataFixtures;

use App\Entity\Cities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CitiesFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$cities = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California','Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii','Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana','Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota','Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire','New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota','Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island','South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont','Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']; 

        for ($index = 0; $index < count($cities); $index++)
        {
        	$city = new Cities();
        	$cityName = $cities[$index];
        	$city->setName($cityName);
        	// slug is just a lowercase version of the string and without whitespaces 
        	$city->setSlug(str_replace(" ", "-", mb_strtolower($cityName)));
        	$manager->persist($city);
        }
        
        $manager->flush();
    }
}
