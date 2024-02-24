<?php

namespace App\Modules\Survey\Services;

use App\Models\Survey;
use App\Modules\Survey\DTO\CreateDTO;
class SurveyService
{
    public function create(CreateDTO $DTO): void
    {
        $survey = Survey::create([
            'publication_id' => $DTO->publication_id,
            'name' => $DTO->name,
            'duration' => $DTO->duration,
        ]);

        $buttonInsert = [];
        foreach ($DTO->button_data as $item)
        {
            $buttonInsert[] = [
                'survey_id' => $survey->id,
                'name' => $item['survey_button'],
                'correct' => $item['correct']
            ];

        }
        $survey->button()->insert($buttonInsert);
    }
}
