<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Helper function for creating roles
     */
    protected function createRole(string $name, string $display_name, string $description = null)
    {
        $role = new Role();
        $role->name = $name;
        $role->display_name = $display_name;
        $role->description = $description ?? $display_name;
        $role->save();

        return $role;
    }

    /**
     * Helper function for creating users
     */
    protected function createUser(array $data, string $role)
    {
        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->referral_code = $data['referral_code'];
        $user->status = $data['status'] ?? 'active';
        $user->points = $data['points'] ?? 0;
        
        $user->save();
        $user->addRole($role);

        return $user;
    }

    public function run()
    {
        // ================ 1) ایجاد نقش‌های سیستم ================
        $this->createRole('admin', 'مدیر', 'مدیر کلینیک با دسترسی کامل');
        $this->createRole('employee', 'پرسنل', 'پرسنل کلینیک (پزشک، اپراتور، منشی)');
        $this->createRole('doctor', 'پزشک', 'پزشک متخصص');
        $this->createRole('patient', 'بیمار/مشتری', 'مشتری کلینیک');
        $this->createRole('supplier', 'تامین‌کننده', 'تامین‌کننده تجهیزات و مواد مصرفی');

        // ================ 2) ایجاد کاربران نمونه ================

        // ادمین
        $this->createUser([
            'first_name' => 'مدیر',
            'last_name' => 'سیستم',
            'phone' => '09120000000',
            'email' => 'admin@clinic.com',
            'password' => 'admin123',
            'referral_code' => 'ADMIN123',
            'status' => 'active',
            'points' => 0,
        ], 'admin');

        // پرسنل
        $this->createUser([
            'first_name' => 'پرسنل',
            'last_name' => 'نمونه',
            'phone' => '09120000001',
            'email' => 'employee@clinic.com',
            'password' => 'employee123',
            'referral_code' => 'EMP001',
            'status' => 'active',
            'points' => 0,
        ], 'employee');

        // مشتری
        $this->createUser([
            'first_name' => 'مشتری',
            'last_name' => 'نمونه',
            'phone' => '09120000002',
            'email' => 'patient@clinic.com',
            'password' => 'patient123',
            'referral_code' => 'PAT001',
            'status' => 'active',
            'points' => 0,
        ], 'patient');

        // تامین‌کننده
        $this->createUser([
            'first_name' => 'تامین',
            'last_name' => 'کننده',
            'phone' => '09120000003',
            'email' => 'supplier@clinic.com',
            'password' => 'supplier123',
            'referral_code' => 'SUP001',
            'status' => 'active',
            'points' => 0,
        ], 'supplier');

        // پزشک
        $this->createUser([
            'first_name' => 'پزشک',
            'last_name' => 'نمونه',
            'phone' => '09120000004',
            'email' => 'doctor@clinic.com',
            'password' => 'doctor123',
            'referral_code' => 'DOC001',
            'status' => 'active',
            'points' => 0,
        ], 'doctor');

        // ================ پیام موفقیت ================
        $this->command->info('✅ نقش‌ها و کاربران نمونه با موفقیت ایجاد شدند.');
        $this->command->info('📌 کاربران ایجاد شده:');
        $this->command->info('   🔹 مدیر: admin@clinic.com / admin123');
        $this->command->info('   🔹 پرسنل: employee@clinic.com / employee123');
        $this->command->info('   🔹 مشتری: patient@clinic.com / patient123');
        $this->command->info('   🔹 تامین‌کننده: supplier@clinic.com / supplier123');
        $this->command->info('   🔹 پزشک: doctor@clinic.com / doctor123');
    }
}