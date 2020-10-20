<?php

namespace App\Contracts;

use App\Entity\MeetupEvent;

interface GetLastMeetupEventInterface
{
    public function handle(): MeetupEvent;
}
