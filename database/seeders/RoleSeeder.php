<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name'=>'Administrador']);
        $role2 = Role::create(['name'=>'Profesor']);
        $role3 = Role::create(['name'=>'Estudiante']);  
        

        //permisos para acceder al panel de administracion
        Permission::create(['name'=>'ver-menu-panel'])->syncRoles([$role1, $role2]);
        //permisos para modificar usuario
        Permission::create(['name'=>'admin.users.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'admin.users.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'admin.users.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'admin.users.destroy'])->assignRole($role1);
        //permisos para modificar roles
        Permission::create(['name'=>'admin.roles.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'admin.roles.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'admin.roles.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'admin.roles.destroy'])->assignRole($role1);
    }
}
