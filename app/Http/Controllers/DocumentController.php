<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Guarda um novo documento.
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,mp3,mp4|max:20480', // Max 20MB
            'documentable_id' => 'required|integer',
            'documentable_type' => 'required|string',
        ]);

        $modelType = $request->input('documentable_type');
        $modelId = $request->input('documentable_id');

        // Constrói o nome completo da classe do modelo (ex: 'Investigation' -> 'App\Models\Investigation')
        $modelClass = "App\\Models\\" . $modelType;

        // Medida de segurança: verifica se a classe e o registo existem
        if (!class_exists($modelClass) || !$modelClass::find($modelId)) {
            return back()->with('error', 'Entidade associada inválida.');
        }

        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        
        // Guarda o ficheiro numa pasta organizada (ex: 'documents/Investigation/12/ficheiro.pdf')
        // O Laravel gera um nome único para o ficheiro para evitar conflitos
        $path = $file->store("documents/{$modelType}/{$modelId}", 'public');

        // Cria o registo na base de dados
        Document::create([
            'original_name' => $originalName,
            'path' => $path,
            'documentable_id' => $modelId,
            'documentable_type' => $modelClass,
        ]);

        return back()->with('success', 'Documento enviado com sucesso!');
    }

    /**
     * Apaga um documento.
     */
    public function destroy(Document $document)
    {
        // Apaga o ficheiro físico do disco
        Storage::disk('public')->delete($document->path);

        // Apaga o registo do documento da base de dados
        $document->delete();

        return back()->with('success', 'Documento excluído com sucesso!');
    }
}
