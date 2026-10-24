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
        <div class="date-nav" data-date="{{ $dateStr }}">
            <button type="button" class="nav-arrow" id="prevDay" aria-label="روز قبل">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6" />
                </svg>
            </button>

            <span class="cur-date" id="currentDate">
                {{ verta($dateStr)->format('l، j F Y') }} </span>

            <button type="button" class="nav-arrow" id="nextDay" aria-label="روز بعد">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </button>
        </div>

        <button type="button" class="btn-today" id="todayBtn" data-date="{{ \Carbon\Carbon::today()->toDateString() }}">
            امروز
        </button>

        <div class="view-switch" id="viewSwitch">
            <button type="button" class="vs-btn">روز</button>
            <button type="button" class="vs-btn active">هفته</button>
            <button type="button" class="vs-btn">ماه</button>
        </div>

        <div class="filters">
            <button type="button" class="filter-btn">
                پزشک
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>

            <button type="button" class="filter-btn">
                درمان
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>

            <button type="button" class="filter-btn">
                اتاق
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>

            <button type="button" class="filter-btn">
                دستگاه
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>
        </div>
    </div>
@endsection

@section('content')
    @php
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
            (object) [
                'name' => 'فرکسل ۱۵۵۰',
                'badge' => 'active',
                'badgeL' => 'فعال',
                'sub' => 'در حال استفاده — دکتر سارا چن',
                'shots' => '۲٬۳۴۰ / ۵٬۰۰۰',
                'pct' => 47,
            ],
            (object) [
                'name' => 'هایدرافیشیال MD',
                'badge' => 'active',
                'badgeL' => 'فعال',
                'sub' => 'در حال استفاده — دکتر اِما تورس',
                'shots' => null,
                'pct' => null,
            ],
            (object) [
                'name' => 'ترماژ FLX',
                'badge' => 'ready',
                'badgeL' => 'آماده',
                'sub' => 'سرویس بعدی: ۶ بهمن',
                'shots' => null,
                'pct' => null,
            ],
            (object) [
                'name' => 'Secret RF',
                'badge' => 'ready',
                'badgeL' => 'آماده',
                'sub' => 'آماده — کاملاً استریل شده',
                'shots' => null,
                'pct' => null,
            ],
        ];

        $startHour = 7;
        $endHour = 20;
        $nowTime = 8;

        $svgIcons = [
            'dollar' =>
                '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M6 6h8a4 4 0 0 1 0 8H6a2 2 0 0 1 0-4h8"/></svg>',
            'appointments' =>
                '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
            'clock' =>
                '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            'xcircle' =>
                '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
            'warn' =>
                '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 20h20L12 2z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
            'hourglass' =>
                '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h14v6c0 2-2 4-4 4l2 2-2 2H7l-2-2 2-2c-2 0-4-2-4-4V4z"/><path d="M12 16v2"/></svg>',
        ];
    @endphp

    <div class="cal-body" id="calendarBody">
        <div class="cal-left">
            <div class="stat-grid" id="calendarStats">
                @foreach ($stats as $s)
                    <div class="stat-card">
                        <div class="stat-top">
                            <span class="stat-title">{{ $s->title }}</span>
                            <span class="stat-ic"
                                style="background:var(--{{ $s->color }}-soft);color:var(--{{ $s->color }})">
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
                        <div class="doc-header" id="doctorHeader">
                            <div class="dh-time">زمان</div>
                            @foreach ($doctors as $doc)
                                <div class="dh-doc">
                                    <span class="dh-avatar"
                                        style="background:{{ $doc->color }}">{{ $doc->init }}</span>
                                    <div class="dh-info">
                                        <div class="dh-name">{{ $doc->name }}</div>
                                        <div class="dh-spec">{{ $doc->spec }}</div>
                                    </div>
                                    <span class="dh-count">{{ $doc->count }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="grid-wrap" id="appointmentGrid">
                            <div class="time-col">
                                @for ($h = $startHour; $h < $endHour; $h++)
                                    @php
                                        $label = $h < 12 ? $h . ':۰۰ ص' : ($h == 12 ? '۱۲:۰۰ ظ' : $h - 12 . ':۰۰ ع');
                                    @endphp
                                    <div class="time-cell"><span>{{ $label }}</span></div>
                                @endfor
                            </div>

                            @for ($col = 0; $col < count($doctors); $col++)
                                <div class="doc-col">
                                    @for ($h = 0; $h < $endHour - $startHour; $h++)
                                        <div class="hour-line"></div>
                                    @endfor

                                    @php
                                        $colAppts = $appointments->filter(fn($a) => $a->col === $col);
                                    @endphp

                                    @foreach ($colAppts as $a)
                                        @php
                                            $top = ($a->start - $startHour) * 80;
                                            $height = $a->dur * 95 - 6;
                                        @endphp

                                        <div class="appt {{ $a->c }} {{ $a->selected ? 'selected' : '' }}"
                                            style="top:{{ $top }}px;height:{{ $height }}px">
                                            <div class="appt-top">
                                                <span class="appt-dot"
                                                    style="background:{{ $a->dot }}">{{ $a->init }}</span>
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

                                    <div class="now-line" style="top:{{ ($nowTime - $startHour) * 80 }}px"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rail">
            <div class="rail-card">
                <div class="rail-head">
                    <span class="rail-eyebrow">نوبت انتخاب‌شده</span>
                    <button class="rail-close" type="button" aria-label="بستن">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="sel-pt">
                    <div class="sel-avatar">ا‌د</div>
                    <div class="sel-info">
                        <div class="sel-name-row">
                            <span class="sel-name">اِما دیویس</span>
                            <span class="vip-chip">★ VIP</span>
                        </div>
                        <div class="sel-meta">۴۸ سال · آخرین: ۸ آبان ۱۴۰۳</div>
                        <div class="sel-meta">۰۹۱۲ ۷۷۴ ۲۲۰۱</div>
                    </div>
                </div>

                <div class="det-row"><span class="dl">پزشک</span><span class="dv">دکتر سارا چن</span></div>
                <div class="det-row"><span class="dl">درمان</span><span class="dv">لیزر روسرفیسینگ فرکسل</span>
                </div>
                <div class="det-row"><span class="dl">اتاق</span><span class="dv">سوئیت لیزر</span></div>
                <div class="det-row"><span class="dl">دستگاه</span><span class="dv">فرکسل ۱۵۵۰</span></div>
                <div class="det-row"><span class="dl">زمان</span><span class="dv">۱۰:۳۰ — ۱۲:۰۰</span></div>
                <div class="det-row"><span class="dl">مدت</span><span class="dv">۹۰ دقیقه</span></div>
                <div class="det-row"><span class="dl">مبلغ</span><span class="dv">۱۲۰٬۰۰۰٬۰۰۰ ت</span></div>
                <div class="det-row"><span class="dl">وضعیت</span><span class="dv"><span
                            class="vip-chip">VIP</span></span></div>

                <div class="staff-note">
                    <div class="sn-label">یادداشت پرسنل</div>
                    <div class="sn-text">VIP طلایی — پاس کامل لیزر، کرم بی‌حسی ۴۵ دقیقه قبل از شروع جلسه اعمال شود</div>
                </div>

                <div class="act-row">
                    <button class="act-btn act-green" type="button">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        پذیرش
                    </button>

                    <button class="act-btn act-blue" type="button">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <path
                                d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.4-1.4a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2Z" />
                        </svg>
                        تماس
                    </button>

                    <button class="act-btn act-dark" type="button">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                        پیام
                    </button>
                </div>

                <div class="act-row2">
                    <button class="act-sm" type="button">زمان‌بندی</button>
                    <button class="act-sm" type="button">لغو</button>
                    <button class="act-sm" type="button">تکمیل</button>
                    <button class="act-sm" type="button">چاپ</button>
                </div>
            </div>

            <div class="rail-card">
                <div class="rail-head">
                    <span class="rail-title">بازه‌های آزاد</span>
                    <span class="rail-tag">پیشنهاد هوش مصنوعی</span>
                </div>

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

            <div class="rail-card">
                <button class="quick-add" type="button">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.2" stroke-linecap="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    افزودن سریع نوبت
                </button>
            </div>

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

            <div class="rail-card">
                <div class="rail-head">
                    <span class="rail-title">لیست انتظار</span>
                    <span class="rail-tag">{{ count($waitList) }} بیمار</span>
                </div>

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
                        <button class="wait-btn" type="button">زمان‌بندی →</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <button class="fab" type="button" aria-label="نوبت جدید">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
            stroke-linecap="round">
            <path d="M12 5v14M5 12h14" />
        </svg>
    </button>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateNav = document.querySelector('.date-nav');
            const dateLabel = document.getElementById('currentDate');
            const prevButton = document.getElementById('prevDay');
            const nextButton = document.getElementById('nextDay');
            const todayButton = document.getElementById('todayBtn');

            let currentDate = dateNav.dataset.date;
            let loading = false;

            function addDays(dateString, days) {
                const date = new Date(dateString + 'T12:00:00');
                date.setDate(date.getDate() + days);

                return [
                    date.getFullYear(),
                    String(date.getMonth() + 1).padStart(2, '0'),
                    String(date.getDate()).padStart(2, '0')
                ].join('-');
            }

            function loadCalendar(date) {
                if (loading) return;

                loading = true;
                prevButton.disabled = true;
                nextButton.disabled = true;
                todayButton.disabled = true;

                const url = new URL(@json(route('employee.calendar.index')), window.location.origin);
                url.searchParams.set('date', date);

                fetch(url.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('خطا در دریافت اطلاعات تقویم');
                        }

                        return response.json();
                    })
                    .then(result => {
                        currentDate = result.date || date;
                        dateNav.dataset.date = currentDate;

                        if (result.dateFormatted) {
                            dateLabel.textContent = result.dateFormatted;
                        }
                        updateStats(result.stats || []);
                        updateDoctors(result.doctors || []);
                        updateAppointments(result.appointments || []);
                        updateWaitList(result.waitList || []);

                        const newUrl = new URL(window.location.href);
                        newUrl.searchParams.set('date', currentDate);
                        window.history.replaceState({}, '', newUrl);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('دریافت اطلاعات تقویم ناموفق بود.');
                    })
                    .finally(() => {
                        loading = false;
                        prevButton.disabled = false;
                        nextButton.disabled = false;
                        todayButton.disabled = false;
                    });
            }

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function(char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    } [char];
                });
            }

            function updateStats(stats) {
                const container = document.getElementById('calendarStats');
                if (!container || !stats.length) return;

                container.innerHTML = stats.map(stat => `
                    <div class="stat-card">
                        <div class="stat-top">
                            <span class="stat-title">${escapeHtml(stat.title)}</span>
                            <span class="stat-ic" style="background:var(--${escapeHtml(stat.color)}-soft);color:var(--${escapeHtml(stat.color)})">
                                ${stat.iconHtml || ''}
                            </span>
                        </div>
                        <div class="stat-val">${escapeHtml(stat.val)}</div>
                        <div class="stat-sub ${escapeHtml(stat.cls || '')}">${escapeHtml(stat.sub)}</div>
                    </div>
                `).join('');
            }

            function updateDoctors(doctors) {
                const header = document.getElementById('doctorHeader');
                const grid = document.getElementById('appointmentGrid');
                if (!header || !grid) return;

                header.innerHTML = `
                    <div class="dh-time">زمان</div>
                    ${doctors.map(doc => `
                                <div class="dh-doc">
                                    <span class="dh-avatar" style="background:${escapeHtml(doc.color)}">${escapeHtml(doc.init)}</span>
                                    <div class="dh-info">
                                        <div class="dh-name">${escapeHtml(doc.name)}</div>
                                        <div class="dh-spec">${escapeHtml(doc.spec)}</div>
                                    </div>
                                    <span class="dh-count">${escapeHtml(doc.count)}</span>
                                </div>
                            `).join('')}
                `;

                renderAppointmentGrid(doctors, []);
            }

            function updateAppointments(appointments) {
                const grid = document.getElementById('appointmentGrid');
                if (!grid) return;

                const doctors = Array.from(document.querySelectorAll('#doctorHeader .dh-doc')).map((doc, index) =>
                    ({
                        index
                    }));

                renderAppointmentGrid(doctors, appointments);
            }

            function renderAppointmentGrid(doctors, appointments) {
                const grid = document.getElementById('appointmentGrid');
                if (!grid) return;

                const startHour = 7;
                const endHour = 20;

                let html = '<div class="time-col">';

                for (let hour = startHour; hour < endHour; hour++) {
                    let label;

                    if (hour < 12) {
                        label = hour + ':۰۰ ص';
                    } else if (hour === 12) {
                        label = '۱۲:۰۰ ظ';
                    } else {
                        label = (hour - 12) + ':۰۰ ع';
                    }

                    html += `<div class="time-cell"><span>${escapeHtml(label)}</span></div>`;
                }

                html += '</div>';

                doctors.forEach((doc, index) => {
                    html += '<div class="doc-col">';

                    for (let hour = 0; hour < endHour - startHour; hour++) {
                        html += '<div class="hour-line"></div>';
                    }

                    appointments
                        .filter(appt => Number(appt.col) === index)
                        .forEach(appt => {
                            const top = (Number(appt.start) - startHour) * 80;
                            const height = Number(appt.dur) * 95 - 6;

                            html += `
                                <div class="appt ${escapeHtml(appt.c || '')} ${appt.selected ? 'selected' : ''}"
                                    style="top:${top}px;height:${height}px">
                                    <div class="appt-top">
                                        <span class="appt-dot" style="background:${escapeHtml(appt.dot || '')}">${escapeHtml(appt.init || '')}</span>
                                        <span class="appt-name">${escapeHtml(appt.name || '')}</span>
                                        ${appt.vip && Number(appt.dur) < 1 ? '<span class="appt-tag tag-vip" style="margin:0">VIP</span>' : ''}
                                    </div>
                                    ${appt.treat ? `<div class="appt-treat">${escapeHtml(appt.treat)}</div>` : ''}
                                    ${appt.room ? `<div class="appt-room">${escapeHtml(appt.room)}</div>` : ''}
                                    ${appt.confirm ? '<span class="appt-tag tag-confirm">تأییدشده</span>' : ''}
                                    ${appt.vip && Number(appt.dur) >= 1 ? '<span class="appt-tag tag-vip">VIP</span>' : ''}
                                </div>
                            `;
                        });

                    html += '<div class="now-line" style="top:80px"></div>';
                    html += '</div>';
                });

                grid.innerHTML = html;
            }

            function updateWaitList(waitList) {
                const railCards = document.querySelectorAll('.rail .rail-card');
                const waitCard = railCards[railCards.length - 1];
                if (!waitCard) return;

                const title = waitCard.querySelector('.rail-head .rail-title');
                if (!title || title.textContent.trim() !== 'لیست انتظار') return;

                const tag = waitCard.querySelector('.rail-tag');

                if (tag) {
                    tag.textContent = `${waitList.length} بیمار`;
                }

                waitCard.querySelectorAll('.wait-row').forEach(row => row.remove());

                waitList.forEach(item => {
                    waitCard.insertAdjacentHTML('beforeend', `
                        <div class="wait-row">
                            <span class="wait-avatar">${escapeHtml(item.init)}</span>
                            <div class="wait-body">
                                <div class="wait-name-row">
                                    <span class="wait-name">${escapeHtml(item.name)}</span>
                                    <span class="prio ${escapeHtml(item.prio)}">${escapeHtml(item.prioL)}</span>
                                </div>
                                <div class="wait-sub">${escapeHtml(item.sub)}</div>
                            </div>
                            <button class="wait-btn" type="button">زمان‌بندی →</button>
                        </div>
                    `);
                });
            }

            prevButton.addEventListener('click', function() {
                loadCalendar(addDays(currentDate, -1));
            });

            nextButton.addEventListener('click', function() {
                loadCalendar(addDays(currentDate, 1));
            });

            todayButton.addEventListener('click', function() {
                loadCalendar(todayButton.dataset.date);
            });

            document.addEventListener('click', function(event) {
                const appointment = event.target.closest('.appt');
                if (!appointment) return;

                document.querySelectorAll('.appt.selected').forEach(element => {
                    element.classList.remove('selected');
                });

                appointment.classList.add('selected');
            });
        });
    </script>
@endsection
