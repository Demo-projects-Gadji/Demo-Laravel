<?php

namespace App\Modules\Security\Services;

use App\Models\User;
use App\Modules\Security\DTO\SendCodeDTO;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendEmailCodePasswordResetService
{
    public function __construct(public UserRepository $userRepository){}

    public function sendCodeEmailResetPassword(SendCodeDTO $DTO): array
    {
        $user = $this->userRepository->getByEmail($DTO->email);
        if(empty($user)){
            throw new \DomainException('К сожалению, мы не смогли аутентифицировать или авторизовать вас на нашей платформе. Пожалуйста, проверьте свои учетные данные и попробуйте снова. Если проблема сохраняется, обратитесь в службу поддержки.');
        }

        $code = rand(1000, 9000);

        $message = [
            'code' => $code
        ];

        Mail::to($DTO->email)->send(new \App\Mail\UserMail($message));

        Cache::put('reset_password'.$DTO->email, ['reset_password_email' => $DTO->email, 'code' => $code]);

        return ['code' => $code];
    }
}
