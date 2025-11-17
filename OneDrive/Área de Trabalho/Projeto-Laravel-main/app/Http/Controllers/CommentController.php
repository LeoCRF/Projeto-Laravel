<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // garantir que o usuário está autenticado (rota também deveria estar protegida por middleware 'auth')
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // exigir que pelo menos um dos identificadores de receita seja fornecido
        // permitir comentário vazio se houver avaliação (rating) — pelo menos um dos dois é obrigatório
        $validated = $request->validate([
            'recipe_id' => 'nullable|exists:recipes,id|required_without:api_recipe_id',
            'api_recipe_id' => 'nullable|string|required_without:recipe_id',
            'content' => 'nullable|string|max:1000|required_without:rating',
            'rating' => 'nullable|integer|min:1|max:5|required_without:content',
        ]);

        $validated['user_id'] = Auth::id();

        // garantir que content não seja null (coluna não aceita NULL no schema)
        if (! array_key_exists('content', $validated) || $validated['content'] === null) {
            $validated['content'] = '';
        }

        Comment::create($validated);

        return back()->with('success', 'Comentário adicionado com sucesso!');
    }

    // mostrar formulário de edição (poderíamos usar inline editing; rota fica disponível caso queira página separada)
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
