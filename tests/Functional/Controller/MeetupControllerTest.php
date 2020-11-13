<?php

namespace App\Tests\Functional\Controller;

use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class MeetupControllerTest extends WebTestCase
{
    use RecreateDatabaseTrait;

    /** @test */
    public function guestsCanSeeMeetupEventsPage()
    {
        $client = static::createClient();
        $client->request('GET', '/meetup');
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSelectorTextContains('h3', 'Eventos');
        $this->assertSelectorExists('.card');
    }
}
