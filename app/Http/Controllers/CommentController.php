<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->product_id = $request->product_id;
        $comment->user_id = auth::id();
        $comment->content = $request->body;
        $comment->save();

        return back()->with('success', 'コメントを投稿しました。');
    }
}
