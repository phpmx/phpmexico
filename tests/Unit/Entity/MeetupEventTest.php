<?php

namespace App\Tests\Unit\Entity;

use App\Entity\MeetupEvent;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetupEventTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /** @var EntityManagerInterface */
    private $em;

    /** @test */
    public function theMeetupEventShouldGenerateASlug(): void
    {
        $meetupEvent = new MeetupEvent();
        $meetupEvent
            ->setTitle('Hello world!')
            ->setMeetupId(123456789)
            ->setScheduledAt(new DateTime())
            ->setUrl('http://example.com');
        $this->em->persist($meetupEvent);
        $this->em->flush();

        $this->assertSame('hello-world', $meetupEvent->getSlug());
    }

    /** @test */
    public function theSlugShouldBeUnique(): void
    {
        $meetupEvent = new MeetupEvent();
        $meetupEvent
            ->setTitle('Hello world!')
            ->setMeetupId(123456789)
            ->setScheduledAt(new DateTime())
            ->setUrl('http://example.com');

        $duplicateMeetupEvent = new MeetupEvent();
        $duplicateMeetupEvent
            ->setTitle('Hello world!')
            ->setMeetupId(123456788)
            ->setScheduledAt(new DateTime())
            ->setUrl('http://example.com');

        $this->em->persist($meetupEvent);
        $this->em->persist($duplicateMeetupEvent);
        $this->em->flush();

        $this->assertSame('hello-world-1', $duplicateMeetupEvent->getSlug());
    }

    protected function setUp(): void
    {
        $this->em = $this->bootKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
