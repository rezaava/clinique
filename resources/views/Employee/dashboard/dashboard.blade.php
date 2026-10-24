@extends('layout.master')

@section('title')
    اوراکلینیک — داشبورد منشی
@endsection

@section('name-page')
    داشبورد
@endsection

@section('btn')
    <div class="clinic-status">
        <span class="live-dot"></span>
        کلینیک باز است · ۸ پزشک حاضر
    </div>
@endsection

@section('text-search')
    جستجوی بیمار، نوبت...
@endsection

@section('subtitle')
    صبح بخیر <span>علی</span> این موارد رو بررسی کن حتما
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/employee/employee.css') }}">
@endsection
@section('content')
    <main class="page">
        {{-- کارت‌های آمار --}}
        <div class="stat-grid" id="statGrid">
            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">نوبت‌ها</span>
                    <span class="stat-ic" style="background:var(--brand-soft);color:var(--brand)">
                        <i class="fa-regular fa-calendar"></i>
                    </span>
                </div>
                <div class="stat-val">{{ count($appointments) }}</div>
                <div class="stat-sub {{ $difference >= 0 ? 'up' : 'warn' }}">
                    {{ $difference >= 0 ? '↗' : '↘' }}
                    {{ abs($difference) }} {{ $difference >= 0 ? '+' : '-' }} نسبت به دیروز
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">درآمد امروز</span>
                    <span class="stat-ic" style="background:var(--green-soft);color:var(--green)">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </span>
                </div>
                <div class="stat-val"><span class="unit">درهم</span>۶٬۸۴۰</div>
                <div class="stat-sub">از هدف ۸٬۵۰۰ درهم</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">بیماران منتظر</span>
                    <span class="stat-ic" style="background:var(--amber-soft);color:var(--amber)">
                        <i class="fa-solid fa-users"></i>
                    </span>
                </div>
                <div class="stat-val">۳</div>
                <div class="stat-sub">میانگین انتظار ۸ دقیقه</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">عدم‌حضور</span>
                    <span class="stat-ic" style="background:var(--red-soft);color:var(--red)">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </span>
                </div>
                <div class="stat-val">۱</div>
                <div class="stat-sub warn">دینا م. — ۱۳:۳۰</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">هشدار انبار</span>
                    <span class="stat-ic" style="background:var(--orange-soft);color:var(--orange)">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </span>
                </div>
                <div class="stat-val">۵</div>
                <div class="stat-sub alert">نیاز به اقدام فوری</div>
            </div>
        </div>

        {{-- مرکز اقدامات --}}
        <div class="section-head">
            <h2 class="section-title">مرکز اقدامات امروز</h2>
            <p class="section-desc">اقدامات اولویت‌دار برای افزایش درآمد و بازگشت مشتری</p>
        </div>

        <div class="action-grid" id="actionGrid">
            <div class="action-card">
                <div class="action-top">
                    <span class="action-ic" style="background:var(--brand-soft);color:var(--brand)">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </span>
                    <span class="action-count">۸</span>
                </div>
                <div class="action-name">ترمیم بوتاکس</div>
                <div class="action-note">بیماران با موعد در ۲ هفته آینده</div>
                <button class="btn btn-blue">تماس با بیماران</button>
            </div>

            <div class="action-card">
                <div class="action-top">
                    <span class="action-ic" style="background:var(--purple-soft);color:var(--purple)">
                        <i class="fa-solid fa-bolt"></i>
                    </span>
                    <span class="action-count">۵</span>
                </div>
                <div class="action-name">جلسات لیزر</div>
                <div class="action-note">در پروتکل فعال — جلسه عقب‌افتاده</div>
                <button class="btn btn-purple">ارسال یادآوری</button>
            </div>

            <div class="action-card">
                <div class="action-top">
                    <span class="action-ic" style="background:var(--orange-soft);color:var(--orange)">
                        <i class="fa-regular fa-clock"></i>
                    </span>
                    <span class="action-count">۲۳</span>
                </div>
                <div class="action-name">غیرفعال +۹۰ روز</div>
                <div class="action-note">بدون مراجعه در بیش از ۳ ماه</div>
                <button class="btn btn-orange">اجرای کمپین</button>
            </div>

            <div class="action-card">
                <div class="action-top">
                    <span class="action-ic" style="background:var(--amber-soft);color:var(--amber)">
                        <i class="fa-solid fa-star"></i>
                    </span>
                    <span class="action-count">۴</span>
                </div>
                <div class="action-name">پیگیری VIP</div>
                <div class="action-note">بیماران ارزشمند در انتظار پذیرش</div>
                <button class="btn btn-amber">تماس با بیماران</button>
            </div>

            <div class="action-card">
                <div class="action-top">
                    <span class="action-ic" style="background:var(--green-soft);color:var(--green)">
                        <i class="fa-solid fa-rotate"></i>
                    </span>
                    <span class="action-count">۳</span>
                </div>
                <div class="action-name">لغوشده — رزرو مجدد</div>
                <div class="action-note">لغوهای اخیر در انتظار رزرو دوباره</div>
                <button class="btn btn-green">رزرو نوبت</button>
            </div>
        </div>

        {{-- نوبت‌ها و تسک‌ها --}}
        <div class="grid-2">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="pt">نوبت‌های امروز</div>
                        <div class="ps">۱۲ نوبت · ۲ انجام‌شده · ۱ عدم‌حضور · ۳ در انتظار</div>
                    </div>
                    <a href="#" class="panel-link">برنامه کامل <span class="chev">‹</span></a>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>زمان</th>
                                <th>بیمار</th>
                                <th>خدمت</th>
                                <th>پزشک</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="apptBody">
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td class="t-time">{{ $appointment->doctorWorkingTimeSlot->start_time }}</td>
                                    <td>
                                        <div class="t-patient">
                                            <span
                                                class="t-avatar">{{ mb_substr($appointment->user->first_name, 0, 1) }}{{ mb_substr($appointment->user->last_name, 0, 1) }}</span>
                                            <span class="t-name">{{ $appointment->user->first_name }}
                                                {{ $appointment->user->last_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $appointment->service->name }}</td>
                                    <td class="t-doctor">{{ $appointment->assignedStaff->first_name }}
                                        {{ $appointment->assignedStaff->last_name }}</td>
                                    <td>
                                        @php
                                            $statuses = [
                                                'pending' => ['در انتظار', 'badge-wait'],
                                                'confirmed' => ['تأیید شده', 'badge-confirm'],
                                                'in_progress' => ['در حال انجام', 'badge-progress'],
                                                'completed' => ['انجام شده', 'badge-done'],
                                                'cancelled' => ['لغو شده', 'badge-noshow'],
                                                'no_show' => ['عدم مراجعه', 'badge-noshow'],
                                            ];

                                            $status = $statuses[$appointment->status] ?? ['نامشخص', 'badge-confirm'];
                                        @endphp

                                        <span class="badge {{ $status[1] }}">{{ $status[0] }}</span>
                                    </td>
                                    <td><a href="#" class="t-action">مشاهده</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="pt">تسک‌های پیگیری</div>
                        <div class="ps">۵ مورد در انتظار امروز</div>
                    </div>
                    <a href="#" class="panel-link">افزودن تسک <span class="chev">‹</span></a>
                </div>

                <div class="task-list" id="taskList">
                    <div class="task" data-i="0">
                        <button class="task-check" aria-label="تکمیل تسک"><i class="fa-solid fa-check"></i></button>
                        <div class="task-body">
                            <div class="task-title">تأیید نوبت بعدازظهر نادیا فرحت</div>
                            <div class="task-meta"><span class="prio prio-high">زیاد</span><span>· ۱۱:۰۰</span><span
                                    class="task-owner">شما</span></div>
                        </div>
                    </div>
                    <div class="task" data-i="1">
                        <button class="task-check" aria-label="تکمیل تسک"><i class="fa-solid fa-check"></i></button>
                        <div class="task-body">
                            <div class="task-title">ارسال دستورالعمل مراقبت به یاسمین خوری</div>
                            <div class="task-meta"><span class="prio prio-high">زیاد</span><span>· ۱۲:۰۰</span><span
                                    class="task-owner">شما</span></div>
                        </div>
                    </div>
                    <div class="task" data-i="2">
                        <button class="task-check" aria-label="تکمیل تسک"><i class="fa-solid fa-check"></i></button>
                        <div class="task-body">
                            <div class="task-title">پیگیری با دینا مصطفی (عدم‌حضور)</div>
                            <div class="task-meta"><span class="prio prio-high">زیاد</span><span>· ۱۴:۰۰</span><span
                                    class="task-owner">شما</span></div>
                        </div>
                    </div>
                    <div class="task" data-i="3">
                        <button class="task-check" aria-label="تکمیل تسک"><i class="fa-solid fa-check"></i></button>
                        <div class="task-body">
                            <div class="task-title">سفارش مجدد بوتاکس — موجودی زیر حد آستانه</div>
                            <div class="task-meta"><span class="prio prio-med">متوسط</span><span>· پایان روز</span><span
                                    class="task-owner">سارا ک.</span></div>
                        </div>
                    </div>
                    <div class="task done" data-i="4">
                        <button class="task-check" aria-label="تکمیل تسک"><i class="fa-solid fa-check"></i></button>
                        <div class="task-body">
                            <div class="task-title">زمان‌بندی سرویس دستگاه IPL لومنیس</div>
                            <div class="task-meta"><span class="prio prio-med">متوسط</span><span>· پایان روز</span><span
                                    class="task-owner">سارا ک.</span></div>
                        </div>
                    </div>
                    <div class="task" data-i="5">
                        <button class="task-check" aria-label="تکمیل تسک"><i class="fa-solid fa-check"></i></button>
                        <div class="task-body">
                            <div class="task-title">ارسال ایمیل بازگشت به فهرست غیرفعال ۹۰ روزه</div>
                            <div class="task-meta"><span class="prio prio-low">کم</span><span>· فردا</span><span
                                    class="task-owner">بازاریابی</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- هشدار انبار و فعالیت‌های اخیر --}}
        <div class="grid-2-even">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="pt">هشدار انبار و دستگاه</div>
                        <div class="ps">۵ مورد نیاز به رسیدگی دارد</div>
                    </div>
                    <a href="#" class="panel-link">مدیریت <span class="chev">‹</span></a>
                </div>

                <div id="alertList">
                    <div class="alert-item">
                        <span class="alert-ic" style="background:var(--amber-soft);color:var(--amber)"><i
                                class="fa-solid fa-triangle-exclamation"></i></span>
                        <div class="alert-body">
                            <div class="alert-name">بوتاکس (آلرگان ۱۰۰ واحد)</div>
                            <div class="alert-sub">۶ واحد باقی‌مانده</div>
                        </div>
                        <a href="#" class="alert-action">سفارش مجدد</a>
                    </div>
                    <div class="alert-item">
                        <span class="alert-ic" style="background:var(--amber-soft);color:var(--amber)"><i
                                class="fa-solid fa-triangle-exclamation"></i></span>
                        <div class="alert-body">
                            <div class="alert-name">فیلر هیالورونیک — ۱ میلی‌لیتر</div>
                            <div class="alert-sub">۴ واحد باقی‌مانده</div>
                        </div>
                        <a href="#" class="alert-action">سفارش مجدد</a>
                    </div>
                    <div class="alert-item">
                        <span class="alert-ic" style="background:var(--red-soft);color:var(--red)"><i
                                class="fa-solid fa-screwdriver-wrench"></i></span>
                        <div class="alert-body">
                            <div class="alert-name">IPL لومنیس StarLux</div>
                            <div class="alert-sub">۱۲ روز از موعد گذشته</div>
                        </div>
                        <a href="#" class="alert-action">زمان‌بندی</a>
                    </div>
                    <div class="alert-item">
                        <span class="alert-ic" style="background:var(--orange-soft);color:var(--orange)"><i
                                class="fa-solid fa-bolt"></i></span>
                        <div class="alert-body">
                            <div class="alert-name">لیزر دیود سوپرانو آیس</div>
                            <div class="alert-sub">۸۷٬۴۰۰ / ۹۰٬۰۰۰ شات</div>
                        </div>
                        <a href="#" class="alert-action">بررسی</a>
                    </div>
                    <div class="alert-item">
                        <span class="alert-ic" style="background:var(--amber-soft);color:var(--amber)"><i
                                class="fa-solid fa-triangle-exclamation"></i></span>
                        <div class="alert-body">
                            <div class="alert-name">کرم بی‌حسی EMLA</div>
                            <div class="alert-sub">۸ واحد باقی‌مانده</div>
                        </div>
                        <a href="#" class="alert-action">سفارش مجدد</a>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <div>
                        <div class="pt">فعالیت‌های اخیر</div>
                        <div class="ps">جریان زنده کلینیک</div>
                    </div>
                    <span class="clinic-status" style="box-shadow:none;padding:6px 12px;font-size:0.82rem">
                        <span class="live-dot"></span>زنده
                    </span>
                </div>

                <div id="activityList">
                    <div class="activity-item">
                        <span class="act-ic" style="background:var(--brand-soft);color:var(--brand)"><i
                                class="fa-solid fa-dollar-sign"></i></span>
                        <div class="act-body">
                            <div class="act-name">پرداخت دریافت شد — ۹۵۰ درهم</div>
                            <div class="act-sub">مونا خلیل · هایدرافیشیال</div>
                        </div>
                        <span class="act-time">۰۹:۵۰</span>
                    </div>
                    <div class="activity-item">
                        <span class="act-ic" style="background:var(--orange-soft);color:var(--orange)"><i
                                class="fa-solid fa-screwdriver-wrench"></i></span>
                        <div class="act-body">
                            <div class="act-name">بازرسی دستگاه انجام شد</div>
                            <div class="act-sub">سوپرانو آیس — تأیید سلامت</div>
                        </div>
                        <span class="act-time">۰۹:۱۵</span>
                    </div>
                    <div class="activity-item">
                        <span class="act-ic" style="background:var(--green-soft);color:var(--green)"><i
                                class="fa-solid fa-check"></i></span>
                        <div class="act-body">
                            <div class="act-name">جلسه سوفیا الرشیدی انجام شد</div>
                            <div class="act-sub">بوتاکس پیشانی · دکتر لیلا ناصر</div>
                        </div>
                        <span class="act-time">۰۹:۴۵</span>
                    </div>
                    <div class="activity-item">
                        <span class="act-ic" style="background:var(--purple-soft);color:var(--purple)"><i
                                class="fa-solid fa-user-plus"></i></span>
                        <div class="act-body">
                            <div class="act-name">بیمار جدید ثبت شد</div>
                            <div class="act-sub">جوئل منصور · معرفی‌شده توسط هالا</div>
                        </div>
                        <span class="act-time">دیروز</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- عملکرد کمپین‌ها --}}
        <div class="panel campaign-panel">
            <div class="panel-head" style="padding:0 0 4px">
                <div>
                    <div class="pt">عملکرد کمپین‌ها</div>
                    <div class="ps">رزروها، نرخ بازگشت و کمپین‌های پیش‌رو</div>
                </div>
                <a href="#" class="panel-link">همه کمپین‌ها <span class="chev">‹</span></a>
            </div>

            <div class="campaign-grid">
                <div class="chart-block">
                    <div class="cb-title">رزرو به ازای کمپین</div>
                    <div class="bar-chart" id="barChart">
                        <div class="bar-col">
                            <div class="bar" style="height:63.33%" data-h="63.33"></div><span
                                class="bar-label">بوتاکس بهار</span>
                        </div>
                        <div class="bar-col">
                            <div class="bar" style="height:90%" data-h="90"></div><span class="bar-label">لیزر
                                تابستان</span>
                        </div>
                        <div class="bar-col">
                            <div class="bar" style="height:48.33%" data-h="48.33"></div><span class="bar-label">VIP
                                گلو</span>
                        </div>
                        <div class="bar-col">
                            <div class="bar" style="height:66.67%" data-h="66.67"></div><span
                                class="bar-label">معرفی</span>
                        </div>
                    </div>
                </div>

                <div class="chart-block">
                    <div class="cb-title">نرخ بازگشت بیمار <span class="rate">↗ ٪۷۹</span></div>
                    <div class="line-chart" id="lineChart">
                        <svg viewBox="0 0 300 160" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="lg" x1="0" y1="0" x2="0"
                                    y2="1">
                                    <stop offset="0%" stop-color="var(--green)" stop-opacity="0.22" />
                                    <stop offset="100%" stop-color="var(--green)" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <path
                                d="M10 102.4 L56.7 90.9 L103.3 107.1 L150 77.2 L196.7 65.7 L243.3 59.2 L290 40.3 L290 150 L10 150 Z"
                                fill="url(#lg)" />
                            <path d="M10 102.4 L56.7 90.9 L103.3 107.1 L150 77.2 L196.7 65.7 L243.3 59.2 L290 40.3"
                                fill="none" stroke="var(--green)" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <circle cx="10" cy="102.4" r="3" fill="var(--surface)" stroke="var(--green)"
                                stroke-width="2" />
                            <circle cx="56.7" cy="90.9" r="3" fill="var(--surface)" stroke="var(--green)"
                                stroke-width="2" />
                            <circle cx="103.3" cy="107.1" r="3" fill="var(--surface)" stroke="var(--green)"
                                stroke-width="2" />
                            <circle cx="150" cy="77.2" r="3" fill="var(--surface)" stroke="var(--green)"
                                stroke-width="2" />
                            <circle cx="196.7" cy="65.7" r="3" fill="var(--surface)" stroke="var(--green)"
                                stroke-width="2" />
                            <circle cx="243.3" cy="59.2" r="3" fill="var(--surface)" stroke="var(--green)"
                                stroke-width="2" />
                            <circle cx="290" cy="40.3" r="3" fill="var(--surface)" stroke="var(--green)"
                                stroke-width="2" />
                        </svg>
                    </div>
                    <div class="line-x" id="lineX">
                        <span>فرو</span><span>ارد</span><span>خرد</span><span>تیر</span><span>مرد</span><span>شهر</span><span>مهر</span>
                    </div>
                </div>

                <div class="chart-block">
                    <div class="cb-title">
                        کمپین‌های پیش‌رو
                        <a href="#" class="panel-link" style="font-size:0.8rem">ساخت ↗</a>
                    </div>
                    <div class="upcoming-list" id="upcomingList">
                        <div class="upcoming-item">
                            <span class="up-ic"><i class="fa-solid fa-bullhorn"></i></span>
                            <div class="up-body">
                                <div class="up-name">بازگشت به درخشش سپتامبر</div>
                                <div class="up-sub">غیرفعال ۹۰ روز · ۱ شهریور</div>
                            </div>
                            <span class="up-status up-draft">پیش‌نویس</span>
                        </div>
                        <div class="upcoming-item">
                            <span class="up-ic"><i class="fa-solid fa-bullhorn"></i></span>
                            <div class="up-body">
                                <div class="up-name">ریست پوستی رمضان</div>
                                <div class="up-sub">بیماران VIP · ۲۸ اسفند</div>
                            </div>
                            <span class="up-status up-scheduled">زمان‌بندی‌شده</span>
                        </div>
                        <div class="upcoming-item">
                            <span class="up-ic"><i class="fa-solid fa-bullhorn"></i></span>
                            <div class="up-body">
                                <div class="up-name">معرفی درمان جدید</div>
                                <div class="up-sub">همه بیماران · ۱۵ مرداد</div>
                            </div>
                            <span class="up-status up-scheduled">زمان‌بندی‌شده</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script src="{{ asset('js/employee/index.js') }}"></script>
@endsection