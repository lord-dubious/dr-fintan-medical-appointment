<?php

namespace App\Services\Daily\Endpoints;

trait Logs
{
    public function logs(array $data = [])
    {
        return $this->get('/logs', $data);
    }
}
