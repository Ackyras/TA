<?php

namespace App\Http\Controllers\Dashboard\Setting\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Interfaces\Repository\UserRepositoryInterface;

class UserController extends Controller
{
    private UserRepository $repo;

    public function __construct(UserRepository $userRepository)
    {
        $this->repo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        //
        $users = $this->repo->index();
        $userTable = $this->repo->prepareDatatable($users->toArray());
        return view('pages.dashboard.user.index', compact('userTable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreUserRequest  $request
     *
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     *
     */
    public function show(User $user)
    {
        //
        dd($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     *
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     *
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     *
     */
    public function destroy(User $user)
    {
        //
    }
}
