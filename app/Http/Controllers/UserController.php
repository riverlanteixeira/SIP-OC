<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        // Apenas administradores podem aceder a esta página
        if (! Gate::allows('is-admin')) {
            abort(403);
        }
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (! Gate::allows('is-admin')) {
            abort(403);
        }
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (! Gate::allows('is-admin')) {
            abort(403);
        }
        $user->roles()->sync($request->input('roles', []));
        return redirect()->route('users.index')->with('success', 'Papéis do utilizador atualizados.');
    }
}