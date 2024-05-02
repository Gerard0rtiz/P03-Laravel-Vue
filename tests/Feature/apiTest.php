<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;

class apiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function authenticated_user_can_login()
    {
        //Crear usuario en bbdd
        $user = User::factory()->create([
            "email" => "empleado@testing.com",
            "password" => bcrypt("12341234")
        ]);

        //Simular inicio de sesión con credenciales válidas
        $response = $this->post('/login', [
            'email' => 'empleado@testing.com',
            'password' => '12341234',
        ]);

        //Verificar que el usuario está autenticado
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        //Simular inicio de sesión con credenciales inválidas
        $response = $this->post('/login', [
            'email' => 'notloggeduser@testing.com',
            'password' => '12341234',
        ]);

        //Verificar que el usuario no está autenticado
        $this->assertGuest();
    }
}
