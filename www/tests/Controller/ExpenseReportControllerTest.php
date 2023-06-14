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
        $client->request('GET', '/1/expense-report/3');

        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(404);
        $this->assertSame($client->getResponse()->getContent(), '{"result":"NOT FOUND"}');
        $this->assertResponseHasHeader('content-type', 'application/json');
    }
    public function testDelete(): void
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('DELETE', '/1/expense-report/1');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');

        // Request a specific page
        $client->request('DELETE', '/1/expense-report/3');

        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(404);
        $this->assertSame($client->getResponse()->getContent(), '{"result":"NOT FOUND"}');
        $this->assertResponseHasHeader('content-type', 'application/json');
    }

    public function testCreate(): void
    {
        $client = static::createClient();

        // Request a successful expense report creation
        $client->request('POST', '/1/expense-report', [], [], [], '{"date":"2023-06-16","amount":21.90, "type":"Péage","company":"Kiss The Bride"}');
        
        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');

        // User not found request
        $client->request('POST', '/2/expense-report', [], [], [], '{"date":"2023-06-16","amount":21.90, "type":"Péage","company":"Kiss The Bride"}');
        
        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(404);
        $this->assertSame($client->getResponse()->getContent(), '{"result":"NOT FOUND"}');
        $this->assertResponseHasHeader('content-type', 'application/json');

        // Invalid JSON
        $client->request('POST', '/1/expense-report', [], [], [], 'fake data');
        
        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(400);
        $this->assertSame($client->getResponse()->getContent(), '{"result":"INVALID DATA"}');
        $this->assertResponseHasHeader('content-type', 'application/json');

        // Invalid data
        $client->request('POST', '/1/expense-report', [], [], [], '{"date":"16/06/2023","amount":21.90, "type":"Péage","company":"Kiss The Bride"}');
        
        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(400);
        $this->assertSame($client->getResponse()->getContent(), '{"result":{"errors":[{"expenseDate":"This value is not a valid date."}]}}');
        $this->assertResponseHasHeader('content-type', 'application/json');
    }

    public function testUpdate(): void
    {
        $client = static::createClient();

        // Request a successful expense report creation
        $client->request('PATCH', '/1/expense-report/1', [], [], [], '{"date":"2023-06-16","amount":21.90, "type":"Péage","company":"Kiss The Bride"}');
        
        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertResponseHasHeader('content-type', 'application/json');

        // User not found request
        $client->request('PATCH', '/2/expense-report/1', [], [], [], '{"date":"2023-06-16","amount":21.90, "type":"Péage","company":"Kiss The Bride"}');
        
        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(404);
        $this->assertSame($client->getResponse()->getContent(), '{"result":"NOT FOUND"}');
        $this->assertResponseHasHeader('content-type', 'application/json');

        // ExpenseReport not found request
        $client->request('PATCH', '/2/expense-report/3', [], [], [], '{"date":"2023-06-16","amount":21.90, "type":"Péage","company":"Kiss The Bride"}');
        
        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(404);
        $this->assertSame($client->getResponse()->getContent(), '{"result":"NOT FOUND"}');
        $this->assertResponseHasHeader('content-type', 'application/json');

        // Invalid JSON
        $client->request('PATCH', '/1/expense-report/1', [], [], [], 'fake data');
        
        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(400);
        $this->assertSame($client->getResponse()->getContent(), '{"result":"INVALID DATA"}');
        $this->assertResponseHasHeader('content-type', 'application/json');

        // Invalid data
        $client->request('PATCH', '/1/expense-report/1', [], [], [], '{"date":"16/06/2023","amount":21.90, "type":"Péage","company":"Kiss The Bride"}');
        
        // Validate an unsuccessful response and some content
        $this->assertResponseStatusCodeSame(400);
        $this->assertSame($client->getResponse()->getContent(), '{"result":{"errors":[{"expenseDate":"This value is not a valid date."}]}}');
        $this->assertResponseHasHeader('content-type', 'application/json');
    }
}