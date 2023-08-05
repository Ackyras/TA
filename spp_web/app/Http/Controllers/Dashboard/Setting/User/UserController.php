<?php

namespace App\Http\Controllers\Dashboard\Setting\User;

use App\Models\User;
use App\Models\Village;
use App\Models\Division;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Middleware\ScopePeriod;
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
        $divisions = Division::all();
        $villages = Village::all();
        $roles = Role::all();

        return view('pages.dashboard.user.create', compact('divisions', 'villages', 'roles'));
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
        $validated = $request->validated();
        dd($validated);
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
        $user = $this->repo->show($user);

        $divisions = Division::all();
        $villages = Village::all();
        $roles = Role::all();

        return view('pages.dashboard.user.show', compact('user', 'divisions', 'villages', 'roles'));
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
        if ($this->repo->update($request->validated(), $user)) {
            return back()->with(
                [
                    'created'   =>  __('message.user.updated')
                ]
            );
        }
        return back()->with(
            [
                'failed'   =>  __('message.user.notUpdated')
            ]
        );
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
