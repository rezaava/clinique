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


