<?php

namespace App\Modules\Security\Services;

use App\Modules\Security\DTO\ConfirmationEmailCodeDTO;
use Illuminate\Support\Facades\Cache;

class ConfirmationCodePasswordReset
{
    public function confirmation(ConfirmationEmailCodeDTO $DTO): bool
    {
        $cache = Cache::get('reset_password'.$DTO->email);
        if ($DTO->code == $cache['code'] and $DTO->email == $cache['reset_password_email'] ) {
            return true;
        } else throw new \Exception('Проверьте код безопасности и повторите попытку');
    }
}
