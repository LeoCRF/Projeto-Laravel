<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipe_id' => 'nullable|exists:recipes,id|required_without:api_recipe_id',
            'api_recipe_id' => 'nullable|string|required_without:recipe_id',
            'content' => 'nullable|string|max:1000|required_without:rating',
            'rating' => 'nullable|integer|min:1|max:5|required_without:content',
        ]);

        $validated['user_id'] = Auth::id();

        if (!isset($validated['content']) || $validated['content'] === null) {
            $validated['content'] = '';
        }

        Comment::create($validated);

        return back()->with('success', 'Comentário adicionado com sucesso!');
    }

    public function edit(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'nullable|string|max:1000|required_without:rating',
            'rating' => 'nullable|integer|min:1|max:5|required_without:content',
        ]);

        $comment->update($validated);

        return back()->with('success', 'Comentário atualizado com sucesso!');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comentário excluído com sucesso!');
    }
}
