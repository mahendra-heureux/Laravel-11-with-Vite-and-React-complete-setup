<?php
namespace App\Events;

class EventManager
{
    public function trigger($event, $data)
    {
        // Trigger an event
        event($event, $data);
    }
}
