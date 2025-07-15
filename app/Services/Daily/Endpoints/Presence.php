<?php

namespace App\Services\Daily\Endpoints;

trait Presence
{
    public function presence(array $data = [])
    {
        return $this->get('presence', $data);
    }
}
