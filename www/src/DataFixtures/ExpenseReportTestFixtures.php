<?php

namespace App\DataFixtures;

use App\Entity\ExpenseReport;
use App\Entity\User;
use App\Enum\ExpenseReportTypeEnum;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExpenseReportTestFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void
    {
        $expenseReport = new ExpenseReport();
        $expenseReport
            ->setUser($this->getReference(UserTestFixtures::USER_REFERENCE, User::class))
            ->setExpenseDate(new \DateTime('2023-06-11'))
            ->setAmount(17.89)
            ->setExpenseType(ExpenseReportTypeEnum::MEAL)
            ->setCompany('Kiss The Bride')
        ;

        $manager->persist($expenseReport);

        $expenseReport = new ExpenseReport();
        $expenseReport
            ->setUser($this->getReference(UserTestFixtures::USER_REFERENCE, User::class))
            ->setExpenseDate(new \DateTime('2023-06-12'))
            ->setAmount(12)
            ->setExpenseType(ExpenseReportTypeEnum::TOLL)
            ->setCompany('Giant Consulting')
        ;

        $manager->persist($expenseReport);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserTestFixtures::class,
        ];
    }
}
