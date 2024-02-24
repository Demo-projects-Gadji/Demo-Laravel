<?php

namespace App\Modules\HashTag\DTO;

class CreateDTO
{
    public function __construct(
        public int $publication_id,
        public array $data,
    ){}
}
