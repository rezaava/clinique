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