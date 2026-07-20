<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>اوراکلینیک — داشبورد منشی</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" />
    <link rel="stylesheet" href="{{ asset('css/employee/employee.css') }} " />
</head>

<body>
    <div class="app">
        <div class="overlay" id="overlay"></div>

        <!-- ═══════════ سایدبار ═══════════ -->
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <div class="brand-logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4" />
                    </svg>
                </div>
                <span class="brand-name">اوراکلینیک</span>
            </div>

            <nav class="nav" id="nav">
                <!-- آیتم‌ها با جاوااسکریپت ساخته می‌شوند -->
            </nav>

            <div class="sidebar-foot">
                <div class="avatar">ل‌م</div>
                <div class="info">
                    <div class="nm">لیلا منصور</div>
                    <div class="rl">منشی</div>
                </div>
            </div>
        </aside>

        <!-- ═══════════ محتوای اصلی ═══════════ -->
        <div class="main">
            <!-- هدر -->
            <header class="header">
                <button class="icon-btn menu-toggle" id="menuToggle" aria-label="منو">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="date">دوشنبه، <span>۱۷ تیر ۱۴۰۵</span></div>
                <div class="search">
                    <span class="s-ic">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </span>
                    <input type="search" placeholder="جستجوی بیمار، نوبت..." aria-label="جستجو" />
                    <span class="kbd">⌘ك</span>
                </div>
                <div class="header-actions">
                    <button class="icon-btn" id="themeBtn" aria-label="تغییر تم">
                        <svg class="ic-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="4" />
                            <path
                                d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M6.3 17.7l-1.4 1.4M19.1 4.9l-1.4 1.4" />
                        </svg>
                        <svg class="ic-moon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="display: none">
                            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                        </svg>
                    </button>
                    <button class="icon-btn" aria-label="اعلان‌ها">
                        <span class="dot"></span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                        </svg>
                    </button>
                    <div class="avatar">ل‌م</div>
                </div>
            </header>

            <!-- بدنه -->
            <main class="page">
                <div class="page-head">
                    <div>
                        <h1 class="greeting">
                            صبح بخیر، لیلا <span class="wave">👋</span>
                        </h1>
                        <p class="subtitle">
                            این‌ها مواردی است که امروز به رسیدگی شما نیاز دارد.
                        </p>
                    </div>
                    <div class="clinic-status">
                        <span class="live-dot"></span>
                        کلینیک باز است · ۸ پزشک حاضر
                    </div>
                </div>

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
        </div>
    </div>
    <script src="{{ asset('js/employee/index.js') }}"></script>
</body>

</html>