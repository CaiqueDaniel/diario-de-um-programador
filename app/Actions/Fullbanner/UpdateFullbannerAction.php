<?php

namespace App\Actions\Fullbanner;

use App\Dtos\Fullbanner\UpdateFullbannerDto;
use App\Models\FullBanner;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Throwable;

class UpdateFullbannerAction
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    /**
     * @throws Throwable
     */
    public function execute(FullBanner $fullbanner, UpdateFullbannerDto $dto): FullBanner
    {
        $fullbanner->fill([
            'title' => $dto->title,
            'link' => $dto->link
        ]);

        if (!empty($dto->image))
            $this->uploadImage($fullbanner, $dto->image);

        $fullbanner->saveOrFail();

        return $fullbanner;
    }

    private function uploadImage(FullBanner $fullbanner, UploadedFile $file): void
    {
        $image = $this->fileUploadService->upload($file, 'fullbanners');

        if (!empty($fullbanner->image))
            $this->fileUploadService->delete($fullbanner->image);

        $fullbanner->setImage($image);
    }
}
