<?php

namespace App\Modules\User\Services;


use App\Modules\Security\Services\HashService;
use App\Modules\User\DTO\UserChangePasswordDTO;
use App\Modules\User\DTO\UserUpdateDTO;
use App\Models\User;
use App\Modules\User\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        public HashService $hashService,
        public PhoneService $phoneService,
        public UserRepository $userRepository,
    ){}

    public function update(UserUpdateDTO $dto)
    {
        $user = $this->userRepository->getByToken($dto->user_token);

        if(empty($user)){
            throw new \DomainException(__('.message.user.not_found'));
        }

        $user->username = $dto->username ?? $user->username;
        $user->avatar = $dto->avatar ?? $user->avatar;
        $user->link = $dto->link ?? $user->link;
        $user->date_birth = $dto->date_birth ?? $user->date_birth;
        $user->pol = $dto->pol ?? $user->pol;
        $user->description = $dto->description ?? $user->description;
        $user->name = $dto->name ?? $user->name;
        $user->surname = $dto->surname ?? $user->surname;
        $user->email = $dto->email ?? $user->email;
        $user->private = $dto->private ?? $user->private;
        $user->entrypoint = $dto->entrypoint ?? $user->entrypoint;
        $user->token_notification = $dto->token_notification ?? $user->token_notification;

        $user->save();

        return $user->getChanges();
    }

    public function changePassword(UserChangePasswordDTO $dto) :?User
    {
        $user = $this->userRepository->getByEmail($dto->email);

        if(empty($user)){
            throw new \DomainException('К сожалению, мы не смогли аутентифицировать или авторизовать вас на нашей платформе.
//            Пожалуйста, проверьте свои учетные данные и попробуйте снова. Если проблема сохраняется, обратитесь в службу поддержки');
        }

        $user->password = Hash::make($dto->new_password);
        $user->password_changed_at = Carbon::now()->toDateTimeString();

        $user->save();
        return $user;
    }

    public function delete(?int $userId) :void
    {
        $user = $this->userRepository->getById($userId);

        if(empty($user)){
            throw new \DomainException(__('.message.user.not_found'));
        }

        $user->delete();
    }

}
