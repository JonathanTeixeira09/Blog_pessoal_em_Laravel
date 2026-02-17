<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Esse campo de email é obrigatório',
            'email.email' => 'Esse campo tem que ter um email válido',
            'password.required' => 'Esse campo de password é obrigatório'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

             // Armazena o caminho da thumbnail do usuário na sessão
            session([
                'user_thumbnail' => Auth::user()->thumbnail,
                'user_admin' => Auth::user()->is_admin
            ]);

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'error' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('error');


    }

    public function destroy(Request $request)
    {
        Auth::logout();

        //invalidamos e destruímos a sessão
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function create(Request $request){

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'thumbnail' => 'required|image', // Adicione a regra de validação para a imagem
            'name' => 'required',
        ], [
            'email.required' => 'Esse campo de email é obrigatório',
            'email.email' => 'Esse campo tem que ter um email válido',
            'password.required' => 'Esse campo de password é obrigatório',
            'thumbnail.required' => 'O campo Thumbnail é obrigatório',
            'thumbnail.image' => 'O campo Thumbnail deve ser uma imagem válida',
            'name.required' => 'Este campo nome é obrigatório'
        ]);


        if ($request->hasFile('thumbnail')) {
            // Se uma imagem foi enviada e é válida, salve-a no diretório public/users
            $fileNameThumbnail = $request->file('thumbnail')->store('users', 'public');
        } else {
            // Se nenhuma imagem foi enviada ou se houver algum erro, use uma imagem padrão do sistema
            $fileNameThumbnail = 'avatarUser.png';
        }

        $is_admin = '0';

        $create = [
            'name'=> $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'thumbnail' => $fileNameThumbnail,
            'is_admin' => $is_admin,
        ];

        User::create($create);
        flash('Usuário cadastrado com sucesso')->success();
        return redirect()->route('createuser.index');


    }

    public function show(){
        return view('auth.formCreateUser', ['title' => 'Criando Usuário']);
    }

    public function edit($id){
        $user = User::findOrFail($id);

        return view('auth.editUser', ['title' => 'Editando Usuário', 'users' => $user]);
    }

    public function listUsers(){
        $user = User::orderBy('name')->get();

        return view('auth.listUsers', ['title', 'Listando usuários', 'users' => $user]);
    }

    public function update(Request $request){

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'thumbnail' => 'required|image', // Adicione a regra de validação para a imagem
            'name' => 'required',
        ], [
            'email.required' => 'Esse campo de email é obrigatório',
            'email.email' => 'Esse campo tem que ter um email válido',
            'password.required' => 'Esse campo de password é obrigatório',
            'thumbnail.required' => 'O campo Thumbnail é obrigatório',
            'thumbnail.image' => 'O campo Thumbnail deve ser uma imagem válida',
            'name.required' => 'Este campo nome é obrigatório'
        ]);


        if ($request->hasFile('thumbnail')) {
            // Se uma imagem foi enviada e é válida, salve-a no diretório public/users
            $fileNameThumbnail = $request->file('thumbnail')->store('users', 'public');
        } else {
            // Se nenhuma imagem foi enviada ou se houver algum erro, use uma imagem padrão do sistema
            $fileNameThumbnail = 'avatarUser.png';
        }

        $is_admin = '0';

        $create = [
            'name'=> $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'thumbnail' => $fileNameThumbnail,
            'is_admin' => $is_admin,
        ];

        User::findOrFail($request->id)->update($create);

        flash('Usuário alterado com sucesso')->success();
        return redirect()->route('listusers.index');

    }

    public function destroyUser($id)
    {

        try {
            // Verificar se o usuário logado é administrador
            if (auth()->user()->is_admin) {
                $user = User::findOrFail($id);

                // Verificar se o usuário a ser excluído não é o próprio usuário logado
                if ($user->id !== auth()->user()->id) {
                    // Exclui a thumbnail, se existir
                    if ($user->thumbnail) {
                        Storage::disk('public')->delete($user->thumbnail);
                    }

                    $user->delete();
                    flash('Usuário excluído com sucesso!')->success();
                    return redirect()->route('listusers.index');
                } else {
                    flash()->error('Você não pode excluir a si mesmo.');
                    return redirect()->back();
                }
            } else {
                flash()->error('Você não tem permissão para excluir usuários.');
                return redirect()->back();
            }
        } catch (QueryException $e) {
            flash()->error('Usuário não pode ser apagado, pois seu registro está em uso.');
            return redirect()->back();
        }

//        try {
//            $user = User::findOrFail($id);
//
//            // Exclui a thumbnail, se existir
//            if ($user->thumbnail) {
//                Storage::disk('public')->delete($user->thumbnail);
//            }
//
//            $user->delete();
//            flash('Usuário excluído com sucesso!')->success();
//            return redirect()->route('listusers.index');
//        } catch (QueryException $e) {
//            flash()->error('Usuário não pode ser apagado, pois seu registro está em uso.');
//            return redirect()->back();
//        }

    }

}
