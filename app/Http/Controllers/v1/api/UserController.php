<?php

namespace App\Http\Controllers\v1\api;

use App\Events\User\UserCollected;
use App\Events\User\UserCreated;
use App\Events\User\UserDeleted;
use App\Events\User\UserFetched;
use App\Events\User\UserUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUser;
use App\Http\Requests\User\DeleteUser;
use App\Http\Requests\User\IndexUser;
use App\Http\Requests\User\ShowUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\User;

// Custom Requests

// Custom Events

class UserController extends Controller
{
    public function index(IndexUser $request)
    {
        $paginated = $request->get('per_page', null);

        $data = User::when(
            $paginated,
            function ($query) use ($paginated) {
                return $query->paginate($paginated);
            },
            function ($query) {
                return $query->get();
            }
        );

        event(new UserCollected($data));

        return customResponse()
            ->data($data)
            ->message('Successfully collected record')
            ->success()
            ->generate();
    }

    public function store(CreateUser $request)
    {
        $data = $request->all();

        $model = User::create($data)->fresh();

        event(new UserCreated($model));

        return customResponse()
            ->data($model)
            ->message('Successfully created record')
            ->success()
            ->generate();
    }

    public function show(ShowUser $request, User $user)
    {
        event(new UserFetched($user));

        return customResponse()
            ->data($user)
            ->message('Successfully fetched record')
            ->success()
            ->generate();
    }

    public function update(UpdateUser $request, User $user)
    {
        $user->update($request->all());
        $user = $user->fresh();

        event(new UserUpdated($user));

        return customResponse()
            ->data($user)
            ->message('Successfully updated record')
            ->success()
            ->generate();
    }

    public function destroy(DeleteUser $request, User $user)
    {
        $user->delete();

        event(new UserDeleted($user));

        return customResponse()
            ->data($user)
            ->message('Successfully deleted record')
            ->success()
            ->generate();
    }
}
