<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $response = Post::findAllWithoutTrashed();

        return view('pages.web.homepage.home', compact('response'));
    }
}
