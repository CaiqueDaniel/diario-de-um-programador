<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Users\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(): View
    {
        $user = auth()->user();

        return view('pages.admin.account.form', compact('user'));
    }

    public function update(UserRequest $request, User $user, UpdateUserAction $updateUser): RedirectResponse
    {
        $updateUser->execute($request->toDto(), $user);

        session()->flash('message', __('User edited successifuly'));

        return redirect()->route('admin.account.edit');
    }
}
