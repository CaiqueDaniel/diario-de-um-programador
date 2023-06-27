<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class FileUploadService
{
    private const DISK = 'public';

    public function upload(UploadedFile $file, string $publicPath): string
    {
        $newThumbnail = $file->storePublicly($publicPath, self::DISK);

        if (empty($newThumbnail))
            throw new CannotWriteFileException();

        return $newThumbnail;
    }

    public function delete(string $path): void
    {
        Storage::disk(self::DISK)->delete($path);
    }
}
