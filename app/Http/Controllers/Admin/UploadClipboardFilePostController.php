<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostClipboardFileRequest;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;

class UploadClipboardFilePostController extends Controller
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    public function __invoke(PostClipboardFileRequest $request): JsonResponse
    {
        $location = $this->fileUploadService->upload($request->file('file'), 'posts');
        return response()->json(['location' => asset("storage/{$location}")]);
    }
}
