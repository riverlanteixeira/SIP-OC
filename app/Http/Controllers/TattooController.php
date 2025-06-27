<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Tattoo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TattooController extends Controller
{
    use AuthorizesRequests;

    /**
     * Guarda uma nova tatuagem.
     */
    public function store(Request $request)
    {
        // ALTERAÇÃO: 'required' alterado para 'nullable'
        $request->validate([
            'person_id' => 'required|exists:people,id',
            'body_part' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $person = Person::findOrFail($request->person_id);
        
        $this->authorize('update', $person);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("tattoos/{$person->id}", 'public');
        }

        // Não cria o registo se todos os campos opcionais estiverem vazios
        if (!$request->body_part && !$request->description && !$request->hasFile('image')) {
            return back()->with('error', 'Pelo menos um campo (parte do corpo, descrição ou imagem) deve ser preenchido.');
        }

        Tattoo::create([
            'person_id' => $person->id,
            'body_part' => $request->body_part,
            'description' => $request->description,
            'image_path' => $path,
        ]);

        return back()->with('success', 'Tatuagem adicionada com sucesso!');
    }

    /**
     * Apaga uma tatuagem.
     */
    public function destroy(Tattoo $tattoo)
    {
        $this->authorize('update', $tattoo->person);

        if ($tattoo->image_path) {
            Storage::disk('public')->delete($tattoo->image_path);
        }

        $tattoo->delete();

        return back()->with('success', 'Tatuagem removida com sucesso!');
    }
}
