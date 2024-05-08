<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use App\Models\Proyecto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Controllers\api\ImputacionController;
use Illuminate\Validation\ValidationException;

class apiTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function usuario_puede_logearse()
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
    public function usuario_no_puede_logearse_con_credenciales_invalidas()
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
public function no_puedes_agregar_un_proyecto_invalido()
{
    $user = User::factory()->create([
        "id" => 6,
        "email" => "empleado@testing.com",
        "password" => bcrypt("12341234")
    ]);

    $this->actingAs($user);

    $datosProyectoInvalido = [
        'titulo' => 'test', 
        'descripcion' => 'Descripción del proyecto',
        'idUser' => 9, // ID de usuario que no existe 
    ];

  
    $controller = new \App\Http\Controllers\api\ProyectoController();

    // guardar el proyecto inválido 
    try {
        $controller->store(new Request($datosProyectoInvalido));
        $this->fail('Se esperaba una excepción de QueryException');
    } catch (\Illuminate\Database\QueryException $e) {
        // Verificar la excepción
        $this->assertStringContainsString('Integrity constraint violation', $e->getMessage());
    }
}


 /** @test */
 public function puede_crear_un_proyecto_correctamente()
    {
        $user = User::factory()->create([
            "email" => "empleado@testing.com",
            "password" => bcrypt("12341234")
        ]);

        $this->actingAs($user);

        $datosProyectoValido = [
            'titulo' => 'Proyecto de Prueba',
            'descripcion' => 'Descripción del proyecto de prueba',
            'idUser' => $user->id,
        ];

        $controller = new \App\Http\Controllers\api\ProyectoController();

        // guardamos los datos del proyecto y comprobamos que sean correctos
        $response = $controller->store(new Request($datosProyectoValido));
        $this->assertTrue($response->getData()->success);
    }

    /** @test */
    public function puede_agregar_una_imputacion()
    {
        
        $user = User::factory()->create([
            "email" => "empleado@testing.com",
            "password" => bcrypt("12341234")
        ]);

        
        $this->actingAs($user);

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
public function no_puedes_agregar_una_imputacion_invalida()
{
    
    $user = User::factory()->create([
        "email" => "empleado@testing.com",
        "password" => bcrypt("12341234")
    ]);

    $this->actingAs($user);

    $proyecto = Proyecto::factory()->create([
        'titulo' => 'Proyecto de Prueba',
        'descripcion' => 'Descripción del proyecto de prueba',
        'idUser' => $user->id,
    ]);

    $datosImputacionInvalida = [
      
        'idUser' => $user->id,
        'idProyecto' => $proyecto->id, 
        'fechaImputacion' => '2024-13-45', //fecha incorrecta  
        'horasRealizadas' => -8, //no puedes poner un numero negativo
        'descripcion' => '', //el campo de descripcion esta vacio
    ];

  
    $controller = new \App\Http\Controllers\api\ImputacionController();

    // Se lanza una excepcion de validacion
    $this->expectException(ValidationException::class);

    // guardamos la imputacion invalida (deberia lanzar una excepcion de validacion)
    $controller->store(new Request($datosImputacionInvalida));
}

 
}
