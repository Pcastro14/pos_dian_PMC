<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Crear permisos
        $permisos = [
            'ver dashboard',
            'gestionar productos',
            'gestionar clientes',
            'gestionar ventas',
            'gestionar facturas',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $vendedor = Role::firstOrCreate(['name' => 'vendedor']);

        // Asignar permisos a roles
        $admin->syncPermissions(Permission::all());
        $vendedor->syncPermissions([
            'ver dashboard',
            'gestionar ventas',
        ]);
    
    }
}
