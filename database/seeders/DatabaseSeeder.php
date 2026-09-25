<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ServiceExpectation;
use App\Models\ServiceCategory;
use Carbon\Carbon;
use App\Models\FAQ;
use App\Models\ServiceSuitability;
use App\Models\ServiceAftercare;
use App\Models\WorkingDay;
use App\Models\WorkingTimeSlot;
use App\Models\Credential;
use App\Models\ServiceTreatmentStep;

class DatabaseSeeder extends Seeder
{
    protected function createRole(string $name, string $display_name, string $description = null)
    {
        $role = new Role();
        $role->name = $name;
        $role->display_name = $display_name;
        $role->description = $description ?? $display_name;
        $role->save();

        return $role;
    }

    protected function createAftercare(
        int $serviceId,
        string $text,
        int $sortOrder
    ) {
        return ServiceAftercare::create([
            'service_id' => $serviceId,
            'text' => $text,
            'sort_order' => $sortOrder,
        ]);
    }

    protected function createExpectation(
        int $serviceId,
        string $text,
        string $status,
        int $sortOrder
    ) {
        return ServiceExpectation::create([
            'service_id' => $serviceId,
            'text' => $text,
            'status' => $status,
            'sort_order' => $sortOrder,
        ]);
    }

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
        $user->experience = $data['experience'] ?? null;
        $user->about = $data['about'] ?? null;

        $user->save();

        $user->addRole($role);

