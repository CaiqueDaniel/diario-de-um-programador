<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Get\SearchRequest;
use App\Http\Requests\Post\FullBannerRequest;
use App\Http\Services\FullBannerService;
use App\Models\FullBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Throwable;

class FullBannerController extends Controller
{
    private FullBannerService $fullBannerService;

    public function __construct(FullBannerService $fullBannerService)
    {
        $this->fullBannerService = $fullBannerService;
    }

    public function index(SearchRequest $request): View
    {
        $response = FullBanner::findAll($request->get('search'));

        return view('pages.admin.fullbanner.listing', compact('response'));
    }

    /**
     * @throws Throwable
     */
    public function store(FullBannerRequest $request): RedirectResponse
    {
        $this->fullBannerService->store($request);

        session()->flash('message', 'Fullbanner criado com sucesso');

        return redirect()->route('admin.fullbanner.index');
    }

    public function edit(FullBanner $fullbanner): View
    {
        return view('pages.admin.fullbanner.form', compact('fullbanner'));
    }

    /**
     * @throws Throwable
     */
    public function update(FullBanner $fullbanner, FullBannerRequest $request): RedirectResponse
    {
        $this->fullBannerService->update($fullbanner, $request);

        session()->flash('message', 'Fullbanner alterado com sucesso');

        return redirect()->route('admin.fullbanner.index');
    }

    public function destroy(FullBanner $fullbanner): RedirectResponse
    {
        $this->fullBannerService->destroy($fullbanner);

        session()->flash('message', 'Fullbanner excluído com sucesso');

        return redirect()->route('admin.fullbanner.index');
    }

    public function trash(FullBanner $fullbanner): Response
    {
        $fullbanner->delete();

        return response(null);
    }

    public function restore(FullBanner $fullbanner): Response
    {
        $fullbanner->restore();

        return response(null);
    }
}
