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
    <div class="cal-body">
        <!-- ═══════ ستون تقویم ═══════ -->
        <div class="cal-left">
            <div class="stat-grid" id="statGrid"></div>

            <div class="cal-card">
                <div class="cal-scroll">
                    <div class="cal-inner">
                        <div class="doc-header" id="docHeader"></div>
                        <div class="grid-wrap" id="gridWrap"></div>
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
                <div id="freeSlots"></div>
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
                <div id="resources"></div>
                <div class="sub-label">دستگاه‌ها</div>
                <div id="devices"></div>
            </div>

            <!-- لیست انتظار -->
            <div class="rail-card">
                <div class="rail-head"><span class="rail-title">لیست انتظار</span><span class="rail-tag">۳ بیمار</span>
                </div>
                <div id="waitList"></div>
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
    <script src="{{ asset('js/employee/calendar.js') }}"></script>
@endsection