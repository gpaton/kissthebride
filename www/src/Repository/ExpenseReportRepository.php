<?php

namespace App\Repository;

use App\Entity\ExpenseReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExpenseReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseReport::class);
    }

    /**
     * @return ExpenseReport[] Returns an array of ExpenseReport objects
     */
    public function findAllByuser($userId): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.expenseDate, e.amount, e.expenseType, e.createdAt, e.company')
            ->andWhere('e.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('e.expenseDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
