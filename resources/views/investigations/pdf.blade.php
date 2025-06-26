<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório da Investigação</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .section { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        ul { padding-left: 20px; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Relatório Confidencial de Investigação</h1>
        <p>SIP-OC - Sistema de Investigação Policial</p>
    </div>

    <div class="section">
        <div class="section-title">Detalhes do Caso</div>
        <p><strong>Nome do Caso:</strong> {{ $investigation->case_name }}</p>
        <p><strong>Status:</strong> {{ $investigation->status }}</p>
        <p><strong>Data de Criação:</strong> {{ $investigation->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Descrição:</strong></p>
        <p>{{ $investigation->description ?? 'Nenhuma descrição fornecida.' }}</p>
    </div>

    <div class="section">
        <div class="section-title">Pessoas Envolvidas</div>
        <ul>
            @forelse($investigation->people as $person)
                <li>{{ $person->full_name }} (CPF: {{ $person->cpf ?? 'N/A' }})</li>
            @empty
                <li>Nenhuma pessoa vinculada.</li>
            @endforelse
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Organizações Envolvidas</div>
        <ul>
            @forelse($investigation->organizations as $organization)
                <li>{{ $organization->name }}</li>
            @empty
                <li>Nenhuma organização vinculada.</li>
            @endforelse
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Investigadores Responsáveis</div>
        <ul>
            @forelse($investigation->assignedUsers as $user)
                <li>{{ $user->name }}</li>
            @empty
                <li>Nenhum investigador atribuído.</li>
            @endforelse
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Documentos Anexados</div>
        <ul>
            @forelse($investigation->documents as $document)
                <li>{{ $document->original_name }} (Adicionado em: {{ $document->created_at->format('d/m/Y') }})</li>
            @empty
                <li>Nenhum documento anexado.</li>
            @endforelse
        </ul>
    </div>

</body>
</html>