        return $user;
    }

    protected function createServiceSuitability(
        int $serviceId,
        string $text,
        int $level
    ) {
        return ServiceSuitability::create([
            'service_id' => $serviceId,
            'text' => $text,
            'level' => $level,
        ]);
    }

    protected function createTreatmentStep(
        int $serviceId,
        string $name,
        string $svg,
        int $sortOrder
    ) {
        return ServiceTreatmentStep::create([
            'service_id' => $serviceId,
            'name' => $name,
            'svg' => $svg,
            'sort_order' => $sortOrder,
        ]);
    }

    protected function createService(array $data)
    {
        $service = new Service();

        $service->cat_id = $data['cat_id'];
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

    protected function attachServicesToDoctor(User $doctor, array $serviceIds)
    {
        $doctor->services()->attach($serviceIds);
    }

    protected function createFAQ(
        int $serviceId,
        string $text,
        string $answer
    ) {
        $faq = new FAQ();

        $faq->service_id = $serviceId;
        $faq->text = $text;
        $faq->answer = $answer;

        $faq->save();

        return $faq;
    }

    /**
     * تبدیل dayOfWeek لاراول:
     *
     * Sunday    = 0
     * Monday    = 1
     * ...
     * Saturday  = 6
     *
     * به day دیتابیس:
     *
     * Saturday  = 0
     * Sunday    = 1
     * ...
     * Thursday  = 5
     */
    protected function getWorkingDayNumber(Carbon $date): int
    {
        return ($date->dayOfWeek + 1) % 7;
    }

    /**
     * پیدا کردن یک رکورد واقعی از doctor_working_time_slot
     *
     * خروجی:
     * [
     *     'date' => Carbon,
     *     'pivot_id' => int
     * ]
     *
     * اگر پزشک در تاریخ داده‌شده کاری نداشته باشد،
     * تاریخ به اولین روز کاری بعدی پزشک منتقل می‌شود.
     */
    protected function resolveDoctorWorkingTimeSlot(
        User $doctor,
        Carbon $date
    ): array {
        $date = $date->copy();

        for ($i = 0; $i < 7; $i++) {
            $workingDayNumber = $this->getWorkingDayNumber($date);

            $pivot = DB::table('doctor_working_time_slot')
                ->join(
                    'working_time_slots',
                    'working_time_slots.id',
                    '=',
                    'doctor_working_time_slot.working_time_slot_id'
                )
                ->join(
                    'working_days',
                    'working_days.id',
                    '=',
                    'working_time_slots.working_day_id'
                )
                ->where(
                    'doctor_working_time_slot.user_id',
                    $doctor->id
                )
                ->where(
                    'working_days.day',
                    $workingDayNumber
                )
                ->orderBy('working_time_slots.start_time')
                ->select(
                    'doctor_working_time_slot.id as pivot_id',
                    'working_time_slots.id as working_time_slot_id',
                    'working_time_slots.start_time',
                    'working_time_slots.end_time'
                )
                ->first();

            if ($pivot) {
                return [
                    'date' => $date,
                    'pivot_id' => $pivot->pivot_id,
                ];
            }

            $date->addDay();
        }

        throw new \RuntimeException(
            "هیچ زمان کاری برای پزشک {$doctor->id} پیدا نشد."
        );
    }

    protected function createAppointment(array $data)
    {
        $appointment = new Appointment();

        $appointment->user_id = $data['user_id'];
        $appointment->service_id = $data['service_id'];
        $appointment->assigned_staff_id = $data['assigned_staff_id'] ?? null;

        $appointment->appointment_date = $data['appointment_date'];

        $appointment->doctor_working_time_slot_id =
            $data['doctor_working_time_slot_id'] ?? null;

        $appointment->duration_minutes =
            $data['duration_minutes'] ?? 30;

        $appointment->status =
            $data['status'] ?? 'pending';

        $appointment->client_notes =
            $data['client_notes'] ?? null;

        $appointment->staff_notes =
            $data['staff_notes'] ?? null;

        $appointment->amount =
            $data['amount'] ?? 0;

        $appointment->payment_status =
            $data['payment_status'] ?? 'unpaid';

        $appointment->deposit_amount =
            $data['deposit_amount'] ?? 0;

        $appointment->paid_at =
            $data['paid_at'] ?? null;

        $appointment->confirmed_at =
            $data['confirmed_at'] ?? null;

        $appointment->completed_at =
            $data['completed_at'] ?? null;

        $appointment->cancelled_at =
            $data['cancelled_at'] ?? null;

        $appointment->cancel_reason =
            $data['cancel_reason'] ?? null;

        $appointment->rating =
            $data['rating'] ?? null;

        $appointment->staff_rating =
            $data['staff_rating'] ?? null;

        $appointment->review =
            $data['review'] ?? null;

        $appointment->reviewed_at =
            $data['reviewed_at'] ?? null;

        $appointment->save();

        if (
            ($data['payment_status'] ?? 'unpaid') !== 'unpaid'
            &&
            ($data['paid_amount'] ?? 0) > 0
        ) {
            $paidAmount = $data['paid_amount'];

            $finalAmount =
                $data['final_amount'] ?? $data['amount'];

            $remainingAmount = max(
                0,
                $finalAmount - $paidAmount
            );

            $transactionStatus =
                $paidAmount >= $finalAmount
                    ? 'paid'
                    : 'partial';

            Transaction::create([
                'user_id' => $appointment->user_id,
                'appointment_id' => $appointment->id,
                'discount_id' => $data['discount_id'] ?? null,
                'transaction_number' =>
                    'TRX-' . strtoupper(Str::random(12)),
                'type' => 'payment',
                'payment_method' =>
                    $data['payment_method'] ?? 'online',
                'amount' =>
                    $data['amount'] ?? 0,
                'discount_amount' =>
                    $data['discount_amount'] ?? 0,
                'final_amount' => $finalAmount,
                'paid_amount' => $paidAmount,
                'remaining_amount' => $remainingAmount,
                'status' => $transactionStatus,
                'description' =>
                    $data['transaction_description']
                    ?? 'پرداخت مربوط به نوبت',
                'reference_number' =>
                    $data['reference_number'] ?? null,
                'meta_data' =>
                    $data['transaction_meta_data'] ?? null,
                'paid_at' =>
                    $data['paid_at'] ?? now(),
                'created_by' =>
                    $data['created_by'] ?? null,
            ]);
        }

        return $appointment;
    }

    protected function createCredential(
        User $user,
        string $title,
        string $text,
        ?string $type = null
    ) {
        return Credential::create([
            'user_id' => $user->id,
            'title' => $title,
            'text' => $text,
            'type' => $type,
        ]);
    }

    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | Working Days
        |--------------------------------------------------------------------------
        */

        WorkingDay::create([
            'name_fa' => 'شنبه',
            'name_en' => 'Saturday',
            'day' => 0,
        ]);

        WorkingDay::create([
            'name_fa' => 'یکشنبه',
            'name_en' => 'Sunday',
            'day' => 1,
        ]);

        WorkingDay::create([
            'name_fa' => 'دوشنبه',
            'name_en' => 'Monday',
            'day' => 2,
        ]);

        WorkingDay::create([
            'name_fa' => 'سه‌شنبه',
            'name_en' => 'Tuesday',
            'day' => 3,
        ]);

        WorkingDay::create([
            'name_fa' => 'چهارشنبه',
            'name_en' => 'Wednesday',
            'day' => 4,
        ]);

        WorkingDay::create([
            'name_fa' => 'پنجشنبه',
            'name_en' => 'Thursday',
            'day' => 5,
        ]);

        $workingDays = WorkingDay::all()->keyBy('day');

        /*
        |--------------------------------------------------------------------------
        | Working Time Slots
        |--------------------------------------------------------------------------
        */

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[0]->id,
            'start_time' => '08:00',
            'end_time' => '10:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[0]->id,
            'start_time' => '10:30',
            'end_time' => '12:30',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[0]->id,
            'start_time' => '16:00',
            'end_time' => '18:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[1]->id,
            'start_time' => '08:00',
            'end_time' => '10:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[1]->id,
            'start_time' => '10:30',
            'end_time' => '12:30',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[1]->id,
            'start_time' => '16:00',
            'end_time' => '18:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[2]->id,
            'start_time' => '08:00',
            'end_time' => '12:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[2]->id,
            'start_time' => '16:00',
            'end_time' => '20:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[3]->id,
            'start_time' => '08:00',
            'end_time' => '12:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[3]->id,
            'start_time' => '16:00',
            'end_time' => '20:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[4]->id,
            'start_time' => '08:00',
            'end_time' => '12:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[4]->id,
            'start_time' => '16:00',
            'end_time' => '20:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[5]->id,
            'start_time' => '08:00',
            'end_time' => '12:00',
        ]);

        WorkingTimeSlot::create([
            'working_day_id' => $workingDays[5]->id,
            'start_time' => '16:00',
            'end_time' => '18:00',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $this->createRole(
            'admin',
            'مدیر',
            'مدیر کلینیک با دسترسی کامل'
        );

        $this->createRole(
            'employee',
            'پرسنل',
            'پرسنل کلینیک (پزشک، اپراتور، منشی)'
        );

        $this->createRole(
            'doctor',
            'پزشک',
            'پزشک متخصص'
        );

        $this->createRole(
            'patient',
            'بیمار/مشتری',
            'مشتری کلینیک'
        );

        $this->createRole(
            'supplier',
            'تامین‌کننده',
            'تامین‌کننده تجهیزات و مواد مصرفی'
        );

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Service Categories
        |--------------------------------------------------------------------------
        */

        $categorySkin = ServiceCategory::create([
            'name' => 'پوست',
            'slug' => 'poost',
            'description' => 'خدمات تخصصی پوست و مراقبت از پوست',
            'is_active' => true,
        ]);

        $categoryLaser = ServiceCategory::create([
            'name' => 'لیزر',
            'slug' => 'laser',
            'description' => 'خدمات لیزر و حذف موهای زائد',
            'is_active' => true,
        ]);

        $categoryInjection = ServiceCategory::create([
            'name' => 'تزریقات زیبایی',
            'slug' => 'tazrighat-zibayi',
            'description' => 'خدمات تزریق فیلر، بوتاکس و ژل',
            'is_active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        $service1 = $this->createService([
            'cat_id' => $categorySkin->id,
            'name' => 'مشاوره پوست',
            'slug' => 'mashavareh-pust',
            'short_description' =>
                'مشاوره تخصصی پوست و زیبایی توسط پزشکان مجرب',
            'seo_content' =>
                'مشاوره پوست و زیبایی با بهترین پزشکان متخصص. درمان جوش، لک، چین و چروک و سایر مشکلات پوستی.',
            'article_content' =>
                'در این مقاله به بررسی کامل روش‌های مراقبت از پوست، درمان‌های تخصصی و نکات مهم در مشاوره پوست می‌پردازیم...',
            'price' => 250000,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        $service2 = $this->createService([
            'cat_id' => $categoryLaser->id,
            'name' => 'لیزر موهای زائد',
            'slug' => 'lazer-moo-ha-ye-zaed',
            'short_description' =>
                'لیزر موهای زائد با دستگاه‌های پیشرفته و تکنولوژی روز دنیا',
            'seo_content' =>
                'لیزر موهای زائد با بهترین دستگاه‌های لیزر. مناسب برای انواع پوست و مو. نتایج عالی و ماندگار.',
            'article_content' =>
                'لیزر موهای زائد یکی از محبوب‌ترین روش‌های حذف موهای زائد است. در این مقاله به مزایا، عوارض و نحوه انجام آن می‌پردازیم...',
            'price' => 450000,
            'duration_minutes' => 45,
            'is_active' => true,
        ]);

        $service3 = $this->createService([
            'cat_id' => $categoryInjection->id,
            'name' => 'فیلر و تزریقات',
            'slug' => 'filler-va-tazrighat',
            'short_description' =>
                'تزریق فیلر، بوتاکس و ژل با بهترین مواد و تکنیک‌های روز',
            'seo_content' =>
                'تزریقات زیبایی شامل فیلر، بوتاکس، ژل و سایر روش‌های جوانسازی صورت با بالاترین کیفیت.',
            'article_content' =>
                'تزریقات زیبایی روشی سریع و موثر برای جوانسازی پوست و رفع چین و چروک‌هاست. در این مقاله به بررسی انواع تزریقات می‌پردازیم...',
            'price' => 650000,
            'duration_minutes' => 60,
            'is_active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Service Aftercares
        |--------------------------------------------------------------------------
        */

        $this->createAftercare(
            $service1->id,
            'بعد از مشاوره، توصیه‌های تخصصی پزشک را طبق برنامه درمانی دنبال کنید.',
            1
        );

        $this->createAftercare(
            $service1->id,
            'از محصولات پوستی تجویز شده توسط متخصص به صورت منظم استفاده کنید.',
            2
        );

        $this->createAftercare(
            $service1->id,
            'در صورت مشاهده واکنش غیرطبیعی، با متخصص خود تماس بگیرید.',
            3
        );

        $this->createAftercare(
            $service2->id,
            'تا ۲۴ ساعت از سونا، جکوزی و ورزش سنگین خودداری کنید.',
            1
        );

        $this->createAftercare(
            $service2->id,
            'تا چند روز از قرار گرفتن مستقیم در معرض نور شدید خورشید خودداری کنید.',
            2
        );

        $this->createAftercare(
            $service2->id,
            'از ضدآفتاب مناسب برای محافظت از پوست استفاده کنید.',
            3
        );

        $this->createAftercare(
            $service2->id,
            'در صورت بروز التهاب یا واکنش غیرعادی، با متخصص خود مشورت کنید.',
            4
        );

        $this->createAftercare(
            $service3->id,
            'تا ۲۴ ساعت محل تزریق را ماساژ یا دستکاری نکنید.',
            1
        );

        $this->createAftercare(
            $service3->id,
            'تا مدتی از ورزش سنگین و گرمای شدید خودداری کنید.',
            2
        );

        $this->createAftercare(
            $service3->id,
            'دستورالعمل‌های پزشک را برای مراقبت از محل تزریق رعایت کنید.',
            3
        );

        /*
        |--------------------------------------------------------------------------
        | FAQs
        |--------------------------------------------------------------------------
        */

        $this->createFAQ(
            $service1->id,
            'مشاوره پوست چقدر طول می‌کشد؟',
            'مدت زمان مشاوره معمولاً حدود ۳۰ دقیقه است و بسته به شرایط پوست شما ممکن است کمی متفاوت باشد.'
        );

        $this->createFAQ(
            $service1->id,
            'آیا قبل از مراجعه باید کاری انجام دهم؟',
            'بهتر است قبل از مراجعه از استفاده از محصولات تحریک‌کننده پوست خودداری کنید و اطلاعات مربوط به محصولات مصرفی خود را همراه داشته باشید.'
        );

        $this->createFAQ(
            $service1->id,
            'آیا بعد از مشاوره درمان شروع می‌شود؟',
            'پس از بررسی شرایط پوست، پزشک روش درمانی مناسب را پیشنهاد می‌دهد و در صورت نیاز مراحل درمانی بعدی تعیین می‌شود.'
        );

        $this->createFAQ(
            $service2->id,
            'لیزر موهای زائد چقدر طول می‌کشد؟',
            'مدت زمان لیزر به ناحیه مورد نظر بستگی دارد و معمولاً بین ۳۰ تا ۶۰ دقیقه زمان می‌برد.'
        );

        $this->createFAQ(
            $service2->id,
            'آیا لیزر موهای زائد درد دارد؟',
            'ممکن است هنگام انجام لیزر کمی احساس گرما یا سوزش خفیف داشته باشید، اما شدت آن معمولاً قابل تحمل است.'
        );

        $this->createFAQ(
            $service2->id,
            'چند جلسه لیزر نیاز است؟',
            'تعداد جلسات به نوع پوست، ضخامت مو، ناحیه مورد نظر و شرایط فردی بستگی دارد و معمولاً به چند جلسه نیاز است.'
        );

        $this->createFAQ(
            $service2->id,
            'آیا قبل از لیزر باید موها را اصلاح کرد؟',
            'بله، معمولاً توصیه می‌شود قبل از جلسه موهای ناحیه مورد نظر با تیغ اصلاح شوند و از روش‌هایی مانند اپیلاسیون استفاده نشود.'
        );

        $this->createFAQ(
            $service3->id,
            'تزریق فیلر چقدر طول می‌کشد؟',
            'بسته به ناحیه مورد درمان، تزریق فیلر معمولاً بین ۳۰ تا ۶۰ دقیقه زمان می‌برد.'
        );

        $this->createFAQ(
            $service3->id,
            'آیا تزریق فیلر درد دارد؟',
            'ممکن است کمی ناراحتی یا سوزش احساس شود. در صورت نیاز می‌توان از روش‌های بی‌حسی موضعی برای کاهش ناراحتی استفاده کرد.'
        );

        $this->createFAQ(
            $service3->id,
            'ماندگاری فیلر چقدر است؟',
            'ماندگاری فیلر به نوع ماده، محل تزریق، میزان متابولیسم بدن و شرایط فردی بستگی دارد.'
        );

        /*
        |--------------------------------------------------------------------------
        | Service Suitabilities
        |--------------------------------------------------------------------------
        */

        $this->createServiceSuitability(
            $service1->id,
            'اگر درباره مشکلات پوستی مثل جوش، لک، خشکی، چربی یا حساسیت پوست سوال دارید.',
            1
        );

        $this->createServiceSuitability(
            $service1->id,
            'اگر به دنبال بررسی تخصصی پوست و دریافت برنامه درمانی مناسب هستید.',
            2
        );

        $this->createServiceSuitability(
            $service1->id,
            'اگر مشکل پوستی شما طولانی‌مدت یا پیچیده است و نیاز به بررسی تخصصی پزشک دارید.',
            3
        );

        $this->createServiceSuitability(
            $service2->id,
            'اگر از رشد موهای زائد بدن یا صورت ناراضی هستید.',
            1
        );

        $this->createServiceSuitability(
            $service2->id,
            'اگر به دنبال کاهش قابل توجه رشد موهای زائد و داشتن پوستی صاف‌تر هستید.',
            2
        );

        $this->createServiceSuitability(
            $service2->id,
            'اگر موهای زائد ضخیم و مقاوم دارید و به دنبال یک برنامه منظم برای کاهش آن‌ها هستید.',
            3
        );

        $this->createServiceSuitability(
            $service3->id,
            'اگر می‌خواهید تغییرات ظریف و طبیعی در ظاهر صورت خود ایجاد کنید.',
            1
        );

        $this->createServiceSuitability(
            $service3->id,
            'اگر برای رفع چین و چروک، حجم‌دهی یا اصلاح فرم برخی نواحی صورت به دنبال راهکار زیبایی هستید.',
            2
        );

        $this->createServiceSuitability(
            $service3->id,
            'اگر برای انتخاب نوع تزریق، مقدار مناسب و روش انجام آن نیاز به بررسی و مشاوره تخصصی دارید.',
            3
        );

        /*
        |--------------------------------------------------------------------------
        | Service Expectations
        |--------------------------------------------------------------------------
        */

        $this->createExpectation(
            $service1->id,
            'قبل از درمان پوست خود را با شوینده ملایم تمیز کنید.',
            'before',
            1
        );

        $this->createExpectation(
            $service1->id,
            'در ابتدا پوست بررسی و برای درمان آماده می‌شود.',
            'during',
            2
        );

        $this->createExpectation(
            $service1->id,
            'بعد از درمان ممکن است کمی قرمزی یا حساسیت موقت داشته باشید.',
            'after',
            3
        );

        $this->createExpectation(
            $service2->id,
            'حداقل ۲۴ ساعت قبل از درمان از اپیلاسیون و روش‌های کندن مو استفاده نکنید.',
            'before',
            1
        );

        $this->createExpectation(
            $service2->id,
            'در طول درمان ممکن است احساس گرما یا سوزش خفیف داشته باشید.',
            'during',
            2
        );

        $this->createExpectation(
            $service2->id,
            'تا مدتی پس از درمان از قرار گرفتن مستقیم در معرض آفتاب خودداری کنید.',
            'after',
            3
        );

        $this->createExpectation(
            $service3->id,
            'قبل از تزریق، در صورت مصرف دارو یا داشتن حساسیت، پزشک را مطلع کنید.',
            'before',
            1
        );

        $this->createExpectation(
            $service3->id,
            'پزشک ناحیه مورد نظر را بررسی کرده و تزریق را انجام می‌دهد.',
            'during',
            2
        );

        $this->createExpectation(
            $service3->id,
            'ممکن است تورم یا قرمزی خفیف و موقت در محل تزریق ایجاد شود.',
            'after',
            3
        );

        /*
        |--------------------------------------------------------------------------
        | Treatment Steps
        |--------------------------------------------------------------------------
        */

        $this->createTreatmentStep(
            $service1->id,
            'مشاوره',
            'M12 2v4M6 6h12M6 10h12M6 14h8',
            1
        );

        $this->createTreatmentStep(
            $service1->id,
            'بررسی پوست',
            'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2ZM8 12l2 2 4-4',
            2
        );

        $this->createTreatmentStep(
            $service1->id,
            'تشخیص',
            'M9 11a3 3 0 1 0 6 0a3 3 0 1 0-6 0ZM4 20a8 8 0 0 1 16 0',
            3
        );

        $this->createTreatmentStep(
            $service1->id,
            'برنامه درمان',
            'M4 4h16v16H4zM8 8h8M8 12h8M8 16h5',
            4
        );

        $this->createTreatmentStep(
            $service2->id,
            'مشاوره',
            'M12 2v4M6 6h12M6 10h12M6 14h8',
            1
        );

        $this->createTreatmentStep(
            $service2->id,
            'آماده‌سازی',
            'M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5S5 13 5 15a7 7 0 0 0 7 7z',
            2
        );

        $this->createTreatmentStep(
            $service2->id,
            'انجام لیزر',
            'M12 2l1.5 5.5L19 9l-5.5 1.5L12 16l-1.5-5.5L5 9l5.5-1.5z',
            3
        );

        $this->createTreatmentStep(
            $service2->id,
            'مراقبت پس از درمان',
            'M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2',
            4
        );

        $this->createTreatmentStep(
            $service3->id,
            'مشاوره',
            'M12 2v4M6 6h12M6 10h12M6 14h8',
            1
        );

        $this->createTreatmentStep(
            $service3->id,
            'بررسی و طراحی',
            'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2ZM8 16l8-8',
            2
        );

        $this->createTreatmentStep(
            $service3->id,
            'تزریق',
            'M14 4l6 6-10 10H4v-6L14 4ZM12 6l6 6',
            3
        );

        $this->createTreatmentStep(
            $service3->id,
            'مراقبت پس از تزریق',
            'M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2ZM8 12l2 2 4-4',
            4
        );

        /*
        |--------------------------------------------------------------------------
        | Doctors
        |--------------------------------------------------------------------------
        */

        $doctor1 = $this->createUser([
            'first_name' => 'پزشک',
            'last_name' => 'نمونه',
            'phone' => '09120000004',
            'email' => 'doctor@clinic.com',
            'password' => 'doctor123',
            'referral_code' => 'DOC001',
            'status' => 'active',
            'points' => 0,
            'experience' => 8,
            'about' =>
                'پزشک متخصص پوست و زیبایی با بیش از ۸ سال تجربه در زمینه درمان مشکلات پوستی و خدمات زیبایی.',
        ], 'doctor');

        $doctor2 = $this->createUser([
            'first_name' => 'دکتر',
            'last_name' => 'رضایی',
            'phone' => '09120000005',
            'email' => 'doctor2@clinic.com',
            'password' => 'doctor123',
            'referral_code' => 'DOC002',
            'status' => 'active',
            'points' => 0,
            'experience' => 6,
            'about' =>
                'دکتر رضایی با ۶ سال سابقه در زمینه پوست، لیزر و مراقبت‌های تخصصی پوست فعالیت می‌کند.',
        ], 'doctor');

        $doctor3 = $this->createUser([
            'first_name' => 'دکتر',
            'last_name' => 'کریمی',
            'phone' => '09120000006',
            'email' => 'doctor3@clinic.com',
            'password' => 'doctor123',
            'referral_code' => 'DOC003',
            'status' => 'active',
            'points' => 0,
            'experience' => 10,
            'about' =>
                'دکتر کریمی با ۱۰ سال سابقه در زمینه خدمات زیبایی، لیزر و تزریقات تخصصی فعالیت دارد.',
        ], 'doctor');

        /*
        |--------------------------------------------------------------------------
        | Doctor Working Time Slots
        |--------------------------------------------------------------------------
        */

        $doctor1->workingTimeSlots()->attach([
            $workingDays[0]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[0]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,

            $workingDays[1]->workingTimeSlots()
                ->where('start_time', '10:30')
                ->first()->id,

            $workingDays[1]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,

            $workingDays[2]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[3]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,

            $workingDays[4]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[5]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,
        ]);

        $doctor2->workingTimeSlots()->attach([
            $workingDays[0]->workingTimeSlots()
                ->where('start_time', '10:30')
                ->first()->id,

            $workingDays[1]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[2]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,

            $workingDays[3]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[4]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,

            $workingDays[5]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,
        ]);

        $doctor3->workingTimeSlots()->attach([
            $workingDays[0]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[0]->workingTimeSlots()
                ->where('start_time', '10:30')
                ->first()->id,

            $workingDays[1]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,

            $workingDays[2]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[2]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,

            $workingDays[4]->workingTimeSlots()
                ->where('start_time', '08:00')
                ->first()->id,

            $workingDays[5]->workingTimeSlots()
                ->where('start_time', '16:00')
                ->first()->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Credentials
        |--------------------------------------------------------------------------
        */

        $this->createCredential(
            $doctor1,
            'دارای بورد تخصصی',
            'پزشکی زیبایی و آرایشی',
            'board'
        );

        $this->createCredential(
            $doctor1,
            'فلوشیپ بین‌المللی',
            'زیبایی پیشرفته صورت، لندن',
            'fellowship'
        );

        $this->createCredential(
            $doctor1,
            'عضو',
            'انجمن اروپایی پزشکی زیبایی',
            'member'
        );

        $this->createCredential(
            $doctor2,
            'دارای بورد تخصصی',
            'پوست و زیبایی',
            'board'
        );

        $this->createCredential(
            $doctor2,
            'دوره تخصصی',
            'لیزر و درمان‌های پیشرفته پوست',
            'fellowship'
        );

        $this->createCredential(
            $doctor2,
            'عضو',
            'انجمن متخصصین پوست و زیبایی',
            'member'
        );

        $this->createCredential(
            $doctor3,
            'دارای بورد تخصصی',
            'پوست و مو',
            'board'
        );

        $this->createCredential(
            $doctor3,
            'فلوشیپ بین‌المللی',
            'تزریقات و جوانسازی صورت',
            'fellowship'
        );

        $this->createCredential(
            $doctor3,
            'عضو',
            'انجمن پزشکی زیبایی ایران',
            'member'
        );

        /*
        |--------------------------------------------------------------------------
        | Doctor Services
        |--------------------------------------------------------------------------
        */

        $this->attachServicesToDoctor(
            $doctor1,
            [
                $service1->id,
                $service2->id,
                $service3->id,
            ]
        );

        $this->attachServicesToDoctor(
            $doctor2,
            [
                $service1->id,
                $service2->id,
            ]
        );

        $this->attachServicesToDoctor(
            $doctor3,
            [
                $service2->id,
                $service3->id,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Dates
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $thisWeek = Carbon::today()->addDays(3);
        $nextWeek = Carbon::today()->addDays(7);
        $twoWeeks = Carbon::today()->addDays(14);
        $lastWeek = Carbon::today()->subDays(7);
        $twoWeeksAgo = Carbon::today()->subDays(14);
        $threeWeeksAgo = Carbon::today()->subDays(21);

        /*
        |--------------------------------------------------------------------------
        | Resolve Doctor Slots
        |--------------------------------------------------------------------------
        |
        | برای هر نوبت دارای پزشک، رکورد واقعی
        | doctor_working_time_slot پیدا می‌شود.
        |
        */

        $slot1 = $this->resolveDoctorWorkingTimeSlot(
            $doctor1,
            $today
        );

        $slot2 = $this->resolveDoctorWorkingTimeSlot(
            $doctor2,
            $today
        );

        $slot3 = $this->resolveDoctorWorkingTimeSlot(
            $doctor1,
            $lastWeek
        );

        $slot4 = $this->resolveDoctorWorkingTimeSlot(
            $doctor3,
            $twoWeeksAgo
        );

        $slot5 = $this->resolveDoctorWorkingTimeSlot(
            $doctor1,
            $tomorrow
        );

        $slot6 = $this->resolveDoctorWorkingTimeSlot(
            $doctor2,
            $twoWeeks
        );

        $slot7 = $this->resolveDoctorWorkingTimeSlot(
            $doctor3,
            $thisWeek
        );

        $slot8 = $this->resolveDoctorWorkingTimeSlot(
            $doctor2,
            $tomorrow->copy()->addDays(2)
        );

        $slot9 = $this->resolveDoctorWorkingTimeSlot(
            $doctor1,
            $nextWeek->copy()->addDays(1)
        );

        $slot10 = $this->resolveDoctorWorkingTimeSlot(
            $doctor3,
            $today->copy()->addDays(2)
        );

        $slot11 = $this->resolveDoctorWorkingTimeSlot(
            $doctor1,
            $lastWeek->copy()->addDays(2)
        );

        $slot12 = $this->resolveDoctorWorkingTimeSlot(
            $doctor2,
            $lastWeek->copy()->addDays(3)
        );

        $slot13 = $this->resolveDoctorWorkingTimeSlot(
            $doctor1,
            $twoWeeks->copy()->addDays(2)
        );

        $slot14 = $this->resolveDoctorWorkingTimeSlot(
            $doctor2,
            $twoWeeksAgo->copy()->addDays(4)
        );

        $slot15 = $this->resolveDoctorWorkingTimeSlot(
            $doctor3,
            $today->copy()->addDays(6)
        );

        $slot16 = $this->resolveDoctorWorkingTimeSlot(
            $doctor1,
            $threeWeeksAgo->copy()->addDays(3)
        );

        /*
        |--------------------------------------------------------------------------
        | Appointments
        |--------------------------------------------------------------------------
        */

        // 1 - بدون پزشک
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => null,
            'doctor_working_time_slot_id' => null,
            'appointment_date' => $tomorrow->toDateString(),
            'duration_minutes' => 30,
            'status' => 'pending',
            'client_notes' =>
                'می‌خواهم درباره جوش‌های صورتم مشورت کنم',
            'amount' => 250000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
        ]);

        // 2 - بدون پزشک
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => null,
            'doctor_working_time_slot_id' => null,
            'appointment_date' => $nextWeek->toDateString(),
            'duration_minutes' => 45,
            'status' => 'pending',
            'client_notes' =>
                'برای لیزر موهای زائد پاها مراجعه می‌کنم',
            'amount' => 450000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
        ]);

        // 3
        $this->createAppointment([
            'user_id' => $patient1->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor1->id,
            'doctor_working_time_slot_id' => $slot1['pivot_id'],
            'appointment_date' => $slot1['date']->toDateString(),
            'duration_minutes' => 60,
            'status' => 'confirmed',
            'client_notes' =>
                'برای تزریق فیلر گونه مراجعه می‌کنم',
            'staff_notes' =>
                'تأیید شده توسط دکتر نمونه',
            'amount' => 650000,
            'payment_status' => 'partial',
            'deposit_amount' => 200000,
            'paid_amount' => 200000,
            'paid_at' => now()->subHours(2),
            'confirmed_at' => now()->subHours(3),
        ]);

        // 4
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor2->id,
            'doctor_working_time_slot_id' => $slot2['pivot_id'],
            'appointment_date' => $slot2['date']->toDateString(),
            'duration_minutes' => 45,
            'status' => 'in_progress',
            'client_notes' =>
                'جلسه دوم لیزر موهای زائد',
            'staff_notes' =>
                'در حال انجام توسط دکتر رضایی',
            'amount' => 450000,
            'payment_status' => 'paid',
            'deposit_amount' => 450000,
            'paid_amount' => 450000,
            'paid_at' => now()->subHours(2),
            'confirmed_at' => now()->subDays(5),
        ]);

        // 5
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => $doctor1->id,
            'doctor_working_time_slot_id' => $slot3['pivot_id'],
            'appointment_date' => $slot3['date']->toDateString(),
            'duration_minutes' => 30,
            'status' => 'completed',
            'client_notes' =>
                'مشاوره پوست - درمان آکنه',
            'staff_notes' =>
                'خدمت انجام شد. وضعیت پوست خوب است.',
            'amount' => 250000,
            'payment_status' => 'paid',
            'deposit_amount' => 250000,
            'paid_amount' => 250000,
            'paid_at' =>
                $slot3['date']->copy()->addHours(2),
            'confirmed_at' =>
                $slot3['date']->copy()->subDays(1),
            'completed_at' =>
                $slot3['date']->copy()->addHours(1),
            'rating' => 5,
            'staff_rating' => 5,
            'review' =>
                'بسیار عالی! دکتر خیلی دقیق و حرفه‌ای بودند.',
            'reviewed_at' =>
                $slot3['date']->copy()->addHours(2),
        ]);

        // 6
        $this->createAppointment([
            'user_id' => $patient4->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor3->id,
            'doctor_working_time_slot_id' => $slot4['pivot_id'],
            'appointment_date' => $slot4['date']->toDateString(),
            'duration_minutes' => 45,
            'status' => 'completed',
            'client_notes' =>
                'لیزر موهای زائد زیر بغل',
            'staff_notes' => 'انجام شد',
            'amount' => 450000,
            'payment_status' => 'paid',
            'deposit_amount' => 450000,
            'paid_amount' => 450000,
            'paid_at' =>
                $slot4['date']->copy()->addHours(2),
            'confirmed_at' =>
                $slot4['date']->copy()->subDays(3),
            'completed_at' =>
                $slot4['date']->copy()->addHours(1),
            'rating' => 3,
            'staff_rating' => 4,
            'review' =>
                'خوب بود اما نتونستن کامل موها رو بزنن',
            'reviewed_at' =>
                $slot4['date']->copy()->addHours(2),
        ]);

        // 7
        $this->createAppointment([
            'user_id' => $patient4->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor1->id,
            'doctor_working_time_slot_id' => $slot5['pivot_id'],
            'appointment_date' => $slot5['date']->toDateString(),
            'duration_minutes' => 60,
            'status' => 'cancelled',
            'client_notes' => 'تزریق فیلر لب',
            'amount' => 650000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
            'cancelled_at' => now()->subDays(1),
            'cancel_reason' =>
                'بیمار به دلیل مسائل شخصی لغو کرد',
        ]);

        // 8
        $slotNoShow = $this->resolveDoctorWorkingTimeSlot(
            $doctor3,
            $threeWeeksAgo
        );

        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor3->id,
            'doctor_working_time_slot_id' => $slotNoShow['pivot_id'],
            'appointment_date' =>
                $slotNoShow['date']->toDateString(),
            'duration_minutes' => 60,
            'status' => 'no_show',
            'client_notes' => 'مشاوره تزریقات',
            'staff_notes' =>
                'بیمار حضور پیدا نکرد',
            'amount' => 650000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
            'confirmed_at' =>
                $slotNoShow['date']->copy()->subDays(2),
        ]);

        // 9
        $this->createAppointment([
            'user_id' => $patient1->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor2->id,
            'doctor_working_time_slot_id' => $slot6['pivot_id'],
            'appointment_date' => $slot6['date']->toDateString(),
            'duration_minutes' => 45,
            'status' => 'confirmed',
            'client_notes' =>
                'جلسه سوم لیزر موهای زائد',
            'staff_notes' =>
                'پرداخت بیعانه انجام شده',
            'amount' => 450000,
            'payment_status' => 'partial',
            'deposit_amount' => 150000,
            'paid_amount' => 150000,
            'paid_at' => now()->subHours(4),
            'confirmed_at' => now()->subHours(5),
        ]);

        // 10 - بدون پزشک
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => null,
            'doctor_working_time_slot_id' => null,
            'appointment_date' =>
                $nextWeek->copy()->addDays(3)->toDateString(),
            'duration_minutes' => 30,
            'status' => 'pending',
            'client_notes' =>
                'مشاوره پوست برای درمان لک‌های صورت',
            'amount' => 250000,
            'payment_status' => 'partial',
            'deposit_amount' => 100000,
            'paid_amount' => 100000,
            'paid_at' => now()->subHours(1),
        ]);

        // 11
        $this->createAppointment([
            'user_id' => $patient4->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor3->id,
            'doctor_working_time_slot_id' => $slot7['pivot_id'],
            'appointment_date' => $slot7['date']->toDateString(),
            'duration_minutes' => 60,
            'status' => 'confirmed',
            'client_notes' => 'تزریق بوتاکس',
            'staff_notes' =>
                'مراجعه برای تزریق بوتاکس پیشانی',
            'amount' => 650000,
            'payment_status' => 'paid',
            'deposit_amount' => 650000,
            'paid_amount' => 650000,
            'paid_at' => now()->subHours(6),
            'confirmed_at' => now()->subHours(8),
        ]);

        // 12
        $this->createAppointment([
            'user_id' => $patient1->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => $doctor2->id,
            'doctor_working_time_slot_id' => $slot8['pivot_id'],
            'appointment_date' => $slot8['date']->toDateString(),
            'duration_minutes' => 30,
            'status' => 'confirmed',
            'client_notes' => 'بررسی لک‌های صورت',
            'amount' => 250000,
            'payment_status' => 'partial',
            'deposit_amount' => 125000,
            'paid_amount' => 125000,
            'paid_at' => now()->subHours(10),
            'confirmed_at' => now()->subHours(11),
        ]);

        // 13
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor1->id,
            'doctor_working_time_slot_id' => $slot9['pivot_id'],
            'appointment_date' => $slot9['date']->toDateString(),
            'duration_minutes' => 45,
            'status' => 'pending',
            'client_notes' => 'لیزر دست‌ها',
            'amount' => 450000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
        ]);

        // 14
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor3->id,
            'doctor_working_time_slot_id' => $slot10['pivot_id'],
            'appointment_date' => $slot10['date']->toDateString(),
            'duration_minutes' => 60,
            'status' => 'confirmed',
            'client_notes' => 'مشاوره برای فیلر لب',
            'amount' => 650000,
            'payment_status' => 'partial',
            'deposit_amount' => 300000,
            'paid_amount' => 300000,
            'paid_at' => now()->subDays(1),
            'confirmed_at' => now()->subHours(10),
        ]);

        // 15
        $this->createAppointment([
            'user_id' => $patient4->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => $doctor1->id,
            'doctor_working_time_slot_id' => $slot11['pivot_id'],
            'appointment_date' => $slot11['date']->toDateString(),
            'duration_minutes' => 30,
            'status' => 'completed',
            'client_notes' => 'مشاوره درمان جوش',
            'staff_notes' => 'درمان اولیه تجویز شد',
            'amount' => 250000,
            'payment_status' => 'paid',
            'deposit_amount' => 250000,
            'paid_amount' => 250000,
            'paid_at' =>
                $slot11['date']->copy()->addHours(2),
            'confirmed_at' =>
                $slot11['date']->copy()->subDays(1),
            'completed_at' =>
                $slot11['date']->copy()->addHours(1),
            'rating' => 4,
            'staff_rating' => 5,
            'review' => 'مشاوره خوب و کامل بود.',
            'reviewed_at' =>
                $slot11['date']->copy()->addHours(3),
        ]);

        // 16
        $this->createAppointment([
            'user_id' => $patient1->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => $doctor2->id,
            'doctor_working_time_slot_id' => $slot12['pivot_id'],
            'appointment_date' => $slot12['date']->toDateString(),
            'duration_minutes' => 45,
            'status' => 'completed',
            'client_notes' => 'لیزر صورت',
            'staff_notes' => 'جلسه انجام شد',
            'amount' => 450000,
            'payment_status' => 'paid',
            'deposit_amount' => 450000,
            'paid_amount' => 450000,
            'paid_at' =>
                $slot12['date']->copy()->addHours(2),
            'confirmed_at' =>
                $slot12['date']->copy()->subDays(2),
            'completed_at' =>
                $slot12['date']->copy()->addHours(1),
            'rating' => 5,
            'staff_rating' => 5,
            'review' => 'خیلی راضی بودم.',
            'reviewed_at' =>
                $slot12['date']->copy()->addHours(3),
        ]);

        // 17
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor1->id,
            'doctor_working_time_slot_id' => $slot13['pivot_id'],
            'appointment_date' => $slot13['date']->toDateString(),
            'duration_minutes' => 60,
            'status' => 'confirmed',
            'client_notes' => 'تزریق فیلر گونه',
            'amount' => 650000,
            'payment_status' => 'partial',
            'deposit_amount' => 250000,
            'paid_amount' => 250000,
            'paid_at' => now()->subDays(2),
            'confirmed_at' => now()->subDays(2),
        ]);

        // 18
        $this->createAppointment([
            'user_id' => $patient3->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => $doctor2->id,
            'doctor_working_time_slot_id' => $slot14['pivot_id'],
            'appointment_date' => $slot14['date']->toDateString(),
            'duration_minutes' => 30,
            'status' => 'completed',
            'client_notes' => 'مشاوره پوست',
            'staff_notes' =>
                'جلسه با موفقیت انجام شد',
            'amount' => 250000,
            'payment_status' => 'paid',
            'deposit_amount' => 250000,
            'paid_amount' => 250000,
            'paid_at' =>
                $slot14['date']->copy()->addHours(2),
            'confirmed_at' =>
                $slot14['date']->copy()->subDays(1),
            'completed_at' =>
                $slot14['date']->copy()->addHours(1),
            'rating' => 4,
            'staff_rating' => 4,
            'review' => 'خدمات مناسب بود.',
            'reviewed_at' =>
                $slot14['date']->copy()->addHours(3),
        ]);

        // 19 - بدون پزشک
        $this->createAppointment([
            'user_id' => $patient4->id,
            'service_id' => $service2->id,
            'assigned_staff_id' => null,
            'doctor_working_time_slot_id' => null,
            'appointment_date' =>
                $today->copy()->addDays(5)->toDateString(),
            'duration_minutes' => 45,
            'status' => 'pending',
            'client_notes' =>
                'درخواست لیزر موهای زائد',
            'amount' => 450000,
            'payment_status' => 'unpaid',
            'deposit_amount' => 0,
        ]);

        // 20
        $this->createAppointment([
            'user_id' => $patient1->id,
            'service_id' => $service3->id,
            'assigned_staff_id' => $doctor3->id,
            'doctor_working_time_slot_id' => $slot15['pivot_id'],
            'appointment_date' => $slot15['date']->toDateString(),
            'duration_minutes' => 60,
            'status' => 'confirmed',
            'client_notes' => 'تزریق ژل',
            'amount' => 650000,
            'payment_status' => 'paid',
            'deposit_amount' => 650000,
            'paid_amount' => 650000,
            'paid_at' => now()->subHours(3),
            'confirmed_at' => now()->subHours(4),
        ]);

        // 21
        $this->createAppointment([
            'user_id' => $patient2->id,
            'service_id' => $service1->id,
            'assigned_staff_id' => $doctor1->id,
            'doctor_working_time_slot_id' => $slot16['pivot_id'],
            'appointment_date' => $slot16['date']->toDateString(),
            'duration_minutes' => 30,
            'status' => 'cancelled',
            'client_notes' => 'مشاوره پوست',
            'amount' => 250000,
            'payment_status' => 'partial',
            'deposit_amount' => 100000,
            'paid_amount' => 100000,
            'paid_at' => now()->subWeeks(3),
            'cancelled_at' => now()->subWeeks(3)->addDay(),
            'cancel_reason' => 'لغو توسط بیمار',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Console Info
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            '✅ تمام داده‌ها با موفقیت ایجاد شدند.'
        );

        $this->command->info(
            '📌 تعداد نوبت‌های ایجاد شده: ۲۱'
        );

        $this->command->info(
            '📌 نوبت‌های دارای پزشک به doctor_working_time_slot متصل شدند.'
        );

        $this->command->info(
            '📌 نوبت‌های بدون پزشک، doctor_working_time_slot ندارند.'
        );

        $this->command->info(
            '📌 برای نوبت‌های دارای پرداخت، Transaction ایجاد شده است.'
        );

        $this->command->info(
            '📌 نوبت‌های بدون پرداخت، Transaction ندارند.'
        );

        $this->command->info('');

        $this->command->info('📌 سرویس‌های ایجاد شده:');

        $this->command->info(
            '   🔹 مشاوره پوست (۲۵۰,۰۰۰ تومان - ۳۰ دقیقه)'
        );

        $this->command->info(
            '   🔹 لیزر موهای زائد (۴۵۰,۰۰۰ تومان - ۴۵ دقیقه)'
        );

        $this->command->info(
            '   🔹 فیلر و تزریقات (۶۵۰,۰۰۰ تومان - ۶۰ دقیقه)'
        );

        $this->command->info('');

        $this->command->info('📌 اطلاعات ورود کاربران:');

        $this->command->info(
            '   🔹 مدیر: admin@clinic.com / admin123'
        );

        $this->command->info(
            '   🔹 پرسنل: employee@clinic.com / employee123'
        );

        $this->command->info(
            '   🔹 مشتری نمونه: patient@clinic.com / patient123'
        );

        $this->command->info(
            '   🔹 سارا احمدی: sara@clinic.com / patient123'
        );

        $this->command->info(
            '   🔹 مریم کریمی: maryam@clinic.com / patient123'
        );

        $this->command->info(
            '   🔹 علی رضایی: ali@clinic.com / patient123'
        );

        $this->command->info(
            '   🔹 تامین‌کننده: supplier@clinic.com / supplier123'
        );

        $this->command->info(
            '   🔹 پزشک نمونه: doctor@clinic.com / doctor123'
        );

        $this->command->info(
            '   🔹 دکتر رضایی: doctor2@clinic.com / doctor123'
        );

        $this->command->info(
            '   🔹 دکتر کریمی: doctor3@clinic.com / doctor123'
        );
    }
}