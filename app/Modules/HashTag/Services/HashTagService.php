<?php

namespace App\Modules\HashTag\Services;

use App\Models\HashTag;
use App\Modules\HashTag\DTO\CreateDTO;

class HashTagService
{
    public function create(CreateDTO $DTO)
    {
        foreach ($DTO->data as $tag)
        {
            $hashtag = HashTag::firstOrCreate($tag);
            $hashtag->item()->create([
                'hashtag_id' => $hashtag->id,
                'item_id' => $DTO->publication_id
            ]);
        }
    }
}
