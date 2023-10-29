<?php

namespace App\Actions\Fullbanner;

use App\Dtos\Fullbanner\CreateFullbannerDto;
use App\Models\FullBanner;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Throwable;

class CreateFullbannerAction
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    /**
     * @throws Throwable
     */
    public function execute(CreateFullbannerDto $dto): FullBanner
    {
        $total = FullBanner::query()->count();

        $fullbanner = new FullBanner([
            'title' => $dto->title,
            'link' => $dto->link
        ]);

        $this->uploadImage($fullbanner, $dto->image);

        $fullbanner->setPosition($total + 1);
        $fullbanner->saveOrFail();

        return $fullbanner;
    }

    private function uploadImage(FullBanner $fullbanner, UploadedFile $file): void
    {
        $image = $this->fileUploadService->upload($file, 'fullbanners');
        $fullbanner->setImage($image);
    }
}
