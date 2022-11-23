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
        if ($this->usersService->delete($id))
            return redirect(route('users.index'));
        else
            return redirect()->back()->with('error_message', 'Delete all the quizzes created before deleting the account');
    }
}
