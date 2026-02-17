<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        if ($request->input('busca')) {
            $posts = Post::search($request->input('busca'));
        } else {
            $posts = Post::limit(10)->with(['user', 'comments'])->orderby('id', 'desc')->get();
        }

        return view('posts.homePosts', ['title' => 'Home - Blog da Dentista Manu', 'posts' => $posts]);
    }

    public function about(){
        return view('layouts.aboutUs',['title' => 'Quem Sou Eu']);
    }

}
