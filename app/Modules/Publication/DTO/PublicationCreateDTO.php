<?php

namespace App\Modules\Publication\DTO;

class PublicationCreateDTO
{
     public function __construct(
        public string $user_token,
        public string $type,
        public array  $media,
        public string $description,
        public ?string $name,
        public ?int $share_id,
        public ?string $type_publication,
        public ?int $effect,
        public ?int $speed,
        public ?string $collage,
        public ?bool $duo,
        public ?bool $settings_show_likes,
        public ?string $preview_url,
        public ?bool $has_comment,
        public ?bool $shard_share,

        public ?array $survey_data,
        public ?array $hashtags,
     ){}
}
