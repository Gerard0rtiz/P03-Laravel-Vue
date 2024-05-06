<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use App\Models\Proyecto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

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

    /** @test */
    public function puede_agregar_una_imputacion()
    {
        //Crear usuario en bbdd
        $user = User::factory()->create([
            "email" => "empleado@testing.com",
            "password" => bcrypt("12341234")
        ]);

        //Autenticar usuario creado
        $this->actingAs($user);

        //Datos del proyecto
        $datosProyecto = [
            'titulo' => 'Prueba Automatizada',
            'descripcion' => 'Realización de pruebas automatizadas con Laravel',
            'idUser' => $user->id
        ];

        //Crear proyecto en bbdd para añadir ahí la imputación
        $proyecto = Proyecto::factory()->create($datosProyecto);

        //Datos de la imputación que se añade
        $datosImputacion = [
            'idUser' => $user->id,
            'idProyecto' => $proyecto->id,
            'fechaImputacion' => '2024-05-02',
            'horasRealizadas' => 8,
            'descripcion' => 'Trabajo en el proyecto TEST',
        ];

        $controller = new \App\Http\Controllers\api\ImputacionController();

        //Almacenar imputación
        $response = $controller->store(new Request($datosImputacion));

        //Verificar si la imputación se imputó correctamente
        $this->assertTrue($response->getData()->success);
    
    }

  /** @test */
  public function authenticated_admin_can_create_role()
  {
      // Crear usuario administrador en la base de datos
      $admin = User::factory()->create([
          "name" => "David",
          "email" => "admin@gmail.com",
          "password" => bcrypt("12345678"),
      ]);

      // Autenticar como usuario administrador
      $this->actingAs($admin);

      // Acceder a la página de creación de roles
      $response = $this->get('/admin/roles/index.vue');

      // Verificar que se puede acceder correctamente a la página de creación
      $response->assertStatus(200);

      // Datos del nuevo rol
      $datosRol = [
          'id' => 1,
          'name' => 'TestRol',
          'guard_name' => 'web'
          // Otros campos del rol, si los hubiera
      ];

      // Enviar una solicitud para crear un nuevo rol
      $response = $this->post('/admin/roles', $datosRol);

      // Verificar que el rol se haya creado correctamente en la base de datos
      $this->assertDatabaseHas('roles', $datosRol);
  }
}
