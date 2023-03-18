<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'name' => 'yousefAzzam', 
            'email' => 'saher.azzam7@gmail.com',
            'password' => bcrypt('123456'),
            'roles_name' => ["owner"],
            'Status' => 'مفعل',
            ]);

            $role = Role::create(['name' => 'owner']);  
            $permissions = Permission::pluck('id','id')->all();    
            $role->syncPermissions($permissions);      
            $user->assignRole([$role->id]);
            
      
    }
}
