<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ExpenseReport;
use App\Form\ExpenseReportForm;
use App\Enum\ExpenseReportTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
        
        return new JsonResponse($result);
    }

    #[Route('/{userId}/expense-report/{expenseReportId}', name: 'app_expensereport',
        methods: ['GET'],
        requirements: ['userId' => '\d+', 'expenseReportId' => '\d+']
    )]
    public function findOne(EntityManagerInterface $manager, SerializerInterface $serializer, int $userId, int $expenseReportId): Response
    {
        $expenseReport = $manager
            ->getRepository(ExpenseReport::class)
            ->findOneByuser($userId, $expenseReportId);

        if (!$expenseReport) {
            return new JsonResponse(['result' => 'NOT FOUND'], Response::HTTP_NOT_FOUND);
        }

        $result = $serializer->serialize(['result' => $expenseReport], 'json');

        return new Response(
            $result,
            Response::HTTP_OK,
            ['Content-type' => 'application/json']
        );
    }

    #[Route('/{userId}/expense-report/{expenseReportId}', name: 'app_expensereport_delete',
        methods: ['DELETE'],
        requirements: ['userId' => '\d+', 'expenseReportId' => '\d+']
    )]
    public function delete(EntityManagerInterface $manager, int $userId, int $expenseReportId): JsonResponse
    {
        $expenseReport = $manager
            ->getRepository(ExpenseReport::class)
            ->findOneByuser($userId, $expenseReportId);

        if (!$expenseReport) {
            return new JsonResponse(['result' => 'NOT FOUND'], 404);
        }

        $manager->remove($expenseReport);
        $manager->flush();

        return new JsonResponse(['result' => 'OK']);       
    }

    #[Route('/{userId}/expense-report', name: 'app_expensereport_create',
        methods: ['POST'],
        requirements: ['userId' => '\d+']
    )]
    #[Route('/{userId}/expense-report/{expenseReportId}', name: 'app_expensereport_update',
        methods: ['PATCH'],
        requirements: ['userId' => '\d+', 'expenseReportId' => '\d+']
    )]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        ValidatorInterface $validator,
        int $userId,
        ?int $expenseReportId
    ): JsonResponse
    {

        $user = $manager->getRepository(User::class)->find($userId);

        if (!$user) {
            return new JsonResponse(['result' => 'NOT FOUND'], 404);
        }

        if (!$expenseReportId) {
            $expenseReport = new ExpenseReport;
        } else {
            $expenseReport = $manager
                ->getRepository(ExpenseReport::class)
                ->findOneByUser($userId, $expenseReportId)
            ;
            if (!$expenseReport) {
                return new JsonResponse(['result' => 'NOT FOUND'], 404);
            }
        }

        if ($content = json_decode($request->getContent())) {
            $expenseReportForm = new ExpenseReportForm();
            $expenseReportForm
                ->setExpenseDate($content->date)
                ->setAmount($content->amount)
                ->setExpenseType($content->type)
                ->setCompany($content->company)
            ;
        } else {
            return new JsonResponse(['result' => 'INVALID DATA'], 400);
        }

        
        $errors = $validator->validate($expenseReportForm);
        if (count($errors) == 0) {
            $expenseDate = \DateTime::createFromFormat('Y-m-d', $expenseReportForm->getExpenseDate());
            $expenseType = ExpenseReportTypeEnum::from($expenseReportForm->getExpenseType());

            $expenseReport
                ->setExpenseDate($expenseDate)
                ->setAmount($expenseReportForm->getAmount())
                ->setExpenseType($expenseType)
                ->setCompany($expenseReportForm->getCompany())
                ->setUser($user);
            ;
            $manager->persist($expenseReport);
            $manager->flush();
    
            return new JsonResponse(['result' => 'OK']);
        }

        $result = ['result' => ['errors' => []]];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $result['result']['errors'][] = [$error->getPropertyPath() => $error->getMessage()];
        }
        return new JsonResponse($result, 400);
    }
}