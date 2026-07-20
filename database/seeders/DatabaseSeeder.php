<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    protected function createRole(string $name, string $display_name)
    {
        $role = new Role();
        $role->name = $name;
        $role->display_name = $display_name;
        $role->save();

        return $role;
    }

    public function run()
    {
        // 1) نقش‌ها
        $this->createRole('doctor', 'doctor');
        $this->createRole('patient', 'patient');
        $this->createRole('supplier', 'supplier');
        $this->createRole('admin', 'admin');
        $this->createRole('employee', 'employee');
    }
}
