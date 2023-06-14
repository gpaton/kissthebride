<?php

namespace App\Controller;

use App\Entity\ExpenseReport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpenseReportController extends AbstractController
{
    #[Route('/{userId}/expense-reports', name: 'app_expensereports',
        methods: ['GET'],
        requirements: ['userId' => '\d+']
    )]
    public function findAll(EntityManagerInterface $manager, int $userId): JsonResponse
    {
        $expenseReports = $manager
            ->getRepository(ExpenseReport::class)
            ->findAllByuser($userId);

        $result = ['result' => []];

        /** @var ExpenseReport $expenseReport */
        foreach ($expenseReports as $expenseReport) {
            $result['result'][] = [
                'id' => $expenseReport->getId(),
                'date' => $expenseReport->getExpenseDate()->format('d/m/Y'),
                'amount' => $expenseReport->getAmount(),
                'type' => $expenseReport->getExpenseType(),
                'company' => $expenseReport->getCompany(),
                'createdAt' => $expenseReport->getCreatedAt()->format('d/m/Y H:i:s')
            ];
        }

        // As I've not found how to make Serializer context work and time is ticking
        // I will use classic json_encode instead
        // Sample with Serializer just below
        /*$context = (new ObjectNormalizerContextBuilder())
            ->withGroups('expenseReport')
            ->toArray();
        $result = $serializer->serialize(['result' => $expenseReports], 'json', $context);
        */
        
        return new JsonResponse($result);
    }

    #[Route('/{userId}/expense-report/{expenseReportId}', name: 'app_expensereport',
        methods: ['GET'],
        requirements: ['userId' => '\d+', 'expenseReportId' => '\d+']
    )]
    public function findOne(EntityManagerInterface $manager, int $userId, int $expenseReportId): JsonResponse
    {
        $expenseReport = $manager
            ->getRepository(ExpenseReport::class)
            ->findOneByuser($userId, $expenseReportId);

        if (!$expenseReport) {
            return new JsonResponse(['result' => 'NOT FOUND'], 404);
        }
        $result = ['result' => [
            'id' => $expenseReport->getId(),
            'date' => $expenseReport->getExpenseDate()->format('d/m/Y'),
            'amount' => $expenseReport->getAmount(),
            'type' => $expenseReport->getExpenseType(),
            'company' => $expenseReport->getCompany(),
            'createdAt' => $expenseReport->getCreatedAt()->format('d/m/Y H:i:s')
        ]];

        return new JsonResponse($result);
    }
}