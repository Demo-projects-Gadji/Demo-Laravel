<?php

namespace App\Modules\Survey\DTO;

class CreateDTO
{
    public function __construct(
        public int $publication_id,
        public string $name,
        public string $duration,
        public array $button_data
    ){}
}
