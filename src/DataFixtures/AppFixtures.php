<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Appointment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i = 0; $i<200; $i++){
            $appointment = new Appointment();
            $appointment->setName($faker->name);
            $appointment->setPlace($faker->city);
            $appointment->setPriority($faker->numberBetween(1, 3));
            $appointment->setBeginDate($faker->dateTimeBetween('-1 years', 'now'));
            $appointment->setEndDate($faker->dateTimeBetween('+50days', '+1 years'));
            $manager->persist($appointment);
        }

        $manager->flush();
    }
}
