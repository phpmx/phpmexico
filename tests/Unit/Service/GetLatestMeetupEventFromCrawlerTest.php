<?php

namespace App\Tests\Unit\Service;

use App\Service\GetLatestMeetupEventFromCrawler;
use Exception;
use PHPUnit\Framework\TestCase;

class GetLatestMeetupEventFromCrawlerTest extends TestCase
{
    /**
     * @test
     */
    public function theServiceShouldCrawlTheEvent(): void
    {
        $source = __DIR__.'/../../fixtures/meetup_response_example.html';
        $getLatestEvent = new GetLatestMeetupEventFromCrawler($source);
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

    /**
     * @test
     */
    public function theServiceShouldFailIfSourceIsWrong(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to read the provided source test.');

        $getLatestEvent = new GetLatestMeetupEventFromCrawler('test');
        $getLatestEvent->handle();
    }
}
