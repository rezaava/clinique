@extends('layout.master')

@section('title')
اوراکلینیک — رزرو هوشمند نوبت
@endsection

@section('head')
<link rel="stylesheet" href="{{ asset('css/patient/booking.css') }}">
@endsection

@section('content')
    <div class="book-wrap">
      <!-- ═══════ ستون اصلی ═══════ -->
      <div class="book-main">

        <!-- عنوان صفحه -->
        <div class="page-head">
          <div>
            <nav class="breadcrumb"><a href="#">نوبت‌ها</a><span>›</span><span class="current">رزرو جدید</span></nav>
            <h1 class="page-title">رزرو هوشمند نوبت</h1>
          </div>
          <div class="page-head-right">
            <span class="ai-active">توصیه‌های هوش مصنوعی فعال</span>
            <span class="date-pill"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>سه‌شنبه، ۳۱ تیر ۱۴۰۴</span>
          </div>
        </div>

        <!-- بیمار + هشدارها -->
        <div class="grid-16">
          <div class="card card-pad">
            <div class="pt-top">
              <div class="pt-avatar-wrap"><div class="pt-avatar"></div><span class="pt-vip">VIP</span></div>
              <div class="pt-body">
                <div class="pt-name-row">
                  <span class="pt-name">سوفیا اندرسن</span>
                  <span class="chip chip-active">فعال</span>
                </div>
                <div class="pt-meta">۳۴ سال · خانم · ۰۹۱۲ ۸۹۱ ۰۰۳۲</div>
              </div>
              <div class="pt-health">
                <svg class="ring" viewBox="0 0 44 44">
                  <circle cx="22" cy="22" r="19" fill="none" stroke="var(--surface-2)" stroke-width="4"/>
                  <circle cx="22" cy="22" r="19" fill="none" stroke="var(--green)" stroke-width="4" stroke-linecap="round" stroke-dasharray="119.4" stroke-dashoffset="15.5" transform="rotate(-90 22 22)"/>
                  <text x="22" y="26" text-anchor="middle" font-size="12" font-weight="700" fill="var(--text)">۸۷</text>
                </svg>
                <div class="hl">امتیاز سلامت</div>
              </div>
            </div>
            <div class="pt-info-grid">
              <div class="pt-info-box"><div class="l">پزشک مسئول</div><div class="v">دکتر جیمز میچل</div></div>
              <div class="pt-info-box"><div class="l">مشتری از</div><div class="v">اسفند ۱۳۹۹</div></div>
              <div class="pt-info-box"><div class="l">آخرین مراجعه</div><div class="v">۲۸ خرداد ۱۴۰۴</div></div>
              <div class="pt-info-box"><div class="l">بدهی معوق</div><div class="v red">۲۴٬۰۰۰٬۰۰۰ ت</div></div>
            </div>
            <div class="pt-foot">
              <button class="pbtn solid-blue"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>مشاهده پروفایل</button>
              <button class="pbtn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.6A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.4-1.4a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2Z"/></svg>تماس</button>
              <button class="pbtn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>پیام</button>
              <span class="pt-ltv"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 7 13.5 15.5l-5-5L2 17"/><path d="M16 7h6v6"/></svg>۱۲ مراجعه · <b>۸۴۲ م ت</b> ارزش کل عمر</span>
            </div>
          </div>

          <div class="card card-pad">
            <div class="alerts-head"><span class="t">هشدارهای بیمار</span><span class="alerts-count">۵ فعال</span></div>
            <div id="alerts"></div>
          </div>
        </div>

        <!-- رزرو نوبت + پنل AI -->
        <div class="grid-16">
          <div class="card card-pad">
            <div class="list-title" style="margin-bottom:4px">رزرو نوبت</div>
            <div class="section-label">نوع نوبت</div>
            <div class="type-grid" id="typeGrid"></div>

            <div class="select-grid" style="margin-top:20px">
              <div class="select-col">
                <div class="section-label">پزشک</div>
                <div class="sc-items" id="doctorList"></div>
              </div>
              <div class="select-col">
                <div class="section-label">اتاق</div>
                <div class="sc-items" id="roomList"></div>
              </div>
              <div class="select-col">
                <div class="section-label">دستگاه</div>
                <div class="sc-items" id="deviceList"></div>
              </div>
            </div>

            <div class="section-label">درمان</div>
            <div class="chip-row" id="servicesContainer">
                @foreach ($services as $service)
                    <label class="tchip {{ $loop->first ? 'active' : '' }}">
                        <input type="radio" name="service_id" value="{{ $service->id }}" {{ $loop->first ? 'checked' : '' }} hidden>
                        {{ $service->name }}
                    </label>
                @endforeach
            </div>
            <div class="dt-grid" style="margin-top:22px">
              <div class="cal">
                <div class="section-label" style="margin-top:0">تاریخ — تیر ۱۴۰۴</div>
                <div class="cal-head" id="calHead"></div>
                <div class="cal-grid" id="calGrid"></div>
                <div class="cal-legend"><span class="leg open">آزاد</span><span class="leg busy">پُر</span><span class="leg sel">انتخاب‌شده</span></div>
              </div>
              <div class="slot-col">
                <div class="section-label" style="margin-top:0">بازه زمانی — ۳۱ تیر</div>
                <div class="slots" id="slots"></div>
                <div class="slot-legend"><span class="leg free">آزاد</span><span class="leg booked">رزرو‌شده</span><span class="leg sel">انتخاب‌شده</span></div>
              </div>
            </div>

            <div class="dur-grid">
              <div class="dur-box"><div class="l">مدت زمان</div><div class="v">۴۵ <span class="u">دقیقه</span></div><div class="s">پایان ۱۰:۴۵</div></div>
              <div class="dur-box"><div class="l">قیمت تخمینی</div><div class="v">۵۸٬۰۰۰٬۰۰۰ ت</div><div class="s green">واجد شرایط پکیج</div></div>
              <div class="dur-box"><div class="l">بیمه</div><div class="v" style="font-size:1rem">بیمه تکمیلی</div><div class="s">زیبایی — پوشش ندارد</div></div>
            </div>

            <div class="notes-area">
              <div class="section-label" style="margin-top:0">یادداشت داخلی</div>
              <textarea placeholder="یادداشتی که فقط برای تیم کلینیک قابل مشاهده است..."></textarea>
            </div>

            <button class="book-btn"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>رزرو نوبت — ۳۱ تیر، ساعت ۱۰:۰۰<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7M19 12H5"/></svg></button>
          </div>

          <div class="book-rail-inner" style="display:flex;flex-direction:column;gap:var(--gap)">
            <div class="card card-pad ai-panel">
              <div class="ai-head">
                <div class="ai-head-ic"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8M4 8h4v4M12 16v4h4M20 16h-4v-4"/><rect x="8" y="8" width="8" height="8" rx="1"/></svg></div>
                <div><div class="at">توصیه هوش مصنوعی</div><div class="as">تحلیل ۱۸ ماه سابقه بیمار</div></div>
              </div>
              <div class="ai-row"><span class="arl">پزشک پیشنهادی</span><div class="arr"><div class="arv">دکتر جیمز میچل</div><div class="ars">۹۴٪ تطابق</div></div></div>
              <div class="ai-row"><span class="arl">تاریخ بهینه</span><div class="arr"><div class="arv" style="color:var(--text)">پنجشنبه، ۳۱ تیر</div><div class="ars">بازه ترجیحی تاریخی</div></div></div>
              <div class="ai-row"><span class="arl">درمان پیشنهادی</span><div class="arr"><div class="arv">بوتاکس + کمبو لب</div><div class="ars">پکیج ترکیبی</div></div></div>
              <div class="ai-row"><span class="arl">درآمد تخمینی</span><div class="arr"><div class="arv green">۹۲٬۰۰۰٬۰۰۰ ت</div><div class="ars">در برابر ۵۸ م تک‌سرویس — ۳۴ م+</div></div></div>
              <div class="ai-row"><span class="arl">احتمال بازگشت</span><div class="arr"><div class="arv">۹۱٪</div><div class="ars">بالا با درمان ترکیبی</div></div></div>
              <div class="ai-row" style="border-bottom:none"><span class="arl">فرصت فروش مکمل</span><div class="arr"><div class="arv" style="color:var(--gold)">پکیج گلو</div><div class="ars">۳۴ م+ · احتمال بالا</div></div></div>
              <div class="ai-bundle">
                <span class="ai-bundle-ic"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4"/></svg></span>
                <div><div class="ai-bundle-t">باندل تازه‌سازی گلو</div><div class="ai-bundle-d">بوتاکس ۲۰ واحد + فیلر لب ۰.۵ میلی‌لیتر + فتوتراپی LED. سوفیا در بهار ۱۴۰۴ به درمان‌های ترکیبی ۸۷٪ بهتر پاسخ داد.</div></div>
              </div>
              <button class="ai-accept"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/></svg>پذیرش توصیه</button>
            </div>

            <div class="card card-pad">
              <div class="pay-title">پیش‌نمایش پرداخت</div>
              <div class="pay-line"><span class="pl">قیمت خدمت</span><span class="pv">۵۸٬۰۰۰٬۰۰۰ ت</span></div>
              <div class="pay-line"><span class="pl">تخفیف وفاداری (۱۰٪)</span><span class="pv green">−۵٬۸۰۰٬۰۰۰ ت</span></div>
              <div class="pay-line"><span class="pl">اعتبار پکیج</span><span class="pv muted">−۰ ت</span></div>
              <div class="pay-line"><span class="pl">بیعانه لازم</span><span class="pv">۱۵٬۰۰۰٬۰۰۰ ت</span></div>
              <div class="pay-total"><span class="l">مانده حساب</span><span class="v">۳۷٬۲۰۰٬۰۰۰ ت</span></div>
              <div class="pay-warn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>بیمار ۲۴ میلیون تومان بدهی معوق دارد — قبل از رزرو دریافت شود</div>
            </div>
          </div>
        </div>

        <!-- اشغال پزشک + دستگاه -->
        <div class="grid-16">
          <div class="card card-pad">
            <div class="avail-head">
              <div><div class="avail-title">اشغال پزشکان</div><div class="avail-sub">۳۱ تیر ۱۴۰۴ · ۰۹:۰۰ تا ۱۷:۰۰</div></div>
              <div class="avail-legend"><span class="leg open">آزاد</span><span class="leg booked">رزرو‌شده</span><span class="leg sel">انتخاب‌شده</span></div>
            </div>
            <div class="sched-scroll">
              <div class="sched">
                <div class="sched-times" id="schedTimes"></div>
                <div id="doctorSched"></div>
                <div class="room-label">اشغال اتاق‌ها</div>
                <div id="roomSched"></div>
              </div>
            </div>
          </div>

          <div class="card card-pad">
            <div class="list-title">اشغال دستگاه‌ها</div>
            <div id="deviceAvail"></div>
          </div>
        </div>

        <!-- سه لیست تاریخچه -->
        <div class="grid-3">
          <div class="card card-pad">
            <div class="list-title">نوبت‌های اخیر</div>
            <div id="recentAppts"></div>
          </div>
          <div class="card card-pad">
            <div class="list-title">تاریخچه درمان</div>
            <div id="treatHistory"></div>
          </div>
          <div class="card card-pad">
            <div class="list-title">تاریخچه کمپین</div>
            <div id="campHistory"></div>
          </div>
        </div>
      </div>

      <!-- ═══════ ستون راست ثابت ═══════ -->
      <div class="book-rail">
        <div class="rail-card">
          <div class="rail-head"><span class="rail-title">برنامه امروز</span><span class="rail-count">۶ نوبت</span></div>
          <div id="todaySchedule"></div>
        </div>
        <div class="rail-card">
          <div class="rail-head"><span class="rail-title">هفته پیش‌رو</span></div>
          <div id="weekAhead"></div>
        </div>
        <div class="rail-card">
          <div class="rail-head"><span class="rail-title">اقدامات سریع</span></div>
          <div id="quickActions"></div>
        </div>
      </div>
    </div>

@endsection

@section('js')
<script src="{{ asset('js/clent/booking.js') }}"></script>
@endsection