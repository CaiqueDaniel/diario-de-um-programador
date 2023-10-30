<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadClipboardFilePostController extends Controller
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $location = $this->fileUploadService->upload($request->file('file'), 'posts');
        return response()->json(['location' => asset("storage/{$location}")]);
    }
}
