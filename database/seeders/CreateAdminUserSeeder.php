<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('12341234')
        ]);

        $role = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'jefe']);
        $role2 = Role::create(['name' => 'user']);
        
        $permissions = [
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'post-list',
            'exercise-create',
            'exercise-edit',
            'exercise-all',
            'exercise-delete'
        ];
        $role2->syncPermissions($permissions);
        Category::create(['name' => 'Vue.js']);
        Category::create(['name' => 'Cat 2']);

        $additionalPermissions = [
            
        ];
        
        $permissions = array_merge($permissions, $additionalPermissions);
        $role3->syncPermissions($permissions);
        
        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
