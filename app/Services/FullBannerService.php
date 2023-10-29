<?php

namespace App\Services;

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

    public function destroy(FullBanner $fullbanner): void
    {
        $this->fileUploadService->delete($fullbanner->getImage());

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

        $fullbanner->setImage($image);
    }
}
