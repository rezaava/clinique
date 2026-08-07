<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>۴۰۳ | دسترسی محدود</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg-1:#130A08;
    --bg-2:#1E100C;
    --card:#211310;
    --line:#3A211A;
    --ink:#F3ECE9;
    --muted:#B08A7C;
    --alert:#FF6B4A;
    --alert-dim:#5C2E1E;
    --teal:#39C9A2;
  }
  *{box-sizing:border-box;}
  html,body{height:100%;}
  body{
    margin:0;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:
      radial-gradient(900px 500px at 88% -10%, rgba(255,107,74,.10) 0%, transparent 60%),
      radial-gradient(700px 420px at 8% 110%, rgba(57,201,162,.05) 0%, transparent 55%),
      var(--bg-1);
    font-family:'Vazirmatn', sans-serif;
    color:var(--ink);
    padding:24px;
  }

  .chart{
    position:relative;
    width:100%;
    max-width:640px;
    background:linear-gradient(180deg, var(--bg-2), var(--card));
    border-radius:22px;
    border:1px solid var(--line);
    box-shadow:0 40px 80px -30px rgba(0,0,0,.65), inset 0 1px 0 rgba(255,255,255,.03);
    overflow:hidden;
  }

  .chart::before{
    content:"";
    position:absolute;
    inset-inline-start:0;
    top:0;
    bottom:0;
    width:34px;
    background:repeating-linear-gradient(
      to bottom,
      rgba(255,107,74,.16) 0 6px,
      transparent 6px 22px
    );
  }

  .tab{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin:28px 34px 0 34px;
    padding:6px 14px 6px 10px;
    border:1px dashed var(--alert-dim);
    border-radius:999px;
    font-size:12.5px;
    color:var(--alert);
    letter-spacing:.02em;
  }
  .tab .dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--alert);
    box-shadow:0 0 0 4px rgba(255,107,74,.18), 0 0 10px rgba(255,107,74,.6);
    animation: blink 1.4s ease-in-out infinite;
  }
  @keyframes blink{ 0%,100%{opacity:1;} 50%{opacity:.35;} }

  .body-pad{ padding:16px 34px 34px 34px; }

  .monitor{
    width:100%;
    height:190px;
    display:block;
    margin-top:10px;
  }
  .grid-line{ stroke:rgba(255,255,255,.05); stroke-width:1; }

  .barrier{
    fill:none;
    stroke:var(--alert);
    stroke-width:2.5;
    stroke-linecap:round;
    stroke-dasharray:10 6;
    filter:drop-shadow(0 0 6px rgba(255,107,74,.55));
    opacity:0;
    animation: fadeIn .8s ease-out .2s forwards;
  }

  .lock{
    opacity:0;
    transform:scale(.7);
    transform-origin:290px 78px;
    animation: popIn .5s cubic-bezier(.2,1.4,.4,1) .9s forwards;
  }
  .lock rect{ fill:none; stroke:var(--alert); stroke-width:2.5; filter:drop-shadow(0 0 8px rgba(255,107,74,.6)); }
  .lock path{ fill:none; stroke:var(--alert); stroke-width:2.5; stroke-linecap:round; filter:drop-shadow(0 0 8px rgba(255,107,74,.6)); }

  .code-digits{
    font-family:'JetBrains Mono', monospace;
    font-weight:700;
    font-size:60px;
    fill:none;
    stroke:var(--alert);
    stroke-width:1.4;
    opacity:0;
    filter:drop-shadow(0 0 10px rgba(255,107,74,.5));
    animation: fadeIn .8s ease-out 1.3s forwards;
  }
  @keyframes fadeIn{ to{ opacity:1; } }
  @keyframes popIn{ to{ opacity:1; transform:scale(1); } }

  .readout{
    font-family:'JetBrains Mono', monospace;
    font-weight:500;
    font-size:13px;
    color:var(--muted);
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-top:2px;
    direction:ltr;
    letter-spacing:.02em;
  }
  .readout span:last-child{ color:var(--alert); }

  h1{
    font-size:27px;
    font-weight:800;
    margin:26px 0 8px 0;
    line-height:1.5;
    color:#fff;
  }
  p.desc{
    font-size:15.5px;
    color:var(--muted);
    line-height:2;
    margin:0 0 26px 0;
    max-width:46ch;
  }

  .actions{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
  }
  .btn{
    appearance:none;
    border:none;
    cursor:pointer;
    font-family:inherit;
    font-size:14.5px;
    font-weight:600;
    padding:12px 22px;
    border-radius:11px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:transform .15s ease, box-shadow .15s ease, background .15s ease, border-color .15s ease;
  }
  .btn-primary{
    background:var(--alert);
    color:#2A0F08;
  }
  .btn-primary:hover{ transform:translateY(-1px); box-shadow:0 14px 26px -12px rgba(255,107,74,.55); }
  .btn-ghost{
    background:transparent;
    color:var(--ink);
    border:1px solid var(--line);
  }
  .btn-ghost:hover{ background:rgba(255,255,255,.03); border-color:var(--alert-dim); }

  .foot{
    margin-top:26px;
    padding-top:18px;
    border-top:1px dashed var(--line);
    font-size:12.5px;
    color:#7A5347;
    display:flex;
    justify-content:space-between;
    direction:ltr;
    font-family:'JetBrains Mono', monospace;
  }

  @media (prefers-reduced-motion: reduce){
    .barrier, .code-digits{ animation:none; opacity:1; }
    .lock{ animation:none; opacity:1; transform:scale(1); }
    .tab .dot{ animation:none; }
  }

  @media (max-width:520px){
    .chart::before{ display:none; }
    .tab, .body-pad{ margin-inline-start:0; padding-inline-start:20px; padding-inline-end:20px; }
    h1{ font-size:22px; }
    .code-digits{ font-size:42px; }
  }
