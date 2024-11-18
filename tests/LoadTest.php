<?php

namespace Tests\Feature;

use Laravel\Lumen\Testing\TestCase;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoadTest extends TestCase
{
    /**
     * Método de configuração inicial do teste.
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Teste de simulação de carga de usuários.
     *
     * @return void
     */
    public function testUserInsertionSimulation()
    {
        $numUsers = 1050; // Número de usuários a serem simulados
        $startTime = microtime(true);

        for ($i = 0; $i < $numUsers; $i++) {
            // Simula a criação de um usuário sem realmente salvar no banco
            $user = new User([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => app('hash')->make('password'),
            ]);

            // Adiciona a simulação de manipulação, se necessário
            $this->assertNotNull($user); // Apenas uma verificação para assegurar que o objeto é válido
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime; // Tempo de execução em segundos

        // Definir a unidade de medida e converter para minutos ou horas se necessário
        if ($executionTime >= 3600) {
            $executionTime = $executionTime / 3600;
            $medida = "horas";
        } elseif ($executionTime >= 60) {
            $executionTime = $executionTime / 60;
            $medida = "minutos";
        } else {
            $medida = "segundos";
        }

        // Formata o tempo de execução com duas casas decimais
        $executionTime = number_format($executionTime, 2);

        // Loga o tempo de execução
        Log::info("Simulação de inserção de $numUsers usuários completada em $executionTime $medida.");

        // Verifica se o tempo de execução está dentro de um limite aceitável
        $this->assertTrue($executionTime < 20, "A inserção simulada demorou mais do que o esperado.");
    }
}
