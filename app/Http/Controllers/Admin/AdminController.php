<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Users\CreateAdminAction;
use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\AdminRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminController extends Controller
{
    public function store(AdminRequest $request, CreateAdminAction $createAdmin): RedirectResponse
    {
        $createAdmin->execute($request->toDto());

        session()->flash('message', __('Adminstrator created successifuly'));

        return redirect()->route('admin.user.index');
    }

    public function edit(User $user): View
    {
        return view('pages.admin.user.form', compact('user'));
    }

    public function update(AdminRequest $request, User $user, UpdateUserAction $updateUser): RedirectResponse
    {
        $updateUser->execute($request->toDto(), $user);

        session()->flash('message', __('Adminstrator edited successifuly'));

        return redirect()->route('admin.user.index');
    }

    /**
     * @throws Throwable
     */
    public function destroy(User $user, DeleteUserAction $deleteUser): RedirectResponse
    {
        if (Auth::user()->getAuthIdentifier() == $user->getId())
            abort(Response::HTTP_FORBIDDEN);

        $deleteUser->execute($user);

        session()->flash('message', __('Adminstrator edited successifuly'));

        return redirect()->route('admin.user.index');
    }
}
