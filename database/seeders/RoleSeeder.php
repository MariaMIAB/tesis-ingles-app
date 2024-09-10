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
        $role4 = Role::create(['name'=>'Contenido-cancelados']);
        $role5 = Role::create(['name'=>'Exanenes-cancelados']);
        $role6 = Role::create(['name'=>'Actividades-canelados']);
        $role7 = Role::create(['name'=>'Inabilitado']);

        //permisos para acceder al panel de administracion
        Permission::create(['name'=>'ver-menu-panel'])->syncRoles([$role1]);
        //permisos para modificar usuario
        Permission::create(['name'=>'admin.users.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.users.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.users.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.users.destroy'])->assignRole($role1);
        //permisos para modificar roles
        Permission::create(['name'=>'admin.roles.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.roles.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.roles.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.roles.destroy'])->assignRole($role1);
        //permisos para modificar temas
        Permission::create(['name'=>'admin.temas.index'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.temas.create'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.temas.edit'])->syncRoles([$role1]);
        Permission::create(['name'=>'admin.temas.destroy'])->assignRole($role1);
    }
}
