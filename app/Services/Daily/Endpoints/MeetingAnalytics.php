<?php

namespace App\Services\Daily\Endpoints;

trait MeetingAnalytics
{
    public function meetingAnalytics(array $data = [])
    {
        return $this->get('meetings', $data);
    }
}
