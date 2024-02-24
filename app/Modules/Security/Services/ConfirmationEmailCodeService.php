<?php

namespace App\Modules\Security\Services;

use App\Modules\Security\DTO\ConfirmationEmailCodeDTO;
use Illuminate\Support\Facades\Cache;

class ConfirmationEmailCodeService
{
    public function confirmation(ConfirmationEmailCodeDTO $DTO): bool
    {
        $cache = Cache::get('new_user'.$DTO->email);
        if ($DTO->code == $cache['code'] and $DTO->email == $cache['email'] ) {
           return true;
        } else throw new \Exception('Проверьте код безопасности и повторите попытку');
    }
}
