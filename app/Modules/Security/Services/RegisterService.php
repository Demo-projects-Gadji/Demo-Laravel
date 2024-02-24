<?php

namespace App\Modules\Security\Services;

use App\Models\StoriesSetting;
use App\Models\User;
use App\Modules\Security\DTO\RegisterDTO;
use App\Modules\User\Enums\UserStatusEnum;
use App\Modules\User\Services\PhoneService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterService
{
    public function __construct(
        public PhoneService $phoneService
    ){}

    public function register(RegisterDTO $dto) :User
    {
        if (Cache::get('new_user'.$dto->email))
        {
            Cache::delete('new_user'.$dto->email);
        }else{
            throw new \Exception('Истек срок действия кода, отправьте код снова');
        }

       $user = new User();
       $user->username = $dto->username;
       $user->password = Hash::make($dto->password);
       $user->email = $dto->email;
       $user->user_token = Str::random(32);
       $user->status = 'онлайн';
       $user->sys_status = UserStatusEnum::active->value;
       $user->save();

       $user->clipSetting()->firstOrCreate();
       $user->storiesSetting()->firstOrCreate(['answer' => StoriesSetting::all]);

       return $user->fresh();
    }
}
