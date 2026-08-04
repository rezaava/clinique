<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

    /**
     * Helper function for creating appointments
     */
    protected function createAppointment(array $data)
    {
        $appointment = new Appointment();
        $appointment->user_id = $data['user_id'];
        $appointment->service_id = $data['service_id'];
        $appointment->assigned_staff_id = $data['assigned_staff_id'] ?? null;
        $appointment->appointment_date = $data['appointment_date'];
        $appointment->appointment_time = $data['appointment_time'];
        $appointment->duration_minutes = $data['duration_minutes'] ?? 30;
        $appointment->status = $data['status'] ?? 'pending';
        $appointment->client_notes = $data['client_notes'] ?? null;
        $appointment->staff_notes = $data['staff_notes'] ?? null;
        $appointment->amount = $data['amount'] ?? 0;
        $appointment->payment_status = $data['payment_status'] ?? 'unpaid';
        $appointment->deposit_amount = $data['deposit_amount'] ?? 0;
        $appointment->paid_at = $data['paid_at'] ?? null;
        $appointment->confirmed_at = $data['confirmed_at'] ?? null;
        $appointment->completed_at = $data['completed_at'] ?? null;
        $appointment->cancelled_at = $data['cancelled_at'] ?? null;
        $appointment->cancel_reason = $data['cancel_reason'] ?? null;
        $appointment->rating = $data['rating'] ?? null;
        $appointment->staff_rating = $data['staff_rating'] ?? null;
        $appointment->review = $data['review'] ?? null;
        $appointment->reviewed_at = $data['reviewed_at'] ?? null;
        
        $appointment->save();

        return $appointment;
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
        $admin = $this->createUser([
            'first_name' => 'مدیر',
            'last_name' => 'سیستم',
            'phone' => '09120000000',
            'email' => 'admin@clinic.com',
            'password' => 'admin123',
            'referral_code' => 'ADMIN123',
            'status' => 'active',
            'points' => 0,
        ], 'admin');

        // پرسنل (منشی)
        $employee = $this->createUser([
            'first_name' => 'پرسنل',
            'last_name' => 'نمونه',
            'phone' => '09120000001',
            'email' => 'employee@clinic.com',
            'password' => 'employee123',
            'referral_code' => 'EMP001',
            'status' => 'active',
            'points' => 0,
        ], 'employee');

        // مشتری اول
        $patient1 = $this->createUser([
            'first_name' => 'مشتری',
            'last_name' => 'نمونه',
            'phone' => '09120000002',
            'email' => 'patient@clinic.com',
            'password' => 'patient123',
            'referral_code' => 'PAT001',
            'status' => 'active',
            'points' => 0,
        ], 'patient');

        // مشتری دوم (برای نوبت‌ها)
        $patient2 = $this->createUser([
            'first_name' => 'سارا',
            'last_name' => 'احمدی',
            'phone' => '09120000007',
            'email' => 'sara@clinic.com',
            'password' => 'patient123',
            'referral_code' => 'PAT002',
            'status' => 'active',
            'points' => 10,
        ], 'patient');

        // مشتری سوم (برای نوبت‌ها)
        $patient3 = $this->createUser([
            'first_name' => 'مریم',
            'last_name' => 'کریمی',
            'phone' => '09120000008',
            'email' => 'maryam@clinic.com',
            'password' => 'patient123',
            'referral_code' => 'PAT003',
            'status' => 'active',
            'points' => 25,
        ], 'patient');

        // مشتری چهارم (برای نوبت‌ها)
        $patient4 = $this->createUser([
            'first_name' => 'علی',
            'last_name' => 'رضایی',
            'phone' => '09120000009',
            'email' => 'ali@clinic.com',
            'password' => 'patient123',
            'referral_code' => 'PAT004',
            'status' => 'active',
            'points' => 5,
        ], 'patient');

        // تامین‌کننده
        $supplier = $this->createUser([
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

        // پزشک اول
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

        // ================ 6) ایجاد نوبت‌ها ================

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $nextWeek = Carbon::today()->addDays(7);
        $lastWeek = Carbon::today()->subDays(7);

        // نوبت 1: درخواست جدید (pending)
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => null,
            'appointment_date' => $tomorrow->toDateString(),
            'appointment_time' => '10:00:00',
            'duration_minutes' => 30,
            'status' => 'pending',
            'client_notes' => 'می‌خواهم درباره جوش‌های صورتم مشورت کنم',
            'amount' => 250000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
        ]);

        // نوبت 2: درخواست جدید (pending) - سرویس لیزر
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => null,
            'appointment_date' => $nextWeek->toDateString(),
            'appointment_time' => '14:30:00',
            'duration_minutes' => 45,
            'status' => 'pending',
            'client_notes' => 'برای لیزر موهای زائد پاها مراجعه می‌کنم',
            'amount' => 450000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
        ]);

        // نوبت 3: تأیید شده (confirmed) - توسط دکتر1
        $this->createAppointment([
            'user_id' => $patient1->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor1->id,
            'appointment_date' => $today->toDateString(),
            'appointment_time' => '11:00:00',
            'duration_minutes' => 60,
            'status' => 'confirmed',
            'client_notes' => 'برای تزریق فیلر گونه مراجعه می‌کنم',
            'staff_notes' => 'تأیید شده توسط دکتر نمونه',
            'amount' => 650000,
            'payment_status' => 'partial',
            'deposit_amount' => 200000,
            'paid_at' => now()->subHours(2),
            'confirmed_at' => now()->subHours(3),
        ]);

        // نوبت 4: در حال انجام (in_progress) - توسط دکتر2
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor2->id,
            'appointment_date' => $today->toDateString(),
            'appointment_time' => '09:30:00',
            'duration_minutes' => 45,
            'status' => 'in_progress',
            'client_notes' => 'جلسه دوم لیزر موهای زائد',
            'staff_notes' => 'در حال انجام توسط دکتر رضایی',
            'amount' => 450000,
            'payment_status' => 'paid',
            'deposit_amount' => 450000,
            'paid_at' => now()->subHours(2),
            'confirmed_at' => now()->subDays(5),
        ]);

        // نوبت 5: تکمیل شده (completed) - با امتیاز
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => $doctor1->id,
            'appointment_date' => $lastWeek->toDateString(),
            'appointment_time' => '13:00:00',
            'duration_minutes' => 30,
            'status' => 'completed',
            'client_notes' => 'مشاوره پوست - درمان آکنه',
            'staff_notes' => 'خدمت انجام شد. وضعیت پوست خوب است.',
            'amount' => 250000,
            'payment_status' => 'paid',
            'deposit_amount' => 250000,
            'paid_at' => $lastWeek->addHours(2),
            'confirmed_at' => $lastWeek->subDays(1),
            'completed_at' => $lastWeek->addHours(1),
            'rating' => 5,
            'staff_rating' => 5,
            'review' => 'بسیار عالی! دکتر خیلی دقیق و حرفه‌ای بودند.',
            'reviewed_at' => $lastWeek->addHours(2),
        ]);

        // نوبت 6: تکمیل شده (completed) - با امتیاز متوسط
        $this->createAppointment([
            'user_id' => $patient4->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor3->id,
            'appointment_date' => $lastWeek->subDays(2)->toDateString(),
            'appointment_time' => '16:00:00',
            'duration_minutes' => 45,
            'status' => 'completed',
            'client_notes' => 'لیزر موهای زائد زیر بغل',
            'staff_notes' => 'انجام شد',
            'amount' => 450000,
            'payment_status' => 'paid',
            'deposit_amount' => 450000,
            'paid_at' => $lastWeek->subDays(2)->addHours(2),
            'confirmed_at' => $lastWeek->subDays(3),
            'completed_at' => $lastWeek->subDays(2)->addHours(1),
            'rating' => 3,
            'staff_rating' => 4,
            'review' => 'خوب بود اما نتونستن کامل موها رو بزنن',
            'reviewed_at' => $lastWeek->subDays(2)->addHours(2),
        ]);

        // نوبت 7: لغو شده (cancelled)
        $this->createAppointment([
            'user_id' => $patient4->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor1->id,
            'appointment_date' => $today->toDateString(),
            'appointment_time' => '15:30:00',
            'duration_minutes' => 60,
            'status' => 'cancelled',
            'client_notes' => 'تزریق فیلر لب',
            'amount' => 650000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
            'cancelled_at' => now()->subDays(1),
            'cancel_reason' => 'بیمار به دلیل مسائل شخصی لغو کرد',
        ]);

        // نوبت 8: عدم حضور (no_show)
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor3->id,
            'appointment_date' => $lastWeek->addDays(1)->toDateString(),
            'appointment_time' => '10:30:00',
            'duration_minutes' => 60,
            'status' => 'no_show',
            'client_notes' => 'مشاوره تزریقات',
            'staff_notes' => 'بیمار حضور پیدا نکرد',
            'amount' => 650000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
            'confirmed_at' => $lastWeek->subDays(2),
        ]);

        // نوبت 9: تکمیل شده با بیعانه (deposit)
        $this->createAppointment([
            'user_id' => $patient1->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor2->id,
            'appointment_date' => $tomorrow->addDays(2)->toDateString(),
            'appointment_time' => '12:00:00',
            'duration_minutes' => 45,
            'status' => 'confirmed',
            'client_notes' => 'جلسه سوم لیزر موهای زائد',
            'staff_notes' => 'پرداخت بیعانه انجام شده',
            'amount' => 450000,
            'payment_status' => 'partial',
            'deposit_amount' => 150000,
            'paid_at' => now()->subHours(4),
            'confirmed_at' => now()->subHours(5),
        ]);

        // نوبت 10: درخواست جدید با بیعانه
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => null,
            'appointment_date' => $nextWeek->addDays(3)->toDateString(),
            'appointment_time' => '09:00:00',
            'duration_minutes' => 30,
            'status' => 'pending',
            'client_notes' => 'مشاوره پوست برای درمان لک‌های صورت',
            'amount' => 250000,
            'payment_status' => 'partial',
            'deposit_amount' => 100000,
            'paid_at' => now()->subHours(1),
        ]);

        // ================ 7) پیام موفقیت ================
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
        $this->command->info('📌 نوبت‌های ایجاد شده (۱۰ نوبت):');
        $this->command->info('   🔹 ۲ نوبت در انتظار تایید (pending)');
        $this->command->info('   🔹 ۲ نوبت تأیید شده (confirmed)');
        $this->command->info('   🔹 ۱ نوبت در حال انجام (in_progress)');
        $this->command->info('   🔹 ۲ نوبت تکمیل شده (completed) با امتیاز');
        $this->command->info('   🔹 ۱ نوبت لغو شده (cancelled)');
        $this->command->info('   🔹 ۱ نوبت عدم حضور (no_show)');
        $this->command->info('   🔹 ۱ نوبت تأیید شده با بیعانه');
        $this->command->info('');
        $this->command->info('📌 اطلاعات ورود کاربران:');
        $this->command->info('   🔹 مدیر: admin@clinic.com / admin123');
        $this->command->info('   🔹 پرسنل: employee@clinic.com / employee123');
        $this->command->info('   🔹 مشتری نمونه: patient@clinic.com / patient123');
        $this->command->info('   🔹 سارا احمدی: sara@clinic.com / patient123');
        $this->command->info('   🔹 مریم کریمی: maryam@clinic.com / patient123');
        $this->command->info('   🔹 علی رضایی: ali@clinic.com / patient123');
        $this->command->info('   🔹 تامین‌کننده: supplier@clinic.com / supplier123');
        $this->command->info('   🔹 پزشک نمونه: doctor@clinic.com / doctor123');
        $this->command->info('   🔹 دکتر رضایی: doctor2@clinic.com / doctor123');
        $this->command->info('   🔹 دکتر کریمی: doctor3@clinic.com / doctor123');
    }
}