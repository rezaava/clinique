      /* ═══════════════ تبدیل ارقام فارسی ═══════════════ */
      const faDigits = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
      const toFa = (s) => String(s).replace(/\d/g, (d) => faDigits[d]);

      /* ═══════════════ آیکون‌ها (SVG) ═══════════════ */
      const icons = {
        dashboard:
          '<path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/>',
        patients:
          '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
        appointments:
          '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        treatments:
          '<path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4"/>',
        followups:
          '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        campaigns: '<path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>',
        inventory:
          '<path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5M12 22V12"/>',
        devices:
          '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><path d="M9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2"/>',
        finance:
          '<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
        reports: '<path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-3"/>',
        settings:
          '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/>',
        activity: '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
        zap: '<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
        clock: '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        star: '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/>',
        refresh:
          '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8M21 3v5h-5M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16M3 21v-5h5"/>',
        wrench:
          '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L2 19l3 3 7.3-7.3a4 4 0 0 0 5.4-5.4l-2.8 2.8-2.4-.6-.6-2.4z"/>',
        warn: '<path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4M12 17h.01"/>',
        dollar:
          '<circle cx="12" cy="12" r="10"/><path d="M12 6v12M15 9.5a2.5 2.5 0 0 0-2.5-1.5h-1a2 2 0 0 0 0 4h1a2 2 0 0 1 0 4h-1a2.5 2.5 0 0 1-2.5-1.5"/>',
        check:
          '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/>',
        userplus:
          '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/>',
        calendar:
          '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        xcircle:
          '<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/>',
        users:
          '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>',
      };
      const svg = (name, w = 20) =>
        `<svg class="ic" width="${w}" height="${w}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${icons[name]}</svg>`;

      /* ═══════════════ داده‌های نمونه ═══════════════ */
      const navItems = [
        { id: "dashboard", label: "داشبورد", active: true },
        { id: "patients", label: "بیماران" },
        { id: "appointments", label: "نوبت‌ها", badge: 3 },
        { id: "treatments", label: "درمان‌ها" },
        { id: "followups", label: "پیگیری‌ها", badge: 7 },
        { id: "campaigns", label: "کمپین‌ها" },
        { id: "inventory", label: "انبار", badge: 2 },
        { id: "devices", label: "دستگاه‌ها" },
        { id: "finance", label: "مالی" },
        { id: "reports", label: "گزارش‌ها" },
        { id: "settings", label: "تنظیمات" },
      ];

      const stats = [
        {
          title: "نوبت‌ها",
          icon: "calendar",
          color: "brand",
          val: "۱۲",
          sub: "↗ ۲+ نسبت به دیروز",
          subCls: "up",
        },
        {
          title: "درآمد امروز",
          icon: "dollar",
          color: "green",
          unit: "درهم",
          val: "۶٬۸۴۰",
          sub: "از هدف ۸٬۵۰۰ درهم",
          subCls: "",
        },
        {
          title: "بیماران منتظر",
          icon: "users",
          color: "amber",
          val: "۳",
          sub: "میانگین انتظار ۸ دقیقه",
          subCls: "",
        },
        {
          title: "عدم‌حضور",
          icon: "xcircle",
          color: "red",
          val: "۱",
          sub: "دینا م. — ۱۳:۳۰",
          subCls: "warn",
        },
        {
          title: "هشدار انبار",
          icon: "warn",
          color: "orange",
          val: "۵",
          sub: "نیاز به اقدام فوری",
          subCls: "alert",
        },
      ];

      const actions = [
        {
          icon: "activity",
          color: "brand",
          count: "۸",
          name: "ترمیم بوتاکس",
          note: "بیماران با موعد در ۲ هفته آینده",
          btn: "تماس با بیماران",
          btnCls: "btn-blue",
        },
        {
          icon: "zap",
          color: "purple",
          count: "۵",
          name: "جلسات لیزر",
          note: "در پروتکل فعال — جلسه عقب‌افتاده",
          btn: "ارسال یادآوری",
          btnCls: "btn-purple",
        },
        {
          icon: "clock",
          color: "orange",
          count: "۲۳",
          name: "غیرفعال +۹۰ روز",
          note: "بدون مراجعه در بیش از ۳ ماه",
          btn: "اجرای کمپین",
          btnCls: "btn-orange",
        },
        {
          icon: "star",
          color: "amber",
          count: "۴",
          name: "پیگیری VIP",
          note: "بیماران ارزشمند در انتظار پذیرش",
          btn: "تماس با بیماران",
          btnCls: "btn-amber",
        },
        {
          icon: "refresh",
          color: "green",
          count: "۳",
          name: "لغوشده — رزرو مجدد",
          note: "لغوهای اخیر در انتظار رزرو دوباره",
          btn: "رزرو نوبت",
          btnCls: "btn-green",
        },
      ];

      const appts = [
        {
          time: "۰۹:۰۰",
          init: "س‌ر",
          name: "سوفیا الرشیدی",
          service: "بوتاکس — پیشانی",
          doctor: "دکتر لیلا ناصر",
          status: "done",
          label: "انجام‌شده",
          action: "مشاهده",
        },
        {
          time: "۰۹:۴۵",
          init: "م‌خ",
          name: "مونا خلیل",
          service: "هایدرافیشیال",
          doctor: "دکتر سارا عثمان",
          status: "done",
          label: "انجام‌شده",
          action: "مشاهده",
        },
        {
          time: "۱۰:۳۰",
          init: "ر‌ع",
          name: "رانیا عزیز",
          service: "لیزر موهای زائد",
          doctor: "دکتر لیلا ناصر",
          status: "progress",
          label: "در حال انجام",
          action: "مشاهده",
        },
        {
          time: "۱۱:۱۵",
          init: "ل‌ح",
          name: "لارا حداد",
          service: "فیلر لب",
          doctor: "دکتر سارا عثمان",
          status: "wait",
          label: "در انتظار",
          action: "فراخوان",
        },
        {
          time: "۱۲:۰۰",
          init: "ن‌ف",
          name: "نادیا فرحت",
          service: "درمان PRP",
          doctor: "دکتر لیلا ناصر",
          status: "confirm",
          label: "تأییدشده",
          action: "پذیرش",
        },
        {
          time: "۱۳:۳۰",
          init: "د‌م",
          name: "دینا مصطفی",
          service: "پیلینگ شیمیایی",
          doctor: "دکتر سارا عثمان",
          status: "noshow",
          label: "عدم‌حضور",
          action: "رزرو مجدد",
        },
        {
          time: "۱۴:۱۵",
          init: "ه‌س",
          name: "هالا سرحان",
          service: "بوتاکس — دور چشم",
          doctor: "دکتر لیلا ناصر",
          status: "confirm",
          label: "تأییدشده",
          action: "پذیرش",
        },
        {
          time: "۱۵:۰۰",
          init: "ی‌خ",
          name: "یاسمین خوری",
          service: "میکرونیدلینگ",
          doctor: "دکتر سارا عثمان",
          status: "confirm",
          label: "تأییدشده",
          action: "پذیرش",
        },
      ];

      const tasks = [
        {
          title: "تأیید نوبت بعدازظهر نادیا فرحت",
          prio: "high",
          prioL: "زیاد",
          time: "۱۱:۰۰",
          owner: "شما",
          done: false,
        },
        {
          title: "ارسال دستورالعمل مراقبت به یاسمین خوری",
          prio: "high",
          prioL: "زیاد",
          time: "۱۲:۰۰",
          owner: "شما",
          done: false,
        },
        {
          title: "پیگیری با دینا مصطفی (عدم‌حضور)",
          prio: "high",
          prioL: "زیاد",
          time: "۱۴:۰۰",
          owner: "شما",
          done: false,
        },
        {
          title: "سفارش مجدد بوتاکس — موجودی زیر حد آستانه",
          prio: "med",
          prioL: "متوسط",
          time: "پایان روز",
          owner: "سارا ک.",
          done: false,
        },
        {
          title: "زمان‌بندی سرویس دستگاه IPL لومنیس",
          prio: "med",
          prioL: "متوسط",
          time: "پایان روز",
          owner: "سارا ک.",
          done: true,
        },
        {
          title: "ارسال ایمیل بازگشت به فهرست غیرفعال ۹۰ روزه",
          prio: "low",
          prioL: "کم",
          time: "فردا",
          owner: "بازاریابی",
          done: false,
        },
      ];

      const alerts = [
        {
          type: "warn",
          color: "amber",
          name: "بوتاکس (آلرگان ۱۰۰ واحد)",
          sub: "۶ واحد باقی‌مانده",
          action: "سفارش مجدد",
        },
        {
          type: "warn",
          color: "amber",
          name: "فیلر هیالورونیک — ۱ میلی‌لیتر",
          sub: "۴ واحد باقی‌مانده",
          action: "سفارش مجدد",
        },
        {
          type: "wrench",
          color: "red",
          name: "IPL لومنیس StarLux",
          sub: "۱۲ روز از موعد گذشته",
          action: "زمان‌بندی",
        },
        {
          type: "zap",
          color: "orange",
          name: "لیزر دیود سوپرانو آیس",
          sub: "۸۷٬۴۰۰ / ۹۰٬۰۰۰ شات",
          action: "بررسی",
        },
        {
          type: "warn",
          color: "amber",
          name: "کرم بی‌حسی EMLA",
          sub: "۸ واحد باقی‌مانده",
          action: "سفارش مجدد",
        },
      ];

      const activities = [
        {
          type: "dollar",
          color: "brand",
          name: "پرداخت دریافت شد — ۹۵۰ درهم",
          sub: "مونا خلیل · هایدرافیشیال",
          time: "۰۹:۵۰",
        },
        {
          type: "wrench",
          color: "orange",
          name: "بازرسی دستگاه انجام شد",
          sub: "سوپرانو آیس — تأیید سلامت",
          time: "۰۹:۱۵",
        },
        {
          type: "check",
          color: "green",
          name: "جلسه سوفیا الرشیدی انجام شد",
          sub: "بوتاکس پیشانی · دکتر لیلا ناصر",
          time: "۰۹:۴۵",
        },
        {
          type: "userplus",
          color: "purple",
          name: "بیمار جدید ثبت شد",
          sub: "جوئل منصور · معرفی‌شده توسط هالا",
          time: "دیروز",
        },
      ];

      const bars = [
        { label: "بوتاکس بهار", value: 38 },
        { label: "لیزر تابستان", value: 54 },
        { label: "VIP گلو", value: 29 },
        { label: "معرفی", value: 40 },
      ];
      const lineData = [58, 62, 55, 68, 72, 74, 80];
      const lineMonths = ["فرو", "ارد", "خرد", "تیر", "مرد", "شهر", "مهر"];

      const upcoming = [
        {
          name: "بازگشت به درخشش سپتامبر",
          sub: "غیرفعال ۹۰ روز · ۱ شهریور",
          status: "draft",
          statusL: "پیش‌نویس",
        },
        {
          name: "ریست پوستی رمضان",
          sub: "بیماران VIP · ۲۸ اسفند",
          status: "scheduled",
          statusL: "زمان‌بندی‌شده",
        },
        {
          name: "معرفی درمان جدید",
          sub: "همه بیماران · ۱۵ مرداد",
          status: "scheduled",
          statusL: "زمان‌بندی‌شده",
        },
      ];

      /* ═══════════════ رندر ═══════════════ */
      // سایدبار
      document.getElementById("nav").innerHTML =
        '<div class="nav-label">منوی اصلی</div>' +
        navItems
          .map(
            (i) => `
    <a href="#" class="nav-item ${i.active ? "active" : ""}" ${i.active ? 'aria-current="page"' : ""}>
      ${svg(i.id)}
      <span>${i.label}</span>
      ${i.badge ? `<span class="nav-badge">${toFa(i.badge)}</span>` : ""}
    </a>`,
          )
          .join("");

      // کارت آمار
      document.getElementById("statGrid").innerHTML = stats
        .map(
          (s) => `
  <div class="stat-card">
    <div class="stat-top">
      <span class="stat-title">${s.title}</span>
      <span class="stat-ic" style="background:var(--${s.color}-soft);color:var(--${s.color})">${svg(s.icon, 20)}</span>
    </div>
    <div class="stat-val">${s.unit ? `<span class="unit">${s.unit}</span>` : ""}${s.val}</div>
    <div class="stat-sub ${s.subCls}">${s.sub}</div>
  </div>`,
        )
        .join("");

      // مرکز اقدامات
      document.getElementById("actionGrid").innerHTML = actions
        .map(
          (a) => `
  <div class="action-card">
    <div class="action-top">
      <span class="action-ic" style="background:var(--${a.color}-soft);color:var(--${a.color})">${svg(a.icon, 22)}</span>
      <span class="action-count">${a.count}</span>
    </div>
    <div class="action-name">${a.name}</div>
    <div class="action-note">${a.note}</div>
    <button class="btn ${a.btnCls}">${a.btn}</button>
  </div>`,
        )
        .join("");

      // جدول نوبت‌ها
      document.getElementById("apptBody").innerHTML = appts
        .map(
          (a) => `
  <tr>
    <td class="t-time">${a.time}</td>
    <td><div class="t-patient"><span class="t-avatar">${a.init}</span><span class="t-name">${a.name}</span></div></td>
    <td>${a.service}</td>
    <td class="t-doctor">${a.doctor}</td>
    <td><span class="badge badge-${a.status}">${a.label}</span></td>
    <td><a href="#" class="t-action">${a.action}</a></td>
  </tr>`,
        )
        .join("");

      // تسک‌ها
      const checkSvg =
        '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>';
      document.getElementById("taskList").innerHTML = tasks
        .map(
          (t, i) => `
  <div class="task ${t.done ? "done" : ""}" data-i="${i}">
    <button class="task-check" aria-label="تکمیل تسک">${checkSvg}</button>
    <div class="task-body">
      <div class="task-title">${t.title}</div>
      <div class="task-meta">
        <span class="prio prio-${t.prio}">${t.prioL}</span>
        <span>· ${t.time}</span>
        <span class="task-owner">${t.owner}</span>
      </div>
    </div>
  </div>`,
        )
        .join("");

      // آلرت‌ها
      document.getElementById("alertList").innerHTML = alerts
        .map(
          (a) => `
  <div class="alert-item">
    <span class="alert-ic" style="background:var(--${a.color}-soft);color:var(--${a.color})">${svg(a.type, 20)}</span>
    <div class="alert-body">
      <div class="alert-name">${a.name}</div>
      <div class="alert-sub">${a.sub}</div>
    </div>
    <a href="#" class="alert-action">${a.action}</a>
  </div>`,
        )
        .join("");

      // فعالیت‌ها
      document.getElementById("activityList").innerHTML = activities
        .map(
          (a) => `
  <div class="activity-item">
    <span class="act-ic" style="background:var(--${a.color}-soft);color:var(--${a.color})">${svg(a.type, 20)}</span>
    <div class="act-body">
      <div class="act-name">${a.name}</div>
      <div class="act-sub">${a.sub}</div>
    </div>
    <span class="act-time">${a.time}</span>
  </div>`,
        )
        .join("");

      // نمودار میله‌ای
      const maxBar = 60;
      document.getElementById("barChart").innerHTML = bars
        .map(
          (b) => `
  <div class="bar-col">
    <div class="bar" style="height:0" data-h="${(b.value / maxBar) * 100}"></div>
    <span class="bar-label">${b.label}</span>
  </div>`,
        )
        .join("");
      // انیمیشن میله‌ها
      requestAnimationFrame(() => {
        document.querySelectorAll(".bar").forEach((bar) => {
          bar.style.height = bar.dataset.h + "%";
        });
      });

      // نمودار خطی (SVG)
      (function () {
        const w = 300,
          h = 160,
          pad = 10;
        const min = 40,
          max = 90;
        const pts = lineData.map((v, i) => {
          const x = pad + (i / (lineData.length - 1)) * (w - pad * 2);
          const y = h - pad - ((v - min) / (max - min)) * (h - pad * 2);
          return [x, y];
        });
        const linePath = pts
          .map(
            (p, i) =>
              (i === 0 ? "M" : "L") + p[0].toFixed(1) + " " + p[1].toFixed(1),
          )
          .join(" ");
        const areaPath =
          linePath +
          ` L${pts[pts.length - 1][0].toFixed(1)} ${h - pad} L${pts[0][0].toFixed(1)} ${h - pad} Z`;
        document.getElementById("lineChart").innerHTML = `
    <svg viewBox="0 0 ${w} ${h}" preserveAspectRatio="none">
      <defs>
        <linearGradient id="lg" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="var(--green)" stop-opacity="0.22"/>
          <stop offset="100%" stop-color="var(--green)" stop-opacity="0"/>
        </linearGradient>
      </defs>
      <path d="${areaPath}" fill="url(#lg)"/>
      <path d="${linePath}" fill="none" stroke="var(--green)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
        stroke-dasharray="1000" stroke-dashoffset="1000">
        <animate attributeName="stroke-dashoffset" from="1000" to="0" dur="1.4s" fill="freeze" calcMode="spline" keySplines="0.16 1 0.3 1" keyTimes="0;1"/>
      </path>
      ${pts.map((p) => `<circle cx="${p[0].toFixed(1)}" cy="${p[1].toFixed(1)}" r="3" fill="var(--surface)" stroke="var(--green)" stroke-width="2"/>`).join("")}
    </svg>`;
        document.getElementById("lineX").innerHTML = lineMonths
          .map((m) => `<span>${m}</span>`)
          .join("");
      })();

      // کمپین‌های پیش‌رو
      document.getElementById("upcomingList").innerHTML = upcoming
        .map(
          (u) => `
  <div class="upcoming-item">
    <span class="up-ic">${svg("campaigns", 18)}</span>
    <div class="up-body">
      <div class="up-name">${u.name}</div>
      <div class="up-sub">${u.sub}</div>
    </div>
    <span class="up-status up-${u.status}">${u.statusL}</span>
  </div>`,
        )
        .join("");

      /* ═══════════════ تعامل‌ها ═══════════════ */
      // تیک زدن تسک‌ها
      document.getElementById("taskList").addEventListener("click", (e) => {
        const check = e.target.closest(".task-check");
        if (check) check.closest(".task").classList.toggle("done");
      });

      // دارک‌مود
      const html = document.documentElement;
      const themeBtn = document.getElementById("themeBtn");
      const sun = themeBtn.querySelector(".ic-sun");
      const moon = themeBtn.querySelector(".ic-moon");
      let theme = "light";
      function applyTheme(t) {
        theme = t;
        html.setAttribute("data-theme", t);
        sun.style.display = t === "dark" ? "none" : "block";
        moon.style.display = t === "dark" ? "block" : "none";
      }
      // تشخیص ترجیح سیستم در بار اول
      applyTheme(
        window.matchMedia("(prefers-color-scheme: dark)").matches
          ? "dark"
          : "light",
      );
      themeBtn.addEventListener("click", () =>
        applyTheme(theme === "light" ? "dark" : "light"),
      );

      // منوی موبایل
      const menuToggle = document.getElementById("menuToggle");
      const overlay = document.getElementById("overlay");
      menuToggle.addEventListener("click", () =>
        html.classList.toggle("nav-open"),
      );
      overlay.addEventListener("click", () =>
        html.classList.remove("nav-open"),
      );
      document
        .querySelectorAll(".nav-item")
        .forEach((n) =>
          n.addEventListener("click", () => html.classList.remove("nav-open")),
        );