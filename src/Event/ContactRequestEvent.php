<?php

namespace App\Event;

use App\DTO\ContactFormDTO;

class ContactRequestEvent
{
    public function __construct(
        public readonly ContactFormDTO $data 
    ) {
        
    }

    public function getData(): ContactFormDTO
    {
        return $this->data;
    }

    
}