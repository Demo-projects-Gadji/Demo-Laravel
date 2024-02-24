<?php

namespace App\Modules\Publication\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreatePublicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /** Тип модели Публикация или Клип */
            'type' => ['required', 'string','in:publication,clip'],

            /** свободный массив с медия ресурсами */
            'media' => ['nullable','array'],

            'media.*.type' => ['required','in:image,video'],
            'media.*.size' => ['required','string'],
            'media.*.url' => ['required','string'],

            /** Описание */
            'description' => ['nullable','string'],

            /** Название */
            'name' => ['required', 'string'],

            /** ID публикации для репоста */
            'share_id' => ['nullable','int','exists:publications,id'],

            /** Тип публикации  */
            'type_publication' => ['string','in:standart,shard,arhived'],

            /** Клип: эффект  */
            'effect' => ['nullable','int'],

            /** Клип: скорость воспроизведения  */
            'speed' => ['nullable','int'],

            /** Клип: эффект  */
            'collage' => ['nullable','string'],

            /** Клип: режим дуо  */
            'duo' => ['nullable','bool'],

            /** Показывать лайки  */
            'settings_show_likes' => ['nullable','bool'],

            /** URL превью изображения  */
            'preview_url' => ['nullable','bool'],

            /** Показывать комментарии  */
            'has_comment' => ['nullable','bool'],

            /** Не показывать клип в ленте */
            'shard_share' => ['nullable','bool'],

            /** Опрос
             *
             *
             * survey_name - string - Название опроса
             *
             * survey_duration - string - Cколько он будет длиться
             *
             * survey_button_data - array - Массив с кнопками которые будут в опросе, необязательно передовать
             *
             * correct - является ли кнопка правильным ответом
             *
             *
             */
            'survey_data' => ['nullable','filled', 'array:survey_name,survey_duration,survey_button_data'],


            'survey_data.survey_button_data.*.survey_button' => ['required'],
            'survey_data.survey_button_data.*.correct' => ['required','bool'],

            /** Хештеги */
            'hashtags' => ['nullable','array'],
            'hashtags.*.name' => ['string','required']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,response( ['spec' => ['messages' => $validator->errors()]]));
    }
}
