<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function created(){
        return view('posts.formPost', ['title' => 'Publicar Post']);
    }

    public function show(Post $post){
//        Contador das vizualizações dos posts
        $post->increment('views_count');
        return view('posts.post', ['post' => $post, 'title' => $post->slug]);
    }

    public function store(Request $request){

//        $validated = $request->validate([
//            'title' => 'required|max:150',
//            'thumbnail' => 'required|image',
//            'imagePost' => 'nullable|image',
//            'linkVideo' => 'nullable|url',
////            'content' => 'required',
//        ],[
//            'title.required' => 'Esse campo Titulo é obrigatório',
//            'content.min' => 'Ops! Precisa informar pelo menos 3 caracteres no campo do post',
//            'thumbnail.required' => 'Ops! Precisa informar uma imagem para a capa do seu post',
//            'linkVideo.url' => 'O campo do link do vídeo deve ser um URL válido.'
////            'content.required' => 'Ops! Precisa colocar uma descrição no post'
//
//        ]);

        $validated = $request->validate([
            'title' => [
                'required',
                'max:150',
                // Usando expressão regular para permitir apenas letras, números e espaços
                'regex:/^[A-Za-z0-9\s]+$/',
            ],
            'thumbnail' => 'required|image',
            'imagePost' => 'nullable|image',
            'linkVideo' => 'nullable|url',
        ], [
            'title.required' => 'Este campo título é obrigatório',
            'title.regex' => 'O título só pode conter letras, números e espaços',
            'thumbnail.required' => 'Ops! Precisa informar uma imagem para a capa do seu post',
            'linkVideo.url' => 'O campo do link do vídeo deve ser um URL válido.'
        ]);

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            // Se uma imagem foi enviada e é válida, salve-a no diretório public/posts/tumb
            $fileNameThumbnail = $request->file('thumbnail')->store('posts/tumb', 'public');
        } else {
            // Se nenhuma imagem foi enviada ou se houver algum erro, use uma imagem padrão do sistema
            $fileNameThumbnail = 'nothumbnail.jpg';
        }


        if ($request->hasFile('imagePost') && $request->file('imagePost')->isValid()) {
            // Se uma imagem foi enviada e é válida, salve-a no diretório public/posts/post
            $fileNameImage = $request->file('imagePost')->store('posts/post', 'public');
        } else {
            // Se nenhuma imagem foi enviada ou se houver algum erro, use uma imagem padrão do sistema
            $fileNameImage = 'noimage.jpg';
        }

        if ($request->hasFile('uploadArquivo') && $request->file('uploadArquivo')->isValid()) {
            // Se uma imagem foi enviada e é válida, salve-a no diretório public/uploads
            $fileNameUploadArquivos = $request->file('uploadArquivo')->store('uploads', 'public');
        } else {
                // Se nenhuma imagem foi enviada ou se houver algum erro, NULL
            $fileNameUploadArquivos = 'NULL';
            }


        //$dataAtual = Carbon::now()->toDateString();

        $userId = Auth::id();
        $title = $request->input('title');

        $post = new Post();

        $post->user_id = $userId;
        $post->title = $title;
        $post->slug = $title;
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
