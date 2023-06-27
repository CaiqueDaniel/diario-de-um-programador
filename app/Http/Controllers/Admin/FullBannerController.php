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

        $banner = new FullBanner([
            'title' => $request->get('title'),
            'link' => $request->get('link'),
            'image' => $request->file('image')
        ]);

        $banner->position = $total + 1;
        $banner->save();

        session()->flash('message', 'Fullbanner criado com sucesso');

        return redirect()->route('admin.fullbanner.index');
    }

    public function edit(FullBanner $fullbanner): View
    {
        return view('pages.admin.fullbanner.form', compact('fullbanner'));
    }

    public function update(FullBanner $fullbanner, FullBannerRequest $request): RedirectResponse
    {
        $fullbanner->fill([
            'title' => $request->get('title'),
            'link' => $request->get('link'),
            'image' => $request->file('image')
        ]);

        $fullbanner->save();

        session()->flash('message', 'Fullbanner alterado com sucesso');

        return redirect()->route('admin.fullbanner.index');
    }

    public function destroy(FullBanner $fullbanner): RedirectResponse
    {
        $fullbanner->forceDelete();

        session()->flash('message', 'Fullbanner excluído com sucesso');

        return redirect()->route('admin.fullbanner.index');
    }
}
