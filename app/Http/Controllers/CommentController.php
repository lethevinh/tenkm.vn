<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function doComment($type, $post) {
        $className = "App\\Models\\".ucfirst($type);
        if (class_exists($className) && $commentObj = $className::find($post)) {
            $commentObj->comment([
                'title_lb' => '',
                'body_lb' => strip_tags(request()->message),
                'status_sl' => 'public'
            ], Auth::user());
        }
        return redirect()->back()->with('messages', ['Comment change successfully']);
    }
}
