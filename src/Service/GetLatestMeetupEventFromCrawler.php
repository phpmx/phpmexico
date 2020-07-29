<?php

namespace App\Service;

use App\Contracts\GetLastMeetupEventInterface;
use App\Entity\MeetupEvent;
use DateTime;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

class GetLatestMeetupEventFromCrawler implements GetLastMeetupEventInterface
{
    /** @var CrawlNode */
    private $crawlNode;

    /** @var string */
    private $meetupEventsUrl;

    public function __construct(CrawlNode $crawlNode, string $meetupEventsUrl)
    {
        $this->crawlNode = $crawlNode;
        $this->meetupEventsUrl = $meetupEventsUrl;
    }

    public function handle(): MeetupEvent
    {
        $html = $this->getHtml();
        $crawler = new Crawler($html);
        $eventListNode = $crawler->filter('.eventList-list');

        $event = new MeetupEvent();
        $event
            ->setMeetupId($this->crawlId($eventListNode))
            ->setTitle($this->crawlTitle($eventListNode))
            ->setImage($this->crawlImage($eventListNode))
            ->setScheduledAt($this->crawlScheduledAt($eventListNode))
            ->setPlace($this->crawlPlace($eventListNode))
            ->setDescription($this->crawlDescription($eventListNode))
            ->setAttendingCount($this->crawlAttendingCount($eventListNode))
            ->setSpeaker($this->crawlSpeaker($eventListNode))
            ->setUrl($this->meetupEventsUrl.$event->getMeetupId());

        return $event;
    }

    /**
     * @throws Exception
     */
    private function getHtml(): string
    {
        $isRequest = strpos($this->meetupEventsUrl, 'http') !== false;

        if (!$isRequest && !file_exists($this->meetupEventsUrl)) {
            throw new Exception(sprintf('Unable to read the provided source %s.', $this->meetupEventsUrl));
        }

        return file_get_contents($this->meetupEventsUrl);
    }

    private function crawlId(Crawler $eventListNode): int
    {
        return $this->crawlNode->handle(
            function () use ($eventListNode) {
                $composedId = $eventListNode->filter('.eventCard')
                    ->eq(0)
                    ->attr('id');

                list(, $id) = explode('-', $composedId);

                return intval($id);
            },
            0,
            'Unable to find the meetupId element.'
        );
    }

    private function crawlScheduledAt(Crawler $eventListNode): DateTime
    {
        return $this->crawlNode->handle(
            function () use ($eventListNode) {
                $time = $eventListNode->filter('.eventTimeDisplay')
                    ->eq(0)
                    ->filter('time')
                    ->eq(0)
                    ->attr('datetime');

                $eventDate = new DateTime();

                return $eventDate->setTimestamp($time / 1000);
            },
            new DateTime(),
            'Unable to find the scheduled at element.'
        );
    }

    private function crawlTitle(Crawler $eventListNode): string
    {
        return $this->crawlNode->handle(
            function () use ($eventListNode) {
                return $eventListNode->filter('.eventCardHead--title')
                    ->eq(0)
                    ->text();
            },
            '',
            'Unable to find the title element.'
        );
    }

    private function crawlImage(Crawler $eventListNode): string
    {
        return $this->crawlNode->handle(
            function () use ($eventListNode) {
                $style = $eventListNode->filter('.eventCardHead--photo')
                    ->eq(0)
                    ->attr('style');


                $matches = [];
                preg_match('/("(.*?)")|(\'(.*?)\')|(&quotes;(.*?)&quotes;)/', $style, $matches);

                return $matches[count($matches) - 1];
            },
            '',
            'Unable to find the image element.'
        );
    }

    private function crawlPlace(Crawler $eventListNode): string
    {
        return $this->crawlNode->handle(
            function () use ($eventListNode) {
                return $eventListNode->filter('address')
                    ->eq(0)
                    ->filter('p')
                    ->eq(0)
                    ->text();
            },
            '',
            'Unable to find the place element.'
        );
    }

    private function crawlDescription(Crawler $eventListNode): string
    {
        return $this->crawlNode->handle(
            function () use ($eventListNode) {
                return $eventListNode->filter('.eventCard')
                    ->eq(0)
                    ->filter('p')
                    ->eq(2)
                    ->text();
            },
            '',
            'Unable to find the description element.'
        );
    }

    private function crawlAttendingCount(Crawler $eventListNode): int
    {
        return $this->crawlNode->handle(
            function () use ($eventListNode) {
                $attendingCount = $eventListNode->filter('.avatarRow--attendingCount')
                    ->eq(0)
                    ->filter('span')
                    ->eq(0)
                    ->text();

                return intval($attendingCount);
            },
            0,
            'Unable to find the attending count element.'
        );
    }

    private function crawlSpeaker(Crawler $eventListNode): string
    {
        // TODO: Implement this method when we got the filter selector
        return '';
    }
}
