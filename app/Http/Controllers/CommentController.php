<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
        'email' => 'required|email',
        'name' => [
            'required',
            'regex:/^[A-Za-zÀ-ú\s]+$/u',
            'max:255'
        ],
        'content' => 'required|string|max:5000'
    ], [
        'email.required' => 'O campo de email é obrigatório.',
        'name.required' => 'O campo Nome é obrigatório.',
        'name.regex' => 'O nome contém caracteres inválidos.',
        'content.required' => 'O campo de comentário é obrigatório.',
    ]);

    $content = trim($request->input('content'));

    // 1. Bloquear conteúdo malicioso
    $maliciousPatterns = [
        '/(&&|\|\||;|\$\(.*\)|`.*`)/', // comandos shell
        '/(&amp;|&lt;|&gt;|&quot;|&#039;)/i', // entidades HTML usadas para burlar
        '/(curl|wget|nslookup|response\.write|echo\s|powershell|cmd\.exe)/i', // comandos perigosos
        '/(<script|<\/script>|onerror|onload|alert\(|eval\()/i', // XSS
    ];

    foreach ($maliciousPatterns as $pattern) {
        if (preg_match($pattern, $content)) {
            // return back()->with('error_created_comment', 'Comentário bloqueado por conter conteúdo suspeito.');
            flash()->error('Comentário bloqueado por conter conteúdo suspeito.');
            return redirect()->back();
        }
    }

    // 2. Limitar a frequência (máximo 5 comentários por IP em 10 minutos)
    $ip = $request->ip();
    $key = 'comment-limit:' . $ip;

    if (RateLimiter::tooManyAttempts($key, 5)) {
        flash()->error('Você enviou muitos comentários em pouco tempo. Tente novamente mais tarde.');
            return redirect()->back();
    }

    RateLimiter::hit($key, now()->addMinutes(10)); // cada tentativa conta por 10 minutos

    // 3. Sanitização final
    $content = strip_tags($content);
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

    $name = strip_tags(trim($request->input('name')));

    $created = [
        'post_id' => $post->id,
        'name' => $name,
        'email' => $request->input('email'),
        'content' => $content,
        'ip_address' => $ip,
    ];

    if (auth()->check()) {
        $created['user_id'] = auth()->id();
        $created['name'] = auth()->user()->name;
        $created['email'] = auth()->user()->email;
    }

    Comment::create($created);

    if($created){
        flash('Comentário enviado com sucesso')->success();
        return back();
    }

    flash()->error('Ocorreu um erro ao cadastrar comentário, tente novamente em alguns segundos.');
        return redirect()->back();

    }

    public function destroy(Comment $comment)
    {
        //$comment = Comment::find($id);
        $comment->delete();

        return back();
    }
}
