<?php

namespace App\Http\Services;

use App\Models\FullBanner;
use Illuminate\Http\Request;
use Throwable;

class FullBannerService
{
    private const FILE_KEY = 'image';
    private const PUBLIC_IMAGE_PATH = 'fullbanners';

    private FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request): FullBanner
    {
        $total = FullBanner::query()->count();

        $fullbanner = new FullBanner([
            'title' => $request->get('title'),
            'link' => $request->get('link')
        ]);

        $this->defineImage($fullbanner, $request);

        $fullbanner->position = $total + 1;
        $fullbanner->saveOrFail();

        return $fullbanner;
    }

    /**
     * @throws Throwable
     */
    public function update(FullBanner $fullbanner, Request $request): FullBanner
    {
        $fullbanner->fill([
            'title' => $request->get('title'),
            'link' => $request->get('link')
        ]);

        $this->defineImage($fullbanner, $request);

        $fullbanner->saveOrFail();

        return $fullbanner;
    }

    public function destroy(FullBanner $fullbanner): void
    {
        $this->fileUploadService->delete($fullbanner->image);

        $fullbanner->forceDelete();
    }

    private function defineImage(FullBanner $fullbanner, Request $request): void
    {
        $file = $request->file(self::FILE_KEY);

        if (empty($file))
            return;

        $image = $this->fileUploadService->upload($file, self::PUBLIC_IMAGE_PATH);

        if (!empty($fullbanner->image))
            $this->fileUploadService->delete($fullbanner->image);

        $fullbanner->image = $image;
    }
}
