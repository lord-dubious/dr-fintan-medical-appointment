<?php

namespace App\Services\Daily\Endpoints;

trait Rooms
{
    public function rooms(array $data = [])
    {
        return $this->get('rooms', $data);
    }

    public function createRoom(array $data = [])
    {
        return $this->post('rooms', $data);
    }

    public function room(string $roomName, array $data = [])
    {
        return $this->get("rooms/{$roomName}", $data);
    }

    public function updateRoom(string $roomName, array $data = [])
    {
        return $this->post("rooms/{$roomName}", $data);
    }

    public function deleteRoom(string $roomName, array $data = [])
    {
        return $this->delete("rooms/{$roomName}", $data);
    }
}
