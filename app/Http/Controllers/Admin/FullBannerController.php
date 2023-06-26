<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\FullBannerRequest;
use App\Models\FullBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FullBannerController extends Controller
{
    public function index(): View
    {
        $response = FullBanner::withTrashed()->paginate();

        return view('pages.admin.fullbanner.listing', compact('response'));
    }

    public function store(FullBannerRequest $request): RedirectResponse
    {
        $total = FullBanner::query()->count();

        $banner = new FullBanner($request->validated());
        $banner->position = $total + 1;

        $banner->save();

        session()->flash('message', 'Fullbanner criado com sucesso');

        return redirect()->route('admin.fullbanner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
