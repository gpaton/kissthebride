<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UserTestFixtures extends Fixture implements FixtureGroupInterface
{
    public const USER_REFERENCE = 'user';

    public static function getGroups(): array
    {
        return ['test'];
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

        $this->addReference(self::USER_REFERENCE, $user);
    }
}
