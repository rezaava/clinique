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

  <!-- کارت‌های آمار -->
  <div class="stat-grid" id="statGrid"></div>

  <!-- مرکز اقدامات -->
  <div class="section-head">
    <h2 class="section-title">مرکز اقدامات امروز</h2>
    <p class="section-desc">
      اقدامات اولویت‌دار برای افزایش درآمد و بازگشت مشتری
    </p>
  </div>
  <div class="action-grid" id="actionGrid"></div>

  <!-- نوبت‌ها + تسک‌ها -->
  <div class="grid-2">
    <div class="panel">
      <div class="panel-head">
        <div>
          <div class="pt">نوبت‌های امروز</div>
          <div class="ps">
            ۱۲ نوبت · ۲ انجام‌شده · ۱ عدم‌حضور · ۳ در انتظار
          </div>
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
          <tbody id="apptBody"></tbody>
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
      <div class="task-list" id="taskList"></div>
    </div>
  </div>

  <!-- انبار + فعالیت -->
  <div class="grid-2-even">
    <div class="panel">
      <div class="panel-head">
        <div>
          <div class="pt">هشدار انبار و دستگاه</div>
          <div class="ps">۵ مورد نیاز به رسیدگی دارد</div>
        </div>
        <a href="#" class="panel-link">مدیریت <span class="chev">‹</span></a>
      </div>
      <div id="alertList"></div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <div>
          <div class="pt">فعالیت‌های اخیر</div>
          <div class="ps">جریان زنده کلینیک</div>
        </div>
        <span class="clinic-status" style="
                    box-shadow: none;
                    padding: 6px 12px;
                    font-size: 0.82rem;
                  "><span class="live-dot"></span>زنده</span>
      </div>
      <div id="activityList"></div>
    </div>
  </div>

  <!-- عملکرد کمپین -->
  <div class="panel campaign-panel">
    <div class="panel-head" style="padding: 0 0 4px">
      <div>
        <div class="pt">عملکرد کمپین‌ها</div>
        <div class="ps">رزروها، نرخ بازگشت و کمپین‌های پیش‌رو</div>
      </div>
      <a href="#" class="panel-link">همه کمپین‌ها <span class="chev">‹</span></a>
    </div>
    <div class="campaign-grid">
      <div class="chart-block">
        <div class="cb-title">رزرو به ازای کمپین</div>
        <div class="bar-chart" id="barChart"></div>
      </div>
      <div class="chart-block">
        <div class="cb-title">
          نرخ بازگشت بیمار <span class="rate">↗ ٪۷۹</span>
        </div>
        <div class="line-chart" id="lineChart"></div>
        <div class="line-x" id="lineX"></div>
      </div>
      <div class="chart-block">
        <div class="cb-title">
          کمپین‌های پیش‌رو
          <a href="#" class="panel-link" style="font-size: 0.8rem">ساخت ↗</a>
        </div>
        <div class="upcoming-list" id="upcomingList"></div>
      </div>
    </div>
  </div>
</main>
@endsection
@section('js')
<script src="{{ asset('js/employee/index.js') }}"></script>
@endsection