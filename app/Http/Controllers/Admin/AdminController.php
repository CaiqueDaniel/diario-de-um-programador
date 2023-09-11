<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\AdminRequest;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AdminController extends Controller
{
    public function __construct(private readonly AdminService $adminService)
    {
    }

    /**
     * @throws Throwable
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        $this->adminService->store($request);

        session()->flash('message', __('Adminstrator created successifuly'));

        return redirect()->route('admin.user.index');
    }

    public function edit(User $user): View
    {
        return view('pages.admin.user.form', compact('user'));
    }

    /**
     * @throws Throwable
     */
    public function update(AdminRequest $request, User $user): RedirectResponse
    {
        $this->adminService->update($request, $user);

        session()->flash('message', __('Adminstrator edited successifuly'));

        return redirect()->route('admin.user.index');
    }

    /**
     * @throws Throwable
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::user()->getAuthIdentifier() == $user->getId())
            abort(Response::HTTP_FORBIDDEN);

        $this->adminService->destroy($user);

        session()->flash('message', __('Adminstrator edited successifuly'));

        return redirect()->route('admin.user.index');
    }
}
