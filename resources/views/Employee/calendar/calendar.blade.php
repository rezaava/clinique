@extends('layout.master')

@section('title')
    اوراکلینیک — تقویم منشی
@endsection

@section('name-page')
    تقویم
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('css/employee/calendar.css') }}">
@endsection

@section('text-search')
    جستجو بیمار
@endsection

@section('btn')
    <div class="calendar-header">
        <div class="date-nav">
            <button class="nav-arrow" aria-label="روز قبل"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg></button>
            <span class="cur-date">سه‌شنبه، ۲۵ دی ۱۴۰۳</span>
            <button class="nav-arrow" aria-label="روز بعد"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg></button>
        </div>
        <button class="btn-today">امروز</button>
        <div class="view-switch" id="viewSwitch">
            <button class="vs-btn">روز</button>
            <button class="vs-btn active">هفته</button>
            <button class="vs-btn">ماه</button>
        </div>
        <div class="filters">
            <button class="filter-btn">پزشک<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg></button>
            <button class="filter-btn">درمان<svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg></button>
            <button class="filter-btn">اتاق<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg></button>
            <button class="filter-btn">دستگاه<svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg></button>
        </div>
    </div>
@endsection

@section('content')
    @php
        // ==============================
        //  داده‌های ثابت (فیک)
        // ==============================

        $stats = [
            (object) ['title' => 'درآمد امروز', 'icon' => 'dollar', 'color' => 'green', 'val' => '۱۷۵ م ت', 'sub' => '۱۲٪+ نسبت به دیروز', 'cls' => 'up'],
            (object) ['title' => 'نوبت‌ها', 'icon' => 'appointments', 'color' => 'brand', 'val' => '۲۲', 'sub' => '۲ انجام‌شده'],
            (object) ['title' => 'بازه‌های آزاد', 'icon' => 'clock', 'color' => 'teal', 'val' => '۶', 'sub' => 'بعدی ساعت ۱۲:۳۰'],
            (object) ['title' => 'لغوشده', 'icon' => 'xcircle', 'color' => 'red', 'val' => '۱', 'sub' => '۲ مورد امروز صبح'],
            (object) ['title' => 'عدم‌حضور', 'icon' => 'warn', 'color' => 'orange', 'val' => '۱', 'sub' => 'توماس گرنت', 'cls' => 'warn'],
            (object) ['title' => 'در انتظار', 'icon' => 'hourglass', 'color' => 'amber', 'val' => '۳', 'sub' => 'تقریباً ۱۵ تا ۵۵ دقیقه'],
        ];

        $doctors = [
            (object) ['init' => 'س‌چ', 'name' => 'دکتر سارا چن', 'spec' => 'لیزر و بازسازی پوست', 'count' => 6, 'color' => '#2563eb'],
            (object) ['init' => 'ج‌م', 'name' => 'دکتر جیمز مالک', 'spec' => 'تزریقات و فیلر', 'count' => 5, 'color' => '#4f46e5'],
            (object) ['init' => 'ا‌ت', 'name' => 'دکتر اِما تورس', 'spec' => 'پوست و آبرسانی', 'count' => 5, 'color' => '#059669'],
            (object) ['init' => 'م‌پ', 'name' => 'دکتر مایکل پارک', 'spec' => 'RF و سفت‌کردن', 'count' => 6, 'color' => '#ea580c'],
        ];

        $appointments = [
            (object) ['col' => 0, 'start' => 8, 'dur' => 1, 'init' => 'م', 'name' => 'میا جانسون', 'treat' => 'هایدرافیشیال دلوکس', 'room' => 'اتاق ۲ · هایدرافیشیال MD', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 0, 'start' => 9.15, 'dur' => 0.55, 'init' => 'آ', 'name' => 'آنا رودریگز', 'treat' => null, 'room' => null, 'c' => 'c-purple', 'dot' => '#7c3aed', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 0, 'start' => 10.5, 'dur' => 1.5, 'init' => 'ا', 'name' => 'اِما دیویس', 'treat' => 'لیزر روسرفیسینگ فرکسل', 'room' => 'سوئیت لیزر · فرکسل ۱۵۵۰', 'c' => 'c-blue', 'dot' => '#2563eb', 'vip' => true, 'confirm' => false, 'selected' => true],
            (object) ['col' => 0, 'start' => 13, 'dur' => 1, 'init' => 'س', 'name' => 'سوفی ویلیامز', 'treat' => 'پیلینگ شیمیایی VI', 'room' => 'اتاق ۳', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 0, 'start' => 15, 'dur' => 0.55, 'init' => 'ر', 'name' => 'راشل کیم', 'treat' => null, 'room' => null, 'c' => 'c-amber', 'dot' => '#f59e0b', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 0, 'start' => 16, 'dur' => 1, 'init' => 'ل', 'name' => 'لورا چن', 'treat' => 'میکرونیدلینگ RF', 'room' => 'اتاق ۴ · Secret RF', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => false, 'selected' => false],

            (object) ['col' => 1, 'start' => 8.5, 'dur' => 1.2, 'init' => 'ج', 'name' => 'جیمز ترنر', 'treat' => 'درمان مو PRP', 'room' => 'اتاق ۳', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 1, 'start' => 10.2, 'dur' => 1.3, 'init' => 'ا', 'name' => 'ایزابلا براون', 'treat' => 'کمبو بوتاکس + فیلر', 'room' => 'اتاق ۲', 'c' => 'c-purple', 'dot' => '#7c3aed', 'vip' => true, 'confirm' => false, 'selected' => false],
            (object) ['col' => 1, 'start' => 12, 'dur' => 0.55, 'init' => 'م', 'name' => 'مارک لی', 'treat' => null, 'room' => null, 'c' => 'c-blue', 'dot' => '#2563eb', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 1, 'start' => 14, 'dur' => 1.4, 'init' => 'ا', 'name' => 'اولیویا پارک', 'treat' => 'لیزر موهای زائد', 'room' => 'سوئیت لیزر · فرکسل ۱۵۵۰', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => true, 'selected' => false],
            (object) ['col' => 1, 'start' => 16.3, 'dur' => 0.7, 'init' => 'ک', 'name' => 'کریس اوانز', 'treat' => 'تزریق کایبلا', 'room' => null, 'c' => 'c-red', 'dot' => '#dc2626', 'vip' => false, 'confirm' => false, 'selected' => false],

            (object) ['col' => 2, 'start' => 9.2, 'dur' => 1.5, 'init' => 'ن', 'name' => 'ناتالی اسکات', 'treat' => 'ترماژ FLX پلاتینیوم', 'room' => 'اتاق ۲ · هایدرافیشیال MD', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => true, 'selected' => false],
            (object) ['col' => 2, 'start' => 11.2, 'dur' => 0.55, 'init' => 'د', 'name' => 'دایانا رید', 'treat' => null, 'room' => null, 'c' => 'c-blue', 'dot' => '#2563eb', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 2, 'start' => 12.5, 'dur' => 1.5, 'init' => 'و', 'name' => 'ویکتوریا هال', 'treat' => 'اولترافی کل صورت', 'room' => 'اتاق ۴', 'c' => 'c-purple', 'dot' => '#7c3aed', 'vip' => true, 'confirm' => false, 'selected' => false],
            (object) ['col' => 2, 'start' => 14.7, 'dur' => 0.9, 'init' => 'آ', 'name' => 'آلیس کوپر', 'treat' => 'میکرونیدلینگ + PRP', 'room' => 'اتاق ۳', 'c' => 'c-amber', 'dot' => '#f59e0b', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 2, 'start' => 16, 'dur' => 1, 'init' => 'ل', 'name' => 'لی‌لی اوانز', 'treat' => 'فیلر لب و گونه', 'room' => 'اتاق ۱', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => false, 'selected' => false],

            (object) ['col' => 3, 'start' => 8, 'dur' => 0.55, 'init' => 'ه', 'name' => 'هنری ویلسون', 'treat' => null, 'room' => null, 'c' => 'c-blue', 'dot' => '#2563eb', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 3, 'start' => 9.2, 'dur' => 1.5, 'init' => 'گ', 'name' => 'گریس تیلور', 'treat' => 'ترماژ FLX صورت', 'room' => 'اتاق ۴ · ترماژ FLX', 'c' => 'c-purple', 'dot' => '#7c3aed', 'vip' => true, 'confirm' => false, 'selected' => false],
            (object) ['col' => 3, 'start' => 11.2, 'dur' => 1, 'init' => 'ر', 'name' => 'رایان جانسون', 'treat' => 'پیلینگ شیمیایی TCA', 'room' => 'اتاق ۳', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 3, 'start' => 13.5, 'dur' => 1.2, 'init' => 'آ', 'name' => 'آوا مارتینز', 'treat' => 'درمان Secret RF', 'room' => 'اتاق ۲ · Secret RF', 'c' => 'c-green', 'dot' => '#059669', 'vip' => false, 'confirm' => true, 'selected' => false],
            (object) ['col' => 3, 'start' => 15.4, 'dur' => 0.7, 'init' => 'ت', 'name' => 'توماس گرنت', 'treat' => 'کایبلا + بوتاکس', 'room' => null, 'c' => 'c-red', 'dot' => '#dc2626', 'vip' => false, 'confirm' => false, 'selected' => false],
            (object) ['col' => 3, 'start' => 16.3, 'dur' => 0.7, 'init' => 'ک', 'name' => 'کلر بنت', 'treat' => 'بوتاکس کل صورت', 'room' => null, 'c' => 'c-amber', 'dot' => '#f59e0b', 'vip' => false, 'confirm' => false, 'selected' => false],
        ];

        $freeSlots = [
            (object) ['time' => '۱۲:۳۰', 'doc' => 'دکتر سارا چن · اتاق ۱', 'pct' => '۹۵٪'],
            (object) ['time' => '۱۳:۰۰', 'doc' => 'دکتر جیمز مالک · اتاق ۲', 'pct' => '۸۸٪'],
            (object) ['time' => '۱۵:۳۰', 'doc' => 'دکتر اِما تورس · اتاق ۳', 'pct' => '۸۲٪'],
        ];

        $resources = [
            (object) ['name' => 'اتاق ۱', 'status' => 'free', 'label' => 'آزاد'],
            (object) ['name' => 'اتاق ۲', 'status' => 'inuse', 'label' => 'در حال استفاده'],
            (object) ['name' => 'اتاق ۳', 'status' => 'inuse', 'label' => 'در حال استفاده'],
            (object) ['name' => 'سوئیت لیزر', 'status' => 'maint', 'label' => 'تعمیرات'],
            (object) ['name' => 'اتاق ۴', 'status' => 'free', 'label' => 'آزاد'],
        ];

        $devices = [
            (object) ['name' => 'فرکسل ۱۵۵۰', 'badge' => 'active', 'badgeL' => 'فعال', 'sub' => 'در حال استفاده — دکتر سارا چن', 'shots' => '۲٬۳۴۰ / ۵٬۰۰۰', 'pct' => 47],
            (object) ['name' => 'هایدرافیشیال MD', 'badge' => 'active', 'badgeL' => 'فعال', 'sub' => 'در حال استفاده — دکتر اِما تورس', 'shots' => null, 'pct' => null],
            (object) ['name' => 'ترماژ FLX', 'badge' => 'ready', 'badgeL' => 'آماده', 'sub' => 'سرویس بعدی: ۶ بهمن', 'shots' => null, 'pct' => null],
            (object) ['name' => 'Secret RF', 'badge' => 'ready', 'badgeL' => 'آماده', 'sub' => 'آماده — کاملاً استریل شده', 'shots' => null, 'pct' => null],
        ];

        $waitList = [
            (object) ['init' => 'م‌و', 'name' => 'مارکوس وب', 'prio' => 'high', 'prioL' => 'زیاد', 'sub' => 'ترمیم بوتاکس · حدود ۱۵ دقیقه انتظار'],
            (object) ['init' => 'ج‌پ', 'name' => 'جوانا پرایس', 'prio' => 'med', 'prioL' => 'متوسط', 'sub' => 'هایدرافیشیال · حدود ۳۵ دقیقه انتظار'],
            (object) ['init' => 'د‌ک', 'name' => 'دیوید کانگ', 'prio' => 'low', 'prioL' => 'کم', 'sub' => 'مشاوره · حدود ۵۵ دقیقه انتظار'],
        ];

        $startHour = 7;
        $endHour = 20;
        $nowTime = 15.6;

        // تابع کمک‌کننده برای تبدیل اعداد به فارسی
        function toFa($num)
        {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            return str_replace($english, $persian, (string) $num);
        }

        // آیکون‌های SVG
        $svgIcons = [
            'dollar' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M6 6h8a4 4 0 0 1 0 8H6a2 2 0 0 1 0-4h8"/></svg>',
            'appointments' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
            'clock' => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            'xcircle' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
            'warn' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 20h20L12 2z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
            'hourglass' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h14v6c0 2-2 4-4 4l2 2-2 2H7l-2-2 2-2c-2 0-4-2-4-4V4z"/><path d="M12 16v2"/></svg>',
        ];
    @endphp

    <div class="cal-body">
        <!-- ═══════ ستون تقویم ═══════ -->
        <div class="cal-left">
            <div class="stat-grid">
                @foreach ($stats as $s)
                    <div class="stat-card">
                        <div class="stat-top">
                            <span class="stat-title">{{ $s->title }}</span>
                            <span class="stat-ic" style="background:var(--{{ $s->color }}-soft);color:var(--{{ $s->color }})">
                                {!! $svgIcons[$s->icon] ?? '' !!}
                            </span>
                        </div>
                        <div class="stat-val">{{ $s->val }}</div>
                        <div class="stat-sub {{ $s->cls ?? '' }}">{{ $s->sub }}</div>
                    </div>
                @endforeach
            </div>

            <div class="cal-card">
                <div class="cal-scroll">
                    <div class="cal-inner">
                        <!-- هدر پزشکان -->
                        <div class="doc-header">
                            <div class="dh-time">زمان</div>
                            @foreach ($doctors as $doc)
                                <div class="dh-doc">
                                    <span class="dh-avatar" style="background:{{ $doc->color }}">{{ $doc->init }}</span>
                                    <div class="dh-info">
                                        <div class="dh-name">{{ $doc->name }}</div>
                                        <div class="dh-spec">{{ $doc->spec }}</div>
                                    </div>
                                    <span class="dh-count">{{ toFa($doc->count) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- شبکه نوبت‌ها -->
                        <div class="grid-wrap">
                            <!-- ستون زمان -->
                            <div class="time-col">
                                @for ($h = $startHour; $h < $endHour; $h++)
                                    @php
                                        $label = $h < 12 ? toFa($h) . ':۰۰ ص' : ($h == 12 ? '۱۲:۰۰ ظ' : toFa($h - 12) . ':۰۰ ع');
                                    @endphp
                                    <div class="time-cell"><span>{{ $label }}</span></div>
                                @endfor
                            </div>

                            <!-- ستون پزشکان -->
                            @for ($col = 0; $col < count($doctors); $col++)
                                <div class="doc-col">
                                    @for ($h = 0; $h < $endHour - $startHour; $h++)
                                        <div class="hour-line"></div>
                                    @endfor

                                    @php
                                        $colAppts = array_filter($appointments, fn($a) => $a->col === $col);
                                    @endphp
                                    @foreach ($colAppts as $a)
                                        @php
                                            $top = ($a->start - $startHour) * 80;
                                            $height = $a->dur * 80 - 6;
                                        @endphp
                                        <div class="appt {{ $a->c }} {{ $a->selected ? 'selected' : '' }}"
                                            style="top:{{ $top }}px;height:{{ $height }}px">
                                            <div class="appt-top">
                                                <span class="appt-dot" style="background:{{ $a->dot }}">{{ $a->init }}</span>
                                                <span class="appt-name">{{ $a->name }}</span>
                                                @if ($a->vip && $a->dur < 1)
                                                    <span class="appt-tag tag-vip" style="margin:0">VIP</span>
                                                @endif
                                            </div>
                                            @if (!empty($a->treat))
                                                <div class="appt-treat">{{ $a->treat }}</div>
                                            @endif
                                            @if (!empty($a->room))
                                                <div class="appt-room">{{ $a->room }}</div>
                                            @endif
                                            @if ($a->confirm)
                                                <span class="appt-tag tag-confirm">تأییدشده</span>
                                            @endif
                                            @if ($a->vip && $a->dur >= 1)
                                                <span class="appt-tag tag-vip">VIP</span>
                                            @endif
                                        </div>
                                    @endforeach

                                    <!-- خط زمان فعلی -->
                                    <div class="now-line" style="top:{{ ($nowTime - $startHour) * 80 }}px"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══════ ستون کناری ═══════ -->
        <div class="rail">
            <!-- جزئیات نوبت انتخاب‌شده -->
            <div class="rail-card">
                <div class="rail-head">
                    <span class="rail-eyebrow">نوبت انتخاب‌شده</span>
                    <button class="rail-close" aria-label="بستن"><svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg></button>
                </div>
                <div class="sel-pt">
                    <div class="sel-avatar">ا‌د</div>
                    <div class="sel-info">
                        <div class="sel-name-row"><span class="sel-name">اِما دیویس</span><span class="vip-chip">★
                                VIP</span></div>
                        <div class="sel-meta">۴۸ سال · آخرین: ۸ آبان ۱۴۰۳</div>
                        <div class="sel-meta">۰۹۱۲ ۷۷۴ ۲۲۰۱</div>
                    </div>
                </div>
                <div class="det-row"><span class="dl">پزشک</span><span class="dv">دکتر سارا چن</span></div>
                <div class="det-row"><span class="dl">درمان</span><span class="dv">لیزر روسرفیسینگ فرکسل</span></div>
                <div class="det-row"><span class="dl">اتاق</span><span class="dv">سوئیت لیزر</span></div>
                <div class="det-row"><span class="dl">دستگاه</span><span class="dv">فرکسل ۱۵۵۰</span></div>
                <div class="det-row"><span class="dl">زمان</span><span class="dv">۱۰:۳۰ — ۱۲:۰۰</span></div>
                <div class="det-row"><span class="dl">مدت</span><span class="dv">۹۰ دقیقه</span></div>
                <div class="det-row"><span class="dl">مبلغ</span><span class="dv">۱۲۰٬۰۰۰٬۰۰۰ ت</span></div>
                <div class="det-row"><span class="dl">وضعیت</span><span class="dv"><span class="vip-chip">VIP</span></span>
                </div>
                <div class="staff-note">
                    <div class="sn-label">یادداشت پرسنل</div>
                    <div class="sn-text">VIP طلایی — پاس کامل لیزر، کرم بی‌حسی ۴۵ دقیقه قبل از شروع جلسه اعمال شود</div>
                </div>
                <div class="act-row">
                    <button class="act-btn act-green"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>پذیرش</button>
                    <button class="act-btn act-blue"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path
                                d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.4-1.4a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2Z" />
                        </svg>تماس</button>
                    <button class="act-btn act-dark"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>پیام</button>
                </div>
                <div class="act-row2">
                    <button class="act-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8M21 3v5h-5" />
                        </svg>زمان‌بندی</button>
                    <button class="act-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m15 9-6 6M9 9l6 6" />
                        </svg>لغو</button>
                    <button class="act-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>تکمیل</button>
                    <button class="act-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z" />
                        </svg>چاپ</button>
                </div>
            </div>

            <!-- بازه‌های آزاد -->
            <div class="rail-card">
                <div class="rail-head"><span class="rail-title">بازه‌های آزاد</span><span class="rail-tag">پیشنهاد هوش
                        مصنوعی</span></div>
                @foreach ($freeSlots as $slot)
                    <div class="slot-row">
                        <span class="slot-ic">{!! $svgIcons['clock'] !!}</span>
                        <div class="slot-body">
                            <div class="slot-time">{{ $slot->time }}</div>
                            <div class="slot-doc">{{ $slot->doc }}</div>
                        </div>
                        <span class="slot-pct">{{ $slot->pct }}</span>
                    </div>
                @endforeach
            </div>

            <!-- افزودن سریع -->
            <div class="rail-card">
                <button class="quick-add"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.2" stroke-linecap="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>افزودن سریع نوبت</button>
            </div>

            <!-- وضعیت منابع -->
            <div class="rail-card">
                <div class="rail-head"><span class="rail-title">وضعیت منابع</span></div>
                @foreach ($resources as $res)
                    <div class="res-row">
                        <span class="res-dot {{ $res->status }}"></span>
                        <span class="res-name">{{ $res->name }}</span>
                        <span class="res-status {{ $res->status }}">{{ $res->label }}</span>
                    </div>
                @endforeach
                <div class="sub-label">دستگاه‌ها</div>
                @foreach ($devices as $dev)
                    <div class="dev-card">
                        <div class="dev-top">
                            <span class="dev-name">{{ $dev->name }}</span>
                            <span class="dev-badge {{ $dev->badge }}">{{ $dev->badgeL }}</span>
                        </div>
                        <div class="dev-sub">{{ $dev->sub }}</div>
                        @if ($dev->shots)
                            <div class="dev-shots">
                                <span class="l">شات باقی‌مانده</span>
                                <span class="v">{{ $dev->shots }}</span>
                            </div>
                            <div class="dev-bar">
                                <div class="dev-fill" style="width:{{ $dev->pct }}%"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- لیست انتظار -->
            <div class="rail-card">
                <div class="rail-head"><span class="rail-title">لیست انتظار</span><span
                        class="rail-tag">{{ count($waitList) }} بیمار</span></div>
                @foreach ($waitList as $w)
                    <div class="wait-row">
                        <span class="wait-avatar">{{ $w->init }}</span>
                        <div class="wait-body">
                            <div class="wait-name-row">
                                <span class="wait-name">{{ $w->name }}</span>
                                <span class="prio {{ $w->prio }}">{{ $w->prioL }}</span>
                            </div>
                            <div class="wait-sub">{{ $w->sub }}</div>
                        </div>
                        <button class="wait-btn">زمان‌بندی →</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <button class="fab" aria-label="نوبت جدید">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
            stroke-linecap="round">
            <path d="M12 5v14M5 12h14" />
        </svg>
    </button>
@endsection

@section('js')
    <script>
        // فقط تعامل کلیک روی نوبت‌ها (اختیاری)
        document.addEventListener('DOMContentLoaded', function () {
            const grid = document.querySelector('.grid-wrap');
            if (grid) {
                grid.addEventListener('click', function (e) {
                    const appt = e.target.closest('.appt');
                    if (!appt) return;
                    document.querySelectorAll('.appt').forEach(el => el.classList.remove('selected'));
                    appt.classList.add('selected');
                });
            }
        });
    </script>
@endsection