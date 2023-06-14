<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['user'];
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setLastName('PATON')
            ->setFirstName('Guillaume')
            ->setEmail('freelance@guillaumepaton.fr')
            ->setBirthdate(new \DateTime('1980-09-27'))
        ;

        $manager->persist($user);

        $manager->flush();
    }
}
