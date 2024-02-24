<?php

namespace App\Modules\Security\Services;

use App\Modules\Security\DTO\SendCodeDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendEmailRegisterService
{
    public function registerEmail(SendCodeDTO $DTO): array
    {
        $code = rand(1000, 9000);

        $message = [
            'code' => $code
        ];

        Mail::to($DTO->email)->send(new \App\Mail\UserMail($message));

        Cache::put('new_user'.$DTO->email,['email' => $DTO->email, 'code' => $code]);

        return ['code' => $code];
    }
}
