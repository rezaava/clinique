<aside class="sidebar" id="sidebar">
  <div class="brand">
    <div class="brand-logo">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4"></path>
      </svg>
    </div>
    <span class="brand-name">اوراکلینیک</span>
  </div>

  <nav class="nav" id="nav">
    <div class="nav-label">منوی اصلی</div>
    <a href="{{ route('admin.dashboardAd.index') }}"
      class="nav-item {{ request()->routeIs('admin.dashboardAd.index') ? 'active' : '' }}" aria-current="page">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"></path>
      </svg>
      <span>داشبورد</span>

    </a>
    <a href="{{ route('admin.patientAd.index') }}" class="nav-item {{ request()->routeIs('admin.patientAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
      </svg>
      <span>بیماران</span>

    </a>
    <a href="{{ route('admin.turnAd.index') }}" class="nav-item {{ request()->routeIs('admin.turnAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
        <path d="M16 2v4M8 2v4M3 10h18"></path>
      </svg>
      <span>نوبت‌ها</span>
      <span class="nav-badge">۳</span>
    </a>

    <a href="{{ route('admin.calendarAd.index') }}" class="nav-item {{ request()->routeIs('admin.calendarAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M16 2v4M8 2v4M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"></path>
        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
      </svg>
      <span>تقویم</span>
      <span class="nav-badge">۳</span>
    </a>

    <a href="{{ route('admin.taskAd.index') }}" class="nav-item {{ request()->routeIs('admin.taskAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
        <path d="M9 11l3 3L22 4"></path>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
      </svg>
      <span>مرکز وظایف</span>
      <span class="nav-badge">۸</span>
    </a>
    <a href="{{ route('admin.campaignAd.index') }}" class="nav-item {{ request()->routeIs('admin.campaignAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="m22 2-7 20-4-9-9-4Z"></path>
        <path d="M22 2 11 13"></path>
      </svg>
      <span>کمپین‌ها</span>

    </a>
    <a href="{{ route('admin.warehouseAd.index') }}" class="nav-item {{ request()->routeIs('admin.warehouseAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path
          d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z">
        </path>
        <path d="m3.3 7 8.7 5 8.7-5M12 22V12"></path>
      </svg>
      <span>انبار</span>
      <span class="nav-badge">۲</span>
    </a>
    <a href="{{ route('admin.deviceAd.index') }}" class="nav-item {{ request()->routeIs('admin.deviceAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <rect x="4" y="4" width="16" height="16" rx="2"></rect>
        <rect x="9" y="9" width="6" height="6"></rect>
        <path d="M9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2"></path>
      </svg>
      <span>دستگاه‌ها</span>

    </a>
    <a href="{{ route('admin.financialAd.index') }}" class="nav-item {{ request()->routeIs('admin.financialAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
      </svg>
      <span>مالی</span>

    </a>
    <a href="{{ route('admin.reportAd.index') }}" class="nav-item {{ request()->routeIs('admin.reportAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 3v18h18"></path>
        <path d="M18 17V9M13 17V5M8 17v-3"></path>
      </svg>
      <span>گزارش‌ها</span>

    </a>
    <a href="{{ route('admin.settingAd.index') }}" class="nav-item {{ request()->routeIs('admin.settingAd.index') ? 'active' : '' }}">
      <svg class="ic" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="3"></circle>
        <path
          d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z">
        </path>
      </svg>
      <span>تنظیمات</span>

    </a>
  </nav>

  <div class="sidebar-foot">
    <div class="avatar">ل‌م</div>
    <div class="info">
      <div class="nm">لیلا منصور</div>
      <div class="rl">منشی</div>
    </div>
  </div>
</aside>