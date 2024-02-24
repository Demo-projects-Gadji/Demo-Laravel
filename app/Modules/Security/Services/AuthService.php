<?php

namespace App\Modules\Security\Services;

use App\Models\User;
use App\Modules\Security\DTO\AuthDTO;
use App\Modules\User\Enums\UserStatusEnum;
use App\Modules\User\Repositories\UserRepository;
class AuthService
{
    public function __construct(
        public HashService $hashService,
        public UserRepository $userRepository,
    ){}

    public function login(AuthDTO $dto) : User
    {
        $user = $this->userRepository->getByEmailPhoneUsername($dto->login);

        if (!$user) {
            throw new \DomainException('Неверный логин или пароль');
        }

        if($user->sys_status === UserStatusEnum::blocked->value){
            throw new \DomainException(__('message.user.blocked'));
        }

        if($user->sys_status === UserStatusEnum::not_confirmed->value){
            throw new \DomainException(__('message.user.not_confirmed'));
        }

        $isRightPassword = $this->hashService->isHashEquals($user->password, $dto->password);

        if(!$isRightPassword){
            throw new \DomainException('Неверный логин или пароль');
        }

        return $user;
    }
}