</style>
</head>
<body>

  <div class="chart">
    <div class="tab"><span class="dot"></span> پرونده بیمار &nbsp;·&nbsp; وضعیت: قفل‌شده</div>

    <div class="body-pad">

      <svg class="monitor" viewBox="0 0 580 190" preserveAspectRatio="none">
        <line class="grid-line" x1="0" y1="40" x2="580" y2="40"></line>
        <line class="grid-line" x1="0" y1="95" x2="580" y2="95"></line>
        <line class="grid-line" x1="0" y1="150" x2="580" y2="150"></line>

        <!-- a barrier line, broken where the lock sits -->
        <path class="barrier" d="M0,95 L245,95"></path>
        <path class="barrier" d="M335,95 L580,95" style="animation-delay:.3s"></path>

        <!-- padlock, blocking the line -->
        <g class="lock">
          <path d="M280,68 a10,10 0 0 1 20,0 v10 h-20 z"></path>
          <rect x="272" y="78" width="36" height="28" rx="4"></rect>
        </g>

        <!-- big literal 403 code -->
        <text x="290" y="152" text-anchor="middle" class="code-digits">403</text>
      </svg>

      <div class="readout">
        <span>ACCESS_DENIED · AUTH_REQUIRED</span>
        <span>LOCKED</span>
      </div>

      <h1>اجازه‌ی دسترسی به این پرونده را ندارید</h1>
      <p class="desc">
        این بخش برای نقش شما محدود شده. اگر فکر می‌کنید این یک اشتباه است،
        با مدیر سیستم تماس بگیرید یا با یک حساب دیگر وارد شوید.
      </p>

      <div class="actions">
        <a href="/" class="btn btn-primary">
          بازگشت به داشبورد
        </a>
        <a href="javascript:history.back()" class="btn btn-ghost">
          صفحه قبل
        </a>
      </div>

      <div class="foot">
        <span>ERR::403</span>
        <span id="ts"></span>
      </div>
    </div>
  </div>

<script>
  document.getElementById('ts').textContent = new Date().toLocaleString('en-GB', {hour12:false});
</script>
</body>
</html>