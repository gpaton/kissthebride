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

        $result = ['result' => $expenseReports];

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
}