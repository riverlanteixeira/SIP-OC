<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::latest()->paginate(10);
        return view('people.index', ['people' => $people]);
    }

    /**
     * Exibe o formulário de criação, enviando os dados necessários.
     */
    public function create()
    {
        $organizations = Organization::orderBy('name')->get();

        // CORREÇÃO: Adicionada a lógica de papéis que estava em falta
        $pgcRoles = ['Conselho Geral', 'Disciplina Geral', 'Financeiro Geral', 'Disciplina Regional', 'Disciplina Prisional', 'Responsável Local (Sintonia)', 'Base (Integrante Operacional)', 'Simpatizante/Colaborador'];
        $pccRoles = ['Sintonia Final (SC)', 'Sintonia do Progresso', 'Sintonia do Fundo', 'Sintonia do Grupo', 'Disciplina', 'Gerente de Quadrilha', 'Soldado', 'Simpatizante/Facção Aliada'];
        
        $allRoles = array_unique(array_merge($pgcRoles, $pccRoles));
        sort($allRoles);

        // Passa também a variável $allRoles para a view
        return view('people.create', compact('organizations', 'allRoles'));
    }

    /**
     * Valida os dados da pessoa.
     */
    private function validatePerson(Request $request, $personId = null)
    {
        $cpfRule = 'nullable|string|max:14';
        if ($personId) {
            $cpfRule .= '|unique:people,cpf,' . $personId;
        } else {
            $cpfRule .= '|unique:people,cpf';
        }

        return $request->validate([
            'full_name' => 'required|string|max:255',
            'cpf' => $cpfRule,
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'organizations' => 'nullable|array',
            'rg' => 'nullable|string|max:20',
            'nickname' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'birth_place' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:50',
            'skin_color' => 'nullable|string|max:50',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePerson($request);
        $person = Person::create($validatedData);

        $syncData = [];
        if ($request->has('organizations')) {
            foreach ($request->organizations as $orgId) {
                $syncData[$orgId] = ['role' => $request->input("role_for_{$orgId}")];
            }
        }
        $person->organizations()->sync($syncData);

        return redirect()->route('people.index')->with('success', 'Pessoa cadastrada com sucesso!');
    }

    public function show(Person $person)
    {
        $person->load('organizations', 'investigations', 'documents', 'tattoos');
        return view('people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        $organizations = Organization::orderBy('name')->get();
        $person->load('organizations', 'tattoos', 'contacts', 'incarcerations');

        // Define as listas de funções hierárquicas
        $pgcRoles = ['Conselho Geral', 'Disciplina Geral', 'Financeiro Geral', 'Disciplina Regional', 'Disciplina Prisional', 'Responsável Local (Sintonia)', 'Base (Integrante Operacional)', 'Simpatizante/Colaborador'];
        $pccRoles = ['Sintonia Final (SC)', 'Sintonia do Progresso', 'Sintonia do Fundo', 'Sintonia do Grupo', 'Disciplina', 'Gerente de Quadrilha', 'Soldado', 'Simpatizante/Facção Aliada'];
        $allRoles = array_unique(array_merge($pgcRoles, $pccRoles));
        sort($allRoles);

        // Define a lista de unidades prisionais
        $prisons = [
            'Colônia Agroindustrial de Palhoça', 'Complexo Penitenciário do Estado', 'Hospital de Custódia e Tratamento Psiquiátrico – HCTP',
            'Penitenciária de Florianópolis', 'Presídio Feminino Regional de Florianópolis', 'Presídio Masculino Regional de Florianópolis',
            'Presídio Regional de Biguaçu', 'Presídio Regional de Tijucas', 'Unidade de Monitoramento Eletrônico', 'Penitenciária Feminina de Criciúma',
            'Penitenciária Masculina de Tubarão', 'Penitenciária Sul', 'Presídio Regional de Araranguá', 'Presídio Regional de Criciúma',
            'Presídio Regional de Imbituba', 'Presídio Regional de Laguna', 'Presídio Regional de Tubarão', 'Penitenciária Industrial de Joinville',
            'Presídio Feminino Regional de Joinville', 'Presídio Regional de Barra Velha', 'Presídio Regional de Joinville', 'Presídio Regional de São Francisco do Sul',
            'Penitenciária Masculina do Vale do Itajaí', 'Presídio Feminino Regional de Itajaí', 'Presídio Regional de Brusque',
            'Presídio Regional de Itajaí', 'Presídio Regional de Itapema', 'Penitenciária Industrial de São Cristóvão do Sul',
            'Penitenciária Regional de Curitibanos', 'Presídio Masculino de Lages', 'Presídio Regional de Caçador',
            'Presídio Regional de Campos Novos', 'Presídio Regional de Lages', 'Presídio Regional de Videira',
            'Unidade de Segurança Máxima de São Cristóvão do Sul', 'Penitenciária Agrícola de Chapecó', 'Penitenciária Industrial de Chapecó',
            'Presídio Feminino Regional de Chapecó', 'Presídio Regional de Chapecó', 'Presídio Regional de Concórdia',
            'Presídio Regional de Joaçaba', 'Presídio Regional de Maravilha', 'Presídio Regional de São José do Cedro',
            'Presídio Regional de São Miguel do Oeste', 'Presídio Regional de Xanxerê', 'Penitenciária Industrial de Blumenau',
            'Presídio Regional de Blumenau', 'Presídio Regional de Indaial', 'Presídio Regional de Ituporanga',
            'Presídio Regional de Rio do Sul', 'Presídio Regional de Canoinhas', 'Presídio Regional de Jaraguá do Sul',
            'Presídio Regional de Mafra', 'Presídio Regional de Porto União'
        ];
        sort($prisons);


        return view('people.edit', compact('person', 'organizations', 'allRoles', 'prisons'));
    }

    public function update(Request $request, Person $person)
    {
        $validatedData = $this->validatePerson($request, $person->id);
        $person->update($validatedData);

        $syncData = [];
        if ($request->has('organizations')) {
            foreach ($request->organizations as $orgId) {
                $syncData[$orgId] = ['role' => $request->input("role_for_{$orgId}")];
            }
        }
        $person->organizations()->sync($syncData);

        return redirect()->route('people.show', $person)->with('success', 'Dados da pessoa atualizados com sucesso!');
    }

    public function destroy(Person $person)
    {
        $person->delete();
        return redirect()->route('people.index')->with('success', 'Pessoa excluída com sucesso!');
    }
}
