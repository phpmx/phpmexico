<?php

namespace App\Tests\Unit\Service;

use App\Service\GetLatestMeetupEventFromCrawler;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetLatestMeetupEventFromCrawlerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();
    }

    /**
     * @test
     */
    public function theServiceShouldCrawlTheEvent(): void
    {
        $source = self::$container->getParameter('meetup_events_url');
        $getLatestEvent = self::$container->get(GetLatestMeetupEventFromCrawler::class);
        $meetupEvent = $getLatestEvent->handle();

        $this->assertSame($meetupEvent->getMeetupId(), 123456);
        $this->assertSame($meetupEvent->getUrl(), $source. 123456);
        $this->assertSame($meetupEvent->getTitle(), 'El título del meetup');
        $this->assertSame($meetupEvent->getAttendingCount(), 50);
        $this->assertSame($meetupEvent->getDescription(), 'La decripción del meetup');
        $this->assertSame(
            '2020-07-22 14:00:00',
            $meetupEvent->getScheduledAt()->format('Y-m-d H:i:s')
        );
    }
}
