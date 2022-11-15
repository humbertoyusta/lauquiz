<?php

namespace App\Http\Controllers;

use App\Services\UsersService;

class UsersController extends Controller
{
    public function __construct(
        public UsersService $usersService,
    ) 
    {}

    public function index ()
    {
        return view('users.index', [
            'users' => $this->usersService->get(),
        ]);
    }

    public function destroy (int $id)
    {
        $this->usersService->delete($id);

        return redirect(route('users.index'));
    }
}
