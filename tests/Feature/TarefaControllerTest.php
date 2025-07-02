<?php

namespace Tests\Feature;

use App\Models\Tarefa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarefaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function autenticarUsuario()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    public function test_index_retorna_view_com_tarefas()
    {
        $this->autenticarUsuario();

        // Criar algumas tarefas para aparecer na listagem
        Tarefa::factory()->count(3)->create();

        $response = $this->get(route('tarefas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tarefas.index');
        $response->assertViewHas('tarefas');
    }

    public function test_create_retorna_view()
    {
        $this->autenticarUsuario();

        $response = $this->get(route('tarefas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tarefas.create');
    }

    public function test_store_cria_tarefa_e_redireciona()
    {
        $this->autenticarUsuario();

        $data = [
            'descricao' => 'Nova tarefa teste',
            'data_criacao' => now()->toDateString(),
            'data_prevista' => now()->addDays(3)->toDateString(),
            'data_encerramento' => null,
            'situacao' => 'aberta',
        ];

        $response = $this->post(route('tarefas.store'), $data);

        $response->assertRedirect(route('tarefas.index'));
        $this->assertDatabaseHas('tarefas', [
            'descricao' => 'Nova tarefa teste',
            'situacao' => 'aberta',
        ]);
    }

    public function test_show_retorna_json_da_tarefa()
    {
        $this->autenticarUsuario();

        $tarefa = Tarefa::factory()->create();

        $response = $this->get(route('tarefas.show', $tarefa->id));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $tarefa->id,
            'descricao' => $tarefa->descricao,
            // Pode adicionar outros campos se quiser
        ]);
    }

    public function test_edit_retorna_view_com_tarefa()
    {
        $this->autenticarUsuario();

        $tarefa = Tarefa::factory()->create();

        $response = $this->get(route('tarefas.edit', $tarefa->id));

        $response->assertStatus(200);
        $response->assertViewIs('tarefas.edit');
        $response->assertViewHas('tarefa');
    }

    public function test_update_altera_tarefa_e_redireciona()
    {
        $this->autenticarUsuario();

        $tarefa = Tarefa::factory()->create([
            'descricao' => 'Descrição antiga',
            'situacao' => 'aberta',
        ]);

        $dataUpdate = [
            'descricao' => 'Descrição atualizada',
            'data_criacao' => now()->toDateString(),
            'data_prevista' => now()->addDays(5)->toDateString(),
            'data_encerramento' => null,
            'situacao' => 'concluida',
        ];

        $response = $this->put(route('tarefas.update', $tarefa->id), $dataUpdate);

        $response->assertRedirect(route('tarefas.index'));

        $this->assertDatabaseHas('tarefas', [
            'id' => $tarefa->id,
            'descricao' => 'Descrição atualizada',
            'situacao' => 'concluida',
        ]);
    }

    public function test_destroy_exclui_tarefa_e_redireciona()
    {
        $this->autenticarUsuario();

        $tarefa = Tarefa::factory()->create();

        $response = $this->delete(route('tarefas.destroy', $tarefa->id));

        $response->assertRedirect(route('tarefas.index'));
        $this->assertDatabaseMissing('tarefas', ['id' => $tarefa->id]);
    }

    public function test_exportar_pdf_retorna_download()
    {
        $this->autenticarUsuario();

        Tarefa::factory()->count(2)->create();

        $response = $this->get(route('tarefas.exportarPdf'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=lista_tarefas.pdf');
    }
}
