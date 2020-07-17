<?php

namespace App\Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GetLatestMeetupEventCommandTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        date_default_timezone_set('America/Mexico_City');
    }

    /**
     * @test
     */
    public function commandShouldCreateARecord(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('phpmx:meetup:last-event');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
             '--env' => 'test',
        ]);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            'Event retrieved and persisted',
            $output
        );
    }

    /**
     * @test
     * @depends commandShouldCreateARecord
     */
    public function commandShouldUpdateARecord(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('phpmx:meetup:last-event');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--env' => 'test',
        ]);
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            'Cached event was updated successfully',
            $output
        );
    }
}
