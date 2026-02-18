<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function created(){
        return view('posts.formPost', ['title' => 'Publicar Post']);
    }

    public function show(Post $post){
        // Contador de visualizações
        $post->increment('views_count');

        return view('posts.post', [
            'post' => $post,
            'title' => $post->title, // Title cadastrado
        ]);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'max:150',
                // Permite letras com acento (unicode), números, espaços e pontuação básica
                'regex:/^[\pL\pN\s\.\,\!\?\:\;\-\'\"\(\)]+$/u',
            ],
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'imagePost' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'uploadArquivo' => 'nullable|file',
            'linkVideo' => 'nullable|url',
            'content' => 'nullable|string',
        ], [
            'title.required' => 'Este campo título é obrigatório',
            'title.regex' => 'O título contém caracteres inválidos',
            'thumbnail.required' => 'Ops! Precisa informar uma imagem para a capa do seu post',
            'linkVideo.url' => 'O campo do link do vídeo deve ser um URL válido.'
        ]);

        // Upload thumbnail
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $fileNameThumbnail = $request->file('thumbnail')->store('posts/tumb', 'public');
        } else {
            $fileNameThumbnail = 'nothumbnail.jpg';
        }

        // Upload imagePost
        if ($request->hasFile('imagePost') && $request->file('imagePost')->isValid()) {
            $fileNameImage = $request->file('imagePost')->store('posts/post', 'public');
        } else {
            $fileNameImage = 'noimage.jpg';
        }

        // Upload arquivo
        if ($request->hasFile('uploadArquivo') && $request->file('uploadArquivo')->isValid()) {
            $fileNameUploadArquivos = $request->file('uploadArquivo')->store('uploads', 'public');
        } else {
            $fileNameUploadArquivos = null; // ✅ correto (não usar 'NULL')
        }

        $userId = Auth::id();
        $title  = $validated['title'];

        // ✅ Geração de slug automática e única
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $post = new Post();
        $post->user_id = $userId;
        $post->title = $title;
        $post->slug = $slug; // slug de verdade
        $post->content = $request->input('content');
        $post->thumbnail = $fileNameThumbnail;
        $post->linkVideo = $request->input('linkVideo');
        $post->imagePost = $fileNameImage;
        $post->uploadArquivo = $fileNameUploadArquivos;

        $post->save();

        flash('Post cadastrado com sucesso')->success();
        return redirect()->route('formpost');
    }

    public function allPosts(){
        $posts = Post::with(['user','comments'])->paginate(8);

        return view('posts.posts', ['title' => 'Posts', 'posts' => $posts]);
    }

    public function listPosts(){
        $post = Post::orderBy('title')->get();

        return view('posts.listPosts', ['title', 'Listando Posts', 'posts' => $post]);
    }

    public function destroyPost($id)
    {

        try {
            $post = Post::findOrFail($id);

            // Exclui a thumbnail, se existir
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            // Exclui a thumbnail, se existir
            if ($post->imagePost) {
                Storage::disk('public')->delete($post->imagePost);
            }
            // Exclui arquivos de download, se existir
            if ($post->uploadArquivo) {
                Storage::disk('public')->delete($post->uploadArquivo);
            }

            $post->delete();
            flash('Post excluído com sucesso!')->success();
            return redirect()->route('listposts.index');
        } catch (QueryException $e) {
            flash()->error('Post não pode ser apagado, pois seu registro está em uso.');
            return redirect()->back();
        }

    }

    public function edit($id){
        $post = Post::findOrFail($id);

        return view('posts.editPost', ['title' => 'Editando Post', 'posts' => $post]);
    }


}
