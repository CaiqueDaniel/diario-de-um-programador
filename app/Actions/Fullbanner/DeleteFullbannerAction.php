<?php

namespace App\Actions\Fullbanner;

use App\Models\FullBanner;
use App\Services\FileUploadService;

class DeleteFullbannerAction
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    public function execute(FullBanner $fullbanner): void
    {
        $this->fileUploadService->delete($fullbanner->getImage());

        $fullbanner->forceDelete();
    }
}
