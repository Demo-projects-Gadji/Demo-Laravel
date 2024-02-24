<?php

namespace App\Modules\Publication\Repositories;

use App\Models\Publication;
use App\Models\User;
use App\Modules\User\Repositories\UserRepository;

class PublicationRepository
{
    public function __construct(UserRepository $repository)
    {
        $this->model = new Publication();
    }

    public function getByUser(User $user,array $relations = null, int $view_user_id = null): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $builder = Publication::query();

        if(isset($relations)){
            $builder->with($relations);
        }

        return $builder
            ->where('user_id', '=',$view_user_id ?? $user->id)
            ->orderByDesc('pined')
            ->orderByDesc('created_at')
            ->cursorPaginate(10)
            ->through(function($publication) use($user)
            {
                $publication['interaction'] = $user->checkInteraction($publication);
                $publication['likedSubscription'] = $publication->likedSubscription($user->subscriptions()->wherePivot('accepted','=',1)->get()->pluck('id'))->get();
                return $publication;
            });
    }

}
