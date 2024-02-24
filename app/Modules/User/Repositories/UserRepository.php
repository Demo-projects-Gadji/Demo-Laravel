<?php

namespace App\Modules\User\Repositories;

use App\Modules\Base\Repositories\BaseRepository;
use App\Models\User;
use App\Modules\User\Services\PhoneService;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new User();
    }

    public function getByEmailPhoneUsername(string $search)
    {
        return User::where(function (Builder $query) use ($search) {
            $query->where('username',$search);
            $query->orWhere('number', $search);
            $query->orWhere('email', $search);
        })->first();
    }

    public function getByEmail(string $email)
    {
        return User::where('email','=',$email)->first();
    }

    public function getByToken(string $user_token): ?User
    {
        return User::where('user_token','=',$user_token)->first();
    }
}
