<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExpenseReportControllerTest extends WebTestCase
{
    public function testFindAll(): void
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', '/1/expense-reports');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');
    }

    public function testFindOne(): void
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', '/1/expense-report/1');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');

        // Request a specific page
        $client->request('GET', '/1/expense-report/2');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');
    }
}