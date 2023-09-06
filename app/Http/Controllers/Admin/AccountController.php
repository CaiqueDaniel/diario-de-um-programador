<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UserRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function edit(): View
    {
        $user = auth()->user();

        return view('pages.admin.account.form', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->userService->update($request, $user);

        session()->flash('message', __('User edited successifuly'));

        return redirect()->route('admin.account.edit');
    }
}
