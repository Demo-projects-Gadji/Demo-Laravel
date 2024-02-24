<?php

namespace App\Modules\Publication\Services;

use App\Models\Publication;
use App\Modules\HashTag\Services\HashTagService;
use App\Modules\Publication\DTO\PublicationCreateDTO;
use App\Modules\Survey\DTO\CreateDTO;
use App\Modules\Survey\Services\SurveyService;
use App\Modules\User\Repositories\UserRepository;
use App\Traits\AMQPTrait;
use Illuminate\Support\Facades\DB;

class PublicationService
{
    use AMQPTrait;
    public function __construct(
       public UserRepository $userRepository,
       public SurveyService $surveyService,
       public HashTagService $hashTagService,
    ){}

    public function create(PublicationCreateDTO $dto)
    {
        $user = $this->userRepository->getByToken($dto->user_token);

        DB::transaction(function () use($dto,$user){
            $publication = Publication::create([
                'user_id' => $user->id,
                'type' => $dto->type,
                'media' => $dto->media,
                'description' => $dto->description,
                'name' => $dto->name,
                'share_id' => $dto->share_id,
                'type_publication' => $dto->type_publication,
                'effect' => $dto->effect,
                'speed' => $dto->speed,
                'collage' => $dto->collage,
                'duo' => $dto->duo,
                'settings_show_likes' => $dto->settings_show_likes,
                'preview_url' => $dto->preview_url,
                'has_comment' => $dto->has_comment,
                'shard_share' => $dto->shard_share,
            ]);

            if ($dto->survey_data)
            {
                $surveyDTO = new CreateDTO(
                    $publication->id,
                    $dto->survey_data['survey_name'],
                    $dto->survey_data['survey_duration'],
                    $dto->survey_data['survey_button_data']
                );

                $this->surveyService->create($surveyDTO);
            }

            if ($dto->hashtags)
            {
                $hashtagCreateDTO = new \App\Modules\HashTag\DTO\CreateDTO(
                    $publication->id,
                    $dto->hashtags
                );

                $this->hashTagService->create($hashtagCreateDTO);

            }
        },3);
    }
}
