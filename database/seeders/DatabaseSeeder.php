<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    /**
     * Helper function for creating services
     */
    protected function createService(array $data)
    {
        $service = new Service();
        $service->name = $data['name'];
        $service->slug = $data['slug'] ?? Str::slug($data['name']);
        $service->short_description = $data['short_description'] ?? null;
        $service->seo_content = $data['seo_content'] ?? null;
        $service->article_content = $data['article_content'] ?? null;
        $service->price = $data['price'];
        $service->duration_minutes = $data['duration_minutes'] ?? 30;
        $service->is_active = $data['is_active'] ?? true;
        $service->review_count = $data['review_count'] ?? 0;
        
        $service->save();

        return $service;
    }

    /**
     * Helper function for attaching services to doctors
     */
    protected function attachServicesToDoctor(User $doctor, array $serviceIds)
    {
        $doctor->services()->attach($serviceIds);
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

        // ================ 3) ایجاد ۳ سرویس ================
        
        $service1 = $this->createService([
            'name' => 'مشاوره پوست',
            'slug' => 'mashavareh-pust',
            'short_description' => 'مشاوره تخصصی پوست و زیبایی توسط پزشکان مجرب',
            'seo_content' => 'مشاوره پوست و زیبایی با بهترین پزشکان متخصص. درمان جوش، لک، چین و چروک و سایر مشکلات پوستی.',
            'article_content' => 'در این مقاله به بررسی کامل روش‌های مراقبت از پوست، درمان‌های تخصصی و نکات مهم در مشاوره پوست می‌پردازیم...',
            'price' => 250000,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        $service2 = $this->createService([
            'name' => 'لیزر موهای زائد',
            'slug' => 'lazer-moo-ha-ye-zaed',
            'short_description' => 'لیزر موهای زائد با دستگاه‌های پیشرفته و تکنولوژی روز دنیا',
            'seo_content' => 'لیزر موهای زائد با بهترین دستگاه‌های لیزر. مناسب برای انواع پوست و مو. نتایج عالی و ماندگار.',
            'article_content' => 'لیزر موهای زائد یکی از محبوب‌ترین روش‌های حذف موهای زائد است. در این مقاله به مزایا، عوارض و نحوه انجام آن می‌پردازیم...',
            'price' => 450000,
            'duration_minutes' => 45,
            'is_active' => true,
        ]);

        $service3 = $this->createService([
            'name' => 'فیلر و تزریقات',
            'slug' => 'filler-va-tazrighat',
            'short_description' => 'تزریق فیلر، بوتاکس و ژل با بهترین مواد و تکنیک‌های روز',
            'seo_content' => 'تزریقات زیبایی شامل فیلر، بوتاکس، ژل و سایر روش‌های جوانسازی صورت با بالاترین کیفیت.',
            'article_content' => 'تزریقات زیبایی روشی سریع و موثر برای جوانسازی پوست و رفع چین و چروک‌هاست. در این مقاله به بررسی انواع تزریقات می‌پردازیم...',
            'price' => 650000,
            'duration_minutes' => 60,
            'is_active' => true,
        ]);

        // ================ 4) ایجاد ۳ پزشک ================

        // پزشک اول (نمونه)
        $doctor1 = $this->createUser([
            'first_name' => 'پزشک',
            'last_name' => 'نمونه',
            'phone' => '09120000004',
            'email' => 'doctor@clinic.com',
            'password' => 'doctor123',
            'referral_code' => 'DOC001',
            'status' => 'active',
            'points' => 0,
        ], 'doctor');

        // پزشک دوم
        $doctor2 = $this->createUser([
            'first_name' => 'دکتر',
            'last_name' => 'رضایی',
            'phone' => '09120000005',
            'email' => 'doctor2@clinic.com',
            'password' => 'doctor123',
            'referral_code' => 'DOC002',
            'status' => 'active',
            'points' => 0,
        ], 'doctor');

        // پزشک سوم
        $doctor3 = $this->createUser([
            'first_name' => 'دکتر',
            'last_name' => 'کریمی',
            'phone' => '09120000006',
            'email' => 'doctor3@clinic.com',
            'password' => 'doctor123',
            'referral_code' => 'DOC003',
            'status' => 'active',
            'points' => 0,
        ], 'doctor');

        // ================ 5) ایجاد ارتباطات user_service ================
        
        // پزشک اول: هر ۳ سرویس
        $this->attachServicesToDoctor($doctor1, [
            $service1->id,
            $service2->id,
            $service3->id,
        ]);

        // پزشک دوم: سرویس‌های ۱ و ۲
        $this->attachServicesToDoctor($doctor2, [
            $service1->id,
            $service2->id,
        ]);

        // پزشک سوم: سرویس‌های ۲ و ۳
        $this->attachServicesToDoctor($doctor3, [
            $service2->id,
            $service3->id,
        ]);

        // ================ 6) پیام موفقیت ================
        $this->command->info('✅ تمام داده‌ها با موفقیت ایجاد شدند.');
        $this->command->info('📌 سرویس‌های ایجاد شده:');
        $this->command->info('   🔹 مشاوره پوست (۲۵۰,۰۰۰ تومان - ۳۰ دقیقه)');
        $this->command->info('   🔹 لیزر موهای زائد (۴۵۰,۰۰۰ تومان - ۴۵ دقیقه)');
        $this->command->info('   🔹 فیلر و تزریقات (۶۵۰,۰۰۰ تومان - ۶۰ دقیقه)');
        $this->command->info('');
        $this->command->info('📌 پزشکان و سرویس‌های آنها:');
        $this->command->info('   🔹 پزشک نمونه (doctor@clinic.com): هر ۳ سرویس');
        $this->command->info('   🔹 دکتر رضایی (doctor2@clinic.com): مشاوره پوست + لیزر');
        $this->command->info('   🔹 دکتر کریمی (doctor3@clinic.com): لیزر + فیلر و تزریقات');
        $this->command->info('');
        $this->command->info('📌 اطلاعات ورود کاربران:');
        $this->command->info('   🔹 مدیر: admin@clinic.com / admin123');
        $this->command->info('   🔹 پرسنل: employee@clinic.com / employee123');
        $this->command->info('   🔹 مشتری: patient@clinic.com / patient123');
        $this->command->info('   🔹 تامین‌کننده: supplier@clinic.com / supplier123');
        $this->command->info('   🔹 پزشک نمونه: doctor@clinic.com / doctor123');
        $this->command->info('   🔹 دکتر رضایی: doctor2@clinic.com / doctor123');
        $this->command->info('   🔹 دکتر کریمی: doctor3@clinic.com / doctor123');
    }
}