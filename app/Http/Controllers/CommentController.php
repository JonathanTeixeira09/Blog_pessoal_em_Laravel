<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'content' => 'required'
        ], [
            'email.required' => 'Esse campo de email é obrigatório para que possamos entrar em contato com você, ele não ficará visível para as pessoas',
            'name.required' => 'O campo Nome é obrigatório',
            'content.required' => 'Seu comentário é de grande valia para mim.'
        ]);


        // Se o usuário estiver logado, pegar os dados do usuário
        if (auth()->check()) {
            $user = auth()->user();
            $created = [
                'user_id' => $user->id,
                'post_id' => $post->id,
                'name' => $user->name,
                'email' => $user->email,
                'content' => $request->input('content'),
            ];
//            dd($created);
        } else {
            $created = [
                'post_id' => $post->id,
                'name'=> $request->input('name'),
                'email' => $request->input('email'),
                'content' => $request->input('content')

            ];

        }

        // Salvar o comentário no banco de dados
        Comment::create($created);

        if($created){
            flash('Comentário enviado com sucesso')->success();
            return back();
        }

        return back()->with('error_created_comment','Ocorreu um erro ao cadastrar comentário, tente novamente em alguns segundos.');

    }

    public function destroy(Comment $comment)
    {
        //$comment = Comment::find($id);
        $comment->delete();

        return back();
    }
}
