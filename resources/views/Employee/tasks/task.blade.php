@extends('layout.master')

@section('title')
اوراکلینیک — مرکز وظایف منشی
@endsection

@section('name-page')
مرکز وظایف
@endsection

@section('head')
<link rel="stylesheet" href="{{ asset('jpd-datepiker/jpd.css') }}">

<style>
    :root {
        --jdp-primary: #6d4aff;
        --jdp-primary-soft: #f1edff;
        --jdp-radius: 14px;
        --jdp-day-radius: 9px;
        --jdp-text: #2b2b38;
        --jdp-muted: #9a9aa8;
        --jdp-width: 250px;
    }

    /* --------------------------------------------------------
       باکس اینپوت تاریخ — همه چیز حالا نسبت به همین باکس
       جانمایی می‌شود، نه با اعداد ثابت روی صفحه
       -------------------------------------------------------- */
    .date-input-wrap {
        position: relative;
    }

    .date-input-wrap #jalaliDateInput {
        padding-inline-end: 38px;
        width: 100%;
    }

    .icon-date {
        position: absolute;
        inset-inline-end: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--jdp-primary);
        cursor: pointer;
        font-size: 1.1rem;
        margin: 0;
    }

    /* =========================================================
     استایل و اندازه‌ی جعبه‌ی تقویم (jdp-container)
     موقعیت (top/left) دیگر با CSS ثابت نیست و توسط جاوااسکریپت
     نسبت به موقعیت واقعی اینپوت روی هر سایز صفحه محاسبه می‌شود
     ========================================================= */
    jdp-container {
        background: var(--bg);
        font-family: iransans !important;
        border-radius: var(--jdp-radius) !important;
        box-shadow: 0 18px 40px rgba(30, 20, 80, .25) !important;
        padding: .6rem .5rem !important;
        z-index: 1090 !important;
        position: fixed !important;
        max-width: min(var(--jdp-width), calc(100vw - 20px)) !important;
        min-width: min(var(--jdp-width), calc(100vw - 20px)) !important;
        font-size: 88% !important;
    }

    jdp-container .jdp-months,
    jdp-container .jdp-years {
        color: var(--jdp-text) !important;
        font-weight: 700;
        font-size: 100% !important;
    }

    jdp-container .jdp-icon-plus,
    jdp-container .jdp-icon-minus {
        border: none !important;
        background: var(--surface);
        border-radius: 8px !important;
    }

    jdp-container .jdp-icon-plus svg,
    jdp-container .jdp-icon-minus svg {
        fill: var(--jdp-primary);
        height: 1.15rem !important;
        width: 1.15rem !important;
        padding: .2rem !important;
    }

    /* نام روزهای هفته */
    jdp-container .jdp-day-name {
        background: transparent !important;
        color: var(--jdp-muted) !important;
        font-weight: 700 !important;
        font-size: 80% !important;
        height: 24px !important;
        line-height: 24px !important;
    }



    /* هر خانه‌ی روز - کوچیک‌تر از حالت پیش‌فرض */
    jdp-container .jdp-day {
        border-radius: var(--jdp-day-radius) !important;
        font-weight: 500;
        height: 27px !important;
        line-height: 27px !important;
        margin: 1px 0 !important;
        color: var(--text)!important;
    }

    jdp-container .jdp-day-name.holly-day, jdp-container .jdp-day-name.last-week, jdp-container .jdp-day.holly-day, jdp-container .jdp-day.last-week {
        color: var( --red) !important;
    }

    jdp-container .jdp-day.today {
        background-color: var(--jdp-primary) !important;
        color: var(--jdp-primary-soft) !important;
        border: none !important;
        font-weight: 700;
    }

    jdp-container .jdp-day.today:hover {
        background-color: #4a1ff5 !important;
        color: var(--jdp-primary-soft) !important;
    }

    jdp-container .jdp-day:not(.disabled-day):hover {
        transform: scale(1.01) !important;
        background: var(--surface) !important;
        color: var( --jdp-primary) !important;
    }

    jdp-container .jdp-day.selected {
        background-color: var(--jdp -primary) !important;
    }

    jdp-container .jdp-day.not-in-month {
        visibility: hidden !important;
        pointer-events: none !important;
    }

    jdp-container .jdp-footer {
        padding: .4rem .4rem 0 !important;
    }

    jdp-container .jdp-btn-today,
    jdp-container .jdp-btn-empty {
        background: var(--jdp-primary) !important;
        border-radius: 8px !important;
        font-weight: 600;
        font-size: 90% !important;
    }

    jdp-container .jdp-btn-empty {
        background: var(--surface) !important;
        color: var(--jdp-primary) !important;
    }

    jdp-container .jdp-year select,
    jdp-container .jdp-month select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: none;
    }

    jdp-container .jdp-month,
    jdp-container .jdp-month input,
    jdp-container .jdp-month select,
    jdp-container .jdp-year,
    jdp-container .jdp-year input,
    jdp-container .jdp-year select {
        border-radius: 8px !important;
        background: var(--surface);
        color: var(--text);
    }

    .topbar {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 40;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 20px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 1.3rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .hub-badge {
        background: var(--brand-soft);
        color: var(--brand);
        font-size: .78rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .top-date {
        color: var(--text-3);
        font-size: .86rem;
        white-space: nowrap;
        border-inline-start: 1px solid var(--border);
        padding-inline-start: 14px;
    }

    .search {
        flex: 1;
        max-width: 340px;
        position: relative;
    }

    .search input {
        width: 100%;
        height: 38px;
        border-radius: var(--r-md);
        background: var(--surface-2);
        border: 1px solid var(--border);
        padding: 0 38px 0 14px;
        font-family: inherit;
        font-size: .88rem;
        color: var(--text);
    }

    .search input:focus {
        border-color: var(--brand);
        background: var(--surface);
        outline: none;
    }

    .search input::placeholder {
        color: var(--text-3);
    }

    .search .s-ic {
        position: absolute;
        inset-inline-start: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-3);
        pointer-events: none;
    }

    .top-actions {
        display: flex;
        gap: 8px;
        margin-inline-start: auto;
        flex-wrap: wrap;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: var(--r-md);
        border: 1px solid var(--border);
        font-size: .85rem;
        font-weight: 500;
        color: var(--text-2);
        transition: all .18s ease;
        white-space: nowrap;
    }

    .filter-btn:hover {
        border-color: var(--border-strong);
        color: var(--text);
        background: var(--surface-2);
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--brand);
        color: #fff;
        padding: 9px 17px;
        border-radius: var(--r-md);
        font-weight: 600;
        font-size: .88rem;
        transition: filter .18s ease;
        white-space: nowrap;
    }

    .btn-add:hover {
        filter: brightness(1.08);
    }

    .icon-btn {
        width: 38px;
        height: 38px;
        border-radius: var(--r-md);
        background: var(--surface-2);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
        color: var(--text-2);
        transition: all .18s ease;
    }

    .icon-btn:hover {
        background: var(--surface);
        color: var(--text);
    }

    .body-grid {
        display: grid;
        grid-template-columns: 1fr var(--rail-w);
        gap: var(--gap);
        padding: 20px;
        align-items: start;
    }

    .tc-main {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 26px;
    }

    .sec-head {
        margin-bottom: 14px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 14px;
        flex-wrap: wrap;
    }

    .sec-title {
        font-size: 1.08rem;
        font-weight: 700;
    }

    .sec-sub {
        font-size: .84rem;
        color: var(--text-3);
        margin-top: 1px;
    }

    .sec-link {
        color: var(--brand);
        font-weight: 600;
        font-size: .86rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* کارت آمار */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 18px;
        box-shadow: var(--shadow-sm);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .stat-ic {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
    }

    .stat-delta {
        font-size: .78rem;
        font-weight: 600;
        color: var(--green);
    }

    .stat-val {
        font-size: 1.65rem;
        font-weight: 700;
        letter-spacing: -.02em;
        line-height: 1.1;
    }

    .stat-sub {
        font-size: .8rem;
        color: var(--text-3);
        margin-top: 3px;
    }

    .stat-label {
        font-size: .7rem;
        font-weight: 700;
        color: var(--text-3);
        letter-spacing: .05em;
        margin-top: 12px;
        padding-top: 11px;
        border-top: 1px solid var(--border);
    }

    /* کانبان */
    .kanban {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        align-items: start;
    }

    .kcol {
        min-width: 0;
    }

    .kcol-head {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 11px 14px;
        border-radius: var(--r-md);
        font-weight: 700;
        font-size: .9rem;
        margin-bottom: 12px;
    }

    .kcol-head::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
        flex-shrink: 0;
    }

    .kcol-count {
        margin-inline-start: auto;
        font-size: .84rem;
        font-weight: 700;
    }

    .k-critical {
        background: var(--red-soft);
        color: var(--red);
    }

    .k-high {
        background: var(--amber-soft);
        color: var(--amber);
    }

    .k-normal {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .k-done {
        background: var(--green-soft);
        color: var(--green);
    }

    .task-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-md);
        padding: 14px;
        margin-bottom: 12px;
        box-shadow: var(--shadow-sm);
        transition: transform .18s ease, box-shadow .18s ease;
        cursor: grab;
    }

    .task-card:last-child {
        margin-bottom: 0;
    }

    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .tc-top {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 11px;
        flex-wrap: wrap;
    }

    .tc-prio {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .7rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
    }

    .tc-prio::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .p-critical {
        background: var(--red-soft);
        color: var(--red);
    }

    .p-high {
        background: var(--amber-soft);
        color: var(--amber);
    }

    .p-normal {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .p-done {
        background: var(--green-soft);
        color: var(--green);
    }

    .tc-cat {
        font-size: .76rem;
        color: var(--text-3);
    }

    .tc-time {
        margin-inline-start: auto;
        font-size: .74rem;
        color: var(--text-3);
        font-variant-numeric: tabular-nums;
    }

    .tc-body {
        display: flex;
        gap: 10px;
        margin-bottom: 11px;
    }

    .tc-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        color: #fff;
        display: grid;
        place-items: center;
        font-size: .68rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .tc-info {
        flex: 1;
        min-width: 0;
    }

    .tc-name {
        font-weight: 600;
        font-size: .9rem;
    }

    .tc-desc {
        font-size: .82rem;
        color: var(--text-2);
        margin-top: 1px;
    }

    .tc-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 11px;
    }

    .tc-price {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: .82rem;
        font-weight: 700;
        color: var(--green);
    }

    .tc-assign {
        margin-inline-start: auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .76rem;
        color: var(--text-3);
    }

    .tc-assign .aa {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--surface-2);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
        font-size: .6rem;
        font-weight: 700;
        color: var(--text-2);
    }

    .tc-foot {
        display: flex;
        gap: 4px;
    }

    .tc-done {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-wrap: nowrap;
        gap: 6px;
        background: var(--green-soft);
        color: var(--green);
        font-weight: 600;
        font-size: .70rem;
        padding: 8px;
        border-radius: var(--r-sm);
        transition: filter .18s ease;
    }

    .tc-done:hover {
        filter: brightness(.96);
    }

    .tc-mini {
        width: 32px;
        height: 32px;
        border-radius: var(--r-sm);
        border: 1px solid var(--border);
        display: grid;
        place-items: center;
        color: var(--brand);
        transition: all .18s ease;
    }

    .tc-mini:hover {
        background: var(--brand-soft);
    }

    /* دو ستونه: پیگیری + AI */
    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--gap);
        align-items: start;
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
    }

    .fu-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
    }

    .fu-row:last-child {
        border-bottom: none;
    }

    .fu-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: #fff;
        display: grid;
        place-items: center;
        font-size: .72rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .fu-body {
        flex: 1;
        min-width: 0;
    }

    .fu-name {
        font-weight: 600;
        font-size: .9rem;
    }

    .fu-treat {
        font-size: .8rem;
        color: var(--text-3);
    }

    .fu-stat {
        text-align: center;
        min-width: 56px;
    }

    .fu-stat .v {
        font-weight: 700;
        font-size: .88rem;
    }

    .fu-stat .v.green {
        color: var(--green);
    }

    .fu-stat .v.amber {
        color: var(--amber);
    }

    .fu-stat .l {
        font-size: .7rem;
        color: var(--text-3);
    }

    .fu-price {
        background: var(--green-soft);
        color: var(--green);
        font-weight: 700;
        font-size: .82rem;
        padding: 5px 11px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .ai-card {
        border: 1px solid color-mix(in srgb, var(--brand) 25%, transparent);
        border-radius: var(--r-lg);
        padding: 17px;
        margin-bottom: 14px;
        background: var(--surface);
        box-shadow: var(--shadow-sm);
    }

    .ai-card:last-child {
        margin-bottom: 0;
    }

    .ai-top {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
    }

    .ai-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .76rem;
        font-weight: 600;
        padding: 5px 11px;
        border-radius: 20px;
    }

    .ai-retention {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .ai-revenue {
        background: var(--purple-soft);
        color: var(--purple);
    }

    .ai-upsell {
        background: var(--teal-soft);
        color: var(--teal);
    }

    .ai-impact {
        margin-inline-start: auto;
        text-align: left;
    }

    .ai-impact .l {
        font-size: .7rem;
        color: var(--text-3);
    }

    .ai-impact .v {
        font-weight: 700;
        font-size: .86rem;
        color: var(--brand);
        font-variant-numeric: tabular-nums;
    }

    .ai-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 6px;
    }

    .ai-desc {
        font-size: .86rem;
        color: var(--text-2);
        line-height: 1.65;
        margin-bottom: 14px;
    }

    .ai-foot {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 12px;
    }

    .ai-rev .l {
        font-size: .7rem;
        font-weight: 700;
        color: var(--text-3);
        letter-spacing: .04em;
    }

    .ai-rev .v {
        font-size: 1.2rem;
        font-weight: 700;
    }

    .ai-start {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--brand);
        color: #fff;
        font-weight: 600;
        font-size: .85rem;
        padding: 9px 17px;
        border-radius: var(--r-md);
        transition: filter .18s ease;
    }

    .ai-start:hover {
        filter: brightness(1.08);
    }

    /* وظایف پرسنل */
    .dept-tabs {
        display: flex;
        gap: 2px;
        border-bottom: 1px solid var(--border);
        padding: 0 18px;
        overflow-x: auto;
    }

    .dtab {
        padding: 13px 15px;
        font-weight: 600;
        font-size: .88rem;
        color: var(--text-2);
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        white-space: nowrap;
        transition: color .18s ease;
    }

    .dtab:hover {
        color: var(--text);
    }

    .dtab.active {
        color: var(--brand);
        border-bottom-color: var(--brand);
    }

    .st-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 15px 18px;
        border-bottom: 1px solid var(--border);
    }

    .st-row:last-child {
        border-bottom: none;
    }

    .st-body {
        flex: 1;
        min-width: 0;
    }

    .st-name {
        font-weight: 600;
        font-size: .9rem;
    }

    .st-due {
        font-size: .78rem;
        color: var(--text-3);
    }

    .st-badge {
        font-size: .74rem;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .sb-pending {
        background: var(--surface-2);
        color: var(--text-2);
        border: 1px solid var(--border);
    }

    .sb-progress {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .st-prog {
        width: 110px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .st-bar {
        flex: 1;
        height: 6px;
        border-radius: 20px;
        background: var(--surface-2);
        overflow: hidden;
    }

    .st-fill {
        height: 100%;
        border-radius: 20px;
        background: var(--brand);
    }

    .st-pct {
        font-size: .78rem;
        font-weight: 600;
        color: var(--text-3);
        font-variant-numeric: tabular-nums;
    }

    /* تایم‌لاین امروز */
    .tl-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 18px;
        border-bottom: 1px solid var(--border);
        transition: background .15s ease;
    }

    .tl-row:last-child {
        border-bottom: none;
    }

    .tl-row.now {
        background: var(--brand-soft);
    }

    .tl-row.done .tl-name {
        text-decoration: line-through;
        color: var(--text-3);
    }

    .tl-time {
        font-size: .8rem;
        font-weight: 600;
        color: var(--text-3);
        font-variant-numeric: tabular-nums;
        width: 44px;
        flex-shrink: 0;
    }

    .tl-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .tl-name {
        flex: 1;
        min-width: 0;
        font-size: .88rem;
        font-weight: 500;
    }

    .tl-now-tag {
        background: var(--brand);
        color: #fff;
        font-size: .68rem;
        font-weight: 700;
        padding: 2px 9px;
        border-radius: 20px;
    }

    .tl-check {
        color: var(--green);
    }

    /* تحلیل وظایف */
    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .an-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 17px;
        box-shadow: var(--shadow-sm);
    }

    .an-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .an-title {
        font-size: .88rem;
        font-weight: 600;
    }

    .an-delta {
        font-size: .78rem;
        font-weight: 700;
        color: var(--green);
    }

    .an-delta.blue {
        color: var(--brand);
    }

    .an-val {
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -.02em;
        margin-bottom: 4px;
    }

    .an-note {
        font-size: .76rem;
        color: var(--text-3);
        margin-bottom: 10px;
    }

    .an-line {
        height: 52px;
    }

    .an-line svg {
        width: 100%;
        height: 100%;
    }

    .an-brk {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 7px;
        font-size: .76rem;
    }

    .an-brk:last-child {
        margin-bottom: 0;
    }

    .an-brk .bl {
        width: 58px;
        color: var(--text-3);
        flex-shrink: 0;
    }

    .an-brk .bbar {
        flex: 1;
        height: 6px;
        border-radius: 20px;
        background: var(--surface-2);
        overflow: hidden;
    }

    .an-brk .bfill {
        height: 100%;
        border-radius: 20px;
    }

    .an-brk .bv {
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        width: 32px;
        text-align: left;
        color: var(--text-2);
    }

    .an-bars {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 6px;
        height: 56px;
    }

    .an-bar {
        flex: 1;
        background: var(--green);
        border-radius: 4px 4px 0 0;
        transition: height .9s cubic-bezier(.16, 1, .3, 1);
    }

    /* جریان فعالیت */
    .af-row {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
    }

    .af-row:last-child {
        border-bottom: none;
    }

    .af-ic {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .af-text {
        flex: 1;
        min-width: 0;
        font-size: .89rem;
    }

    .af-time {
        font-size: .78rem;
        color: var(--text-3);
        white-space: nowrap;
    }

    /* ===================== ستون کناری ===================== */
    .rail {
        position: sticky;
        top: calc(64px + 20px);
        display: flex;
        flex-direction: column;
        gap: var(--gap);
    }

    .rail-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
        padding: 16px;
    }

    .rail-head {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 14px;
    }

    .rail-title {
        font-weight: 700;
        font-size: 1rem;
    }

    .rail-count {
        margin-inline-start: auto;
        background: var(--red-soft);
        color: var(--red);
        font-size: .76rem;
        font-weight: 700;
        min-width: 24px;
        height: 24px;
        border-radius: 20px;
        display: grid;
        place-items: center;
        padding: 0 7px;
    }

    .sub-label {
        font-size: .68rem;
        font-weight: 700;
        color: var(--text-3);
        letter-spacing: .06em;
        margin-bottom: 11px;
    }

    .alert-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 13px;
        border-radius: var(--r-md);
        margin-bottom: 9px;
        border: 1px solid;
    }

    .alert-row:last-child {
        margin-bottom: 0;
    }

    .alert-row.red {
        background: var(--red-soft);
        color: var(--red);
        border-color: color-mix(in srgb, var(--red) 18%, transparent);
    }

    .alert-row.amber {
        background: var(--amber-soft);
        color: var(--amber);
        border-color: color-mix(in srgb, var(--amber) 18%, transparent);
    }

    .alert-row.orange {
        background: var(--orange-soft);
        color: var(--orange);
        border-color: color-mix(in srgb, var(--orange) 18%, transparent);
    }

    .alert-row.gold {
        background: var(--gold-soft);
        color: var(--gold);
        border-color: color-mix(in srgb, var(--gold) 22%, transparent);
    }

    .alert-txt {
        flex: 1;
        min-width: 0;
        font-size: .86rem;
        font-weight: 600;
    }

    .alert-n {
        font-weight: 700;
        font-size: .9rem;
    }

    .qa-btn {
        display: flex;
        align-items: center;
        gap: 11px;
        width: 100%;
        padding: 12px 14px;
        border-radius: var(--r-md);
        color: #fff;
        font-weight: 600;
        font-size: .88rem;
        margin-bottom: 9px;
        transition: filter .18s ease;
    }

    .qa-btn:last-child {
        margin-bottom: 0;
    }

    .qa-btn:hover {
        filter: brightness(1.08);
    }

    .qa-btn .chev {
        margin-inline-start: auto;
        opacity: .8;
    }

    .qa-blue {
        background: var(--brand);
    }

    .qa-green {
        background: var(--green);
    }

    .qa-purple {
        background: var(--purple);
    }

    .qa-teal {
        background: #0ea36f;
    }

    .qa-orange {
        background: var(--orange);
    }

    .qa-indigo {
        background: #4f46e5;
    }

    .qa-dark {
        background: #1e293b;
    }

    html[data-theme="dark"] .qa-dark {
        background: #334155;
    }

    .glance-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 11px;
    }

    .glance-box {
        border-radius: var(--r-md);
        padding: 13px;
    }

    .gb-blue {
        background: var(--brand-soft);
    }

    .gb-green {
        background: var(--green-soft);
    }

    .gb-purple {
        background: var(--purple-soft);
    }

    .gb-teal {
        background: var(--teal-soft);
    }

    .glance-ic {
        margin-bottom: 7px;
    }

    .gb-blue .glance-ic {
        color: var(--brand);
    }

    .gb-green .glance-ic {
        color: var(--green);
    }

    .gb-purple .glance-ic {
        color: var(--purple);
    }

    .gb-teal .glance-ic {
        color: var(--teal);
    }

    .glance-v {
        font-size: 1.3rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .glance-l {
        font-size: .76rem;
        color: var(--text-2);
        margin-top: 2px;
    }

    /* موبایل */
    .menu-toggle {
        display: none;
    }

    .overlay {
        display: none;
    }

    @media (max-width:1400px) {
        .stat-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .kanban {
            grid-template-columns: 1fr 1fr;
        }

        .analytics-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width:1200px) {
        .body-grid {
            grid-template-columns: 1fr;
        }

        .rail {
            position: static;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
        }
    }

    @media (max-width:1024px) {
        .two-col {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width:860px) {
        .sidebar {
            transform: translateX(100%);
            box-shadow: var(--shadow-lg);
        }

        html.nav-open .sidebar {
            transform: translateX(0);
        }

        .main {
            margin-inline-start: 0;
        }

        .menu-toggle {
            display: grid;
        }

        html.nav-open .overlay {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            z-index: 45;
        }

        .topbar {
            padding: 12px 14px;
            gap: 10px;
        }

        .top-date {
            display: none;
        }

        .search {
            max-width: none;
            width: 100%;
            order: 5;
        }

        .body-grid {
            padding: 14px;
        }

        .rail {
            grid-template-columns: 1fr;
        }

        .stat-grid {
            grid-template-columns: 1fr 1fr;
        }

        .kanban {
            grid-template-columns: 1fr;
        }

        .analytics-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width:560px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 1.1rem;
        }

        .glance-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (prefers-reduced-motion:reduce) {

        *,
        *::after,
        *::before {
            animation: none !important;
            transition: none !important;
        }
    }

    /* ===================== مودال ===================== */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .5);
        backdrop-filter: blur(2px);
        z-index: 100;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity .2s ease;
    }

    .modal-overlay.open {
        display: flex;
        opacity: 1;
    }

    .modal-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-lg);
        width: 100%;
        max-width: 420px;
        transform: translateY(14px) scale(.97);
        opacity: 0;
        transition: transform .22s cubic-bezier(.16, 1, .3, 1), opacity .22s ease;
    }

    .modal-overlay.open .modal-box {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .modal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        border-bottom: 1px solid var(--border);
    }

    .modal-title {
        font-size: 1.05rem;
        font-weight: 700;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        border-radius: var(--r-sm, 8px);
        display: grid;
        place-items: center;
        color: var(--text-2);
        transition: all .18s ease;
    }

    .modal-close:hover {
        background: var(--surface-2);
        color: var(--text);
    }

    .modal-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group label {
        font-size: .84rem;
        font-weight: 600;
        color: var(--text-2);
    }

    .form-group input,
    .form-group select {
        height: 42px;
        border-radius: var(--r-md);
        background: var(--surface-2);
        border: 1px solid var(--border);
        padding: 0 14px;
        font-family: inherit;
        font-size: .9rem;
        color: var(--text);
        transition: all .18s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--brand);
        background: var(--surface);
    }

    .modal-foot {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 20px;
        border-top: 1px solid var(--border);
    }

    .modal-btn {
        padding: 10px 18px;
        border-radius: var(--r-md);
        font-weight: 600;
        font-size: .88rem;
        transition: all .18s ease;
    }

    .modal-btn-ghost {
        background: var(--surface-2);
        color: var(--text-2);
        border: 1px solid var(--border);
    }

    .modal-btn-ghost:hover {
        background: var(--border);
        color: var(--text);
    }

    .modal-btn-primary {
        background: var(--brand);
        color: #fff;
    }

    .modal-btn-primary:hover {
        filter: brightness(1.08);
    }

    body.modal-open {
        overflow: hidden;
    }
</style>

@endsection

@section('btn')
<button class="filter-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 3H2l8 9.5V19l4 2v-8.5z" />
    </svg>اولویت</button>
<button class="filter-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 3H2l8 9.5V19l4 2v-8.5z" />
    </svg>وضعیت</button>
<button class="filter-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 3H2l8 9.5V19l4 2v-8.5z" />
    </svg>مسئول</button>
<button class="btn-add"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2.3" stroke-linecap="round">
        <path d="M12 5v14M5 12h14" />
    </svg>افزودن سریع</button>
@endsection

@section('subtitle')
عملکرد امروز نمای زنده عملیات
@endsection

@section('text-search')
جستجو وظیفه
@endsection
@section('content')

<!-- مودال افزودن سریع -->
<div class="modal-overlay {{ $errors->any() ? 'open' : '' }}" id="quickAddOverlay">
    <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="quickAddTitle">
        <div class="modal-head">
            <h3 class="modal-title" id="quickAddTitle">افزودن سریع</h3>
            <button class="modal-close" id="quickAddClose" aria-label="بستن">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="/employee/task/add" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="qaTitle">عنوان وظیفه</label>
                    <input type="text" name="title" id="qaTitle" placeholder="مثلاً: تماس پیگیری بیمار">
                    @error('title')<small style="color: tomato">! خطا : <span>{{$message}}</span></small>@enderror
                </div>
                <div class="form-group">
                    <label for="jalaliDateInput" class="form-label fw-semibold">تاریخ مورد نظر را انتخاب کنید</label>
                    <div class="date-input-wrap">
                        <input type="text" id="jalaliDateInput" data-jdp-only-date placeholder="مثلاً 1403/05/12" autocomplete="off">
                        <label for="jalaliDateInput" class="icon-date" id="iconDate"><i class="fa-solid fa-calendar"></i></label>
                    </div>
                    <input type="hidden" id="miladi" name="date_task">
                    @error('date_task')<small style="color: tomato">! خطا : <span>{{$message}}</span></small>@enderror
                </div>

                <div class="form-group">
                    <label for="jalaliDateInput" class="form-label fw-semibold">تایم مورد نظر را انتخاب کنید</label>
                    <input type="text" name="time_task" id="" placeholder="14:30">
                    @error('time_task')<small style="color: tomato">! خطا : <span>{{$message}}</span></small>@enderror
                </div>

                <div class="form-group">
                    <label for="qaPriority">اولویت</label>
                    <select id="qaPriority" name="priority">
                        <option value="critical">بحرانی</option>
                        <option value="high">زیاد</option>
                        <option value="normal" selected>عادی</option>
                    </select>
                    @error('priority')<small style="color: tomato">! خطا : <span>{{$message}}</span></small>@enderror
                </div>
            </div>
            
            <div class="modal-foot">
                <button class="modal-btn modal-btn-ghost" id="quickAddCancel">انصراف</button>
                <button type="submit" class="modal-btn modal-btn-primary" id="quickAddSave">ذخیره وظیفه</button>
            </div>
        </form>
    </div>
</div>


<div class="body-grid">
    <div class="tc-main">
        <!-- عملکرد امروز -->
        <section>
            <div class="sec-head">
                <div>
                    <div class="sec-title">عملکرد امروز</div>
                    <div class="sec-sub">نمای زنده عملیات</div>
                </div>
            </div>
            <div class="stat-grid" id="statGrid"></div>
        </section>

        <!-- اولویت‌های امروز -->
        <section>
            <div class="sec-head">
                <div>
                    <div class="sec-title">اولویت‌های امروز</div>
                    <div class="sec-sub">تخته وظایف — برای تغییر وضعیت بکشید</div>
                </div>
                <a href="#" class="sec-link">مشاهده همه ‹</a>
            </div>
            <div class="kanban" id="kanban">
                <div class="kcol">
                    <div class="kcol-head k-critical">بحرانی<span class="kcol-count">{{$criticalTasks->count()}}</span></div>

                    @if($criticalTasks->count() > 0)
                        @foreach($criticalTasks as $task)
                            <div class="task-card">
                                <div class="tc-top">
                                    <span class="tc-prio {{ $task->priority ? "p-critical" : "" }}">{{ $task->priority ? "بحرانی" : "" }}</span>
                                    <span class="tc-cat">پس از درمان</span>
                                    <span class="tc-time">{{$task->time_task}}</span>
                                </div>
                                <div class="tc-body">
                                    <span class="tc-avatar" style="background:#7c3aed">ا‌ت</span>
                                    <div class="tc-info"><div class="tc-name">اِما تامپسون</div><div class="tc-desc">{{$task->title}}</div></div>
                                </div>
                                <div class="tc-meta">
                                    <span class="tc-price"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>۴۲ م ت</span>
                                    <span class="tc-assign"><span class="aa">د‌پ</span>دکتر پاتل</span>
                                </div>
                                <div class="tc-foot">
                                    <a href="/employee/task/done/{{ $task->id }}" class="tc-done"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>انجام شد</a>
                                    <button class="tc-mini" aria-label="تماس"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg></button>
                                    <button class="tc-mini" aria-label="پیام"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></button>
                                    <button class="tc-mini" aria-label="باز کردن"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="task-card">
                            <p style="font-size: 0.80rem">وظیفه ای وجود نداره </p>
                        </div>
                    @endif

                </div>

                <div class="kcol">
                    <div class="kcol-head k-high">زیاد<span class="kcol-count">{{$highTasks->count()}}</span></div>

                    @if($highTasks->count() > 0)
                        @foreach($highTasks as $task)
                            <div class="task-card">
                                <div class="tc-top">
                                    <span class="tc-prio {{ $task->priority ? "p-high" : "" }}">{{ $task->priority ? "زیاد" : "" }}</span>
                                    <span class="tc-cat">پس از درمان</span>
                                    <span class="tc-time">{{$task->time_task}}</span>
                                </div>
                                <div class="tc-body">
                                    <span class="tc-avatar" style="background:#7c3aed">ا‌ت</span>
                                    <div class="tc-info"><div class="tc-name">اِما تامپسون</div><div class="tc-desc">{{$task->title}}</div></div>
                                </div>
                                <div class="tc-meta">
                                    <span class="tc-price"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>۴۲ م ت</span>
                                    <span class="tc-assign"><span class="aa">د‌پ</span>دکتر پاتل</span>
                                </div>
                                <div class="tc-foot">
                                    <a href="/employee/task/done/{{ $task->id }}" class="tc-done"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>انجام شد</a>
                                    <button class="tc-mini" aria-label="تماس"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg></button>
                                    <button class="tc-mini" aria-label="پیام"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></button>
                                    <button class="tc-mini" aria-label="باز کردن"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="task-card">
                            <p style="font-size: 0.80rem">وظیفه ای وجود نداره </p>
                        </div>
                    @endif

                </div>

                <div class="kcol">
                    <div class="kcol-head k-normal">عادی<span class="kcol-count">{{$normalTasks->count()}}</span></div>

                    @if($normalTasks->count() > 0)
                        @foreach($normalTasks as $task)
                            <div class="task-card">
                                <div class="tc-top">
                                    <span class="tc-prio {{ $task->priority ? "p-normal" : "" }}">{{ $task->priority ? "عادی" : "" }}</span>
                                    <span class="tc-cat">پس از درمان</span>
                                    <span class="tc-time">{{$task->time_task}}</span>
                                </div>
                                <div class="tc-body">
                                    <span class="tc-avatar" style="background:#7c3aed">ا‌ت</span>
                                    <div class="tc-info"><div class="tc-name">اِما تامپسون</div><div class="tc-desc">{{$task->title}}</div></div>
                                </div>
                                <div class="tc-meta">
                                    <span class="tc-price"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>۴۲ م ت</span>
                                    <span class="tc-assign"><span class="aa">د‌پ</span>دکتر پاتل</span>
                                </div>
                                <div class="tc-foot">
                                    <a href="/employee/task/done/{{ $task->id }}" class="tc-done"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>انجام شد</a>
                                    <button class="tc-mini" aria-label="تماس"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg></button>
                                    <button class="tc-mini" aria-label="پیام"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></button>
                                    <button class="tc-mini" aria-label="باز کردن"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="task-card">
                            <p style="font-size: 0.80rem">وظیفه ای وجود نداره </p>
                        </div>
                    @endif

                </div>

                <div class="kcol">
                    <div class="kcol-head k-done">تکمیل‌شده<span class="kcol-count">{{$doneTasks->count()}}</span></div>

                    @if($doneTasks->count() > 0)
                        @foreach($doneTasks as $task)
                            <div class="task-card">
                                <div class="tc-top">
                                    <span class="tc-prio {{ $task->priority ? "p-done" : "" }}">{{ $task->priority ? "تکمیل شده" : "" }}</span>
                                    <span class="tc-cat">پس از درمان</span>
                                    <span class="tc-time">{{$task->time_task}}</span>
                                </div>
                                <div class="tc-body">
                                    <span class="tc-avatar" style="background:#7c3aed">ا‌ت</span>
                                    <div class="tc-info"><div class="tc-name">اِما تامپسون</div><div class="tc-desc">{{$task->title}}</div></div>
                                </div>
                                <div class="tc-meta">
                                    <span class="tc-price"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>۴۲ م ت</span>
                                    <span class="tc-assign"><span class="aa">د‌پ</span>دکتر پاتل</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="task-card">
                            <p style="font-size: 0.80rem">وظیفه ای وجود نداره </p>
                        </div>
                    @endif

                </div>
            </div>
        </section>

        <!-- پیگیری + AI -->
        <section class="two-col">
            <div>
                <div class="sec-head">
                    <div>
                        <div class="sec-title">وظایف پیگیری</div>
                        <div class="sec-sub">بیمارانی که امروز نیاز به تماس دارند</div>
                    </div>
                    <a href="#" class="sec-link">مشاهده همه ‹</a>
                </div>
                <div class="card" id="followUps"></div>
            </div>
            <div>
                <div class="sec-head">
                    <div>
                        <div class="sec-title">وظایف پیشنهادی هوش مصنوعی</div>
                        <div class="sec-sub">مبتنی بر هوش کلینیک</div>
                    </div>
                </div>
                <div id="aiTasks"></div>
            </div>
        </section>

        <!-- وظایف پرسنل + تایم‌لاین -->
        <section class="two-col">
            <div>
                <div class="sec-head">
                    <div>
                        <div class="sec-title">وظایف پرسنل</div>
                        <div class="sec-sub">پیشرفت وظایف دپارتمان‌ها</div>
                    </div>
                </div>
                <div class="card">
                    <div class="dept-tabs" id="deptTabs">
                        <button class="dtab active">پذیرش</button>
                        <button class="dtab">پزشک</button>
                        <button class="dtab">پرستار</button>
                        <button class="dtab">بازاریابی</button>
                        <button class="dtab">انبار</button>
                    </div>
                    <div id="staffTasks"></div>
                </div>
            </div>
            <div>
                <div class="sec-head">
                    <div>
                        <div class="sec-title">تایم‌لاین امروز</div>
                        <div class="sec-sub">نمای برنامه — ۵ مرداد ۱۴۰۵</div>
                    </div>
                </div>
                <div class="card" id="timeline"></div>
            </div>
        </section>

        <!-- تحلیل وظایف -->
        <section>
            <div class="sec-head">
                <div>
                    <div class="sec-title">تحلیل وظایف</div>
                    <div class="sec-sub">شاخص‌های عملکرد — ۷ روز اخیر</div>
                </div>
            </div>
            <div class="analytics-grid">
                <div class="an-card">
                    <div class="an-top"><span class="an-title">نرخ تکمیل</span><span class="an-delta">۵٪+</span>
                    </div>
                    <div class="an-val">۷۷٪</div>
                    <div class="an-line" id="compLine"></div>
                </div>
                <div class="an-card">
                    <div class="an-top"><span class="an-title">میانگین زمان پاسخ</span><span class="an-delta">۸−
                            دقیقه</span></div>
                    <div class="an-val">۲۲ دقیقه</div>
                    <div class="an-note">از ایجاد وظیفه تا اقدام</div>
                    <div id="respBreak"></div>
                </div>
                <div class="an-card">
                    <div class="an-top"><span class="an-title">نرخ بازگشت بیمار</span><span class="an-delta">۱۲٪+</span>
                    </div>
                    <div class="an-val">۶۸٪</div>
                    <div id="returnBreak"></div>
                </div>
                <div class="an-card">
                    <div class="an-top"><span class="an-title">درآمد — پیگیری‌ها</span><span
                            class="an-delta">۳۲٪+</span></div>
                    <div class="an-val">۶۱ م ت</div>
                    <div class="an-bars" id="revBars"></div>
                </div>
            </div>
        </section>

        <!-- جریان فعالیت -->
        <section>
            <div class="sec-head">
                <div>
                    <div class="sec-title">جریان فعالیت</div>
                    <div class="sec-sub">رویدادهای لحظه‌ای کلینیک</div>
                </div>
                <a href="#" class="sec-link">مشاهده همه ‹</a>
            </div>
            <div class="card" id="activityFeed"></div>
        </section>
    </div>

    <!-- ستون کناری -->
    <div class="rail">
        <div class="rail-card">
            <div class="rail-head">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                </svg>
                <span class="rail-title">هشدارها و اقدامات</span>
                <span class="rail-count">۱۱</span>
            </div>
            <div class="sub-label">هشدارهای فوری</div>
            <div id="alerts"></div>
        </div>

        <div class="rail-card">
            <div class="sub-label">اقدامات سریع</div>
            <div id="quickActions">
                <button class="qa-btn qa-blue btn-add">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                    وظیفه جدید
                    <span class="chev">›</span>
                </button>
                <button class="qa-btn qa-green">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    تماس با بیمار
                    <span class="chev">›</span>
                </button>
                <button class="qa-btn qa-purple">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    ارسال پیامک
                    <span class="chev">›</span>
                </button>
                <button class="qa-btn qa-teal">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38c1.45.79 3.08 1.21 4.79 1.21h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2zm5.98 14.02c-.25.71-1.45 1.35-2 1.44-.51.08-1.15.11-1.86-.12-.43-.14-.98-.32-1.69-.63-2.97-1.28-4.91-4.28-5.06-4.48-.15-.2-1.21-1.61-1.21-3.07 0-1.46.77-2.18 1.04-2.48.27-.3.6-.37.8-.37h.57c.18 0 .43-.07.67.51.25.6.85 2.07.92 2.22.07.15.12.33.02.53-.1.2-.15.33-.3.5-.15.18-.31.4-.45.54-.15.15-.3.31-.13.6.17.3.76 1.25 1.63 2.02 1.12 1 2.06 1.31 2.36 1.46.3.15.47.13.65-.08.18-.2.75-.87.95-1.17.2-.3.4-.25.67-.15.27.1 1.72.81 2.02.96.3.15.5.23.57.35.08.13.08.7-.17 1.41z"/></svg>
                    ارسال واتساپ
                    <span class="chev">›</span>
                </button>
                <button class="qa-btn qa-orange">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l18-6v14l-18-6v-2z"/><path d="M11 16.5l1 4.5a2 2 0 0 1-3.87 1.07L6.5 16.5"/></svg>
                    ایجاد کمپین
                    <span class="chev">›</span>
                </button>
                <button class="qa-btn qa-indigo">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    رزرو نوبت
                    <span class="chev">›</span>
                </button>
                <button class="qa-btn qa-dark">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    ثبت پرداخت
                    <span class="chev">›</span>
                </button>
            </div>
        </div>

        <div class="rail-card">
            <div class="sub-label">نگاه کلی امروز</div>
            <div class="glance-grid" id="glance"></div>
        </div>
    </div>

    @endsection

    @section('js')

    <script>
        (function () {
  const btnAdds    = document.querySelectorAll('.btn-add');
  const overlay   = document.getElementById('quickAddOverlay');
  const btnClose  = document.getElementById('quickAddClose');
  const btnCancel = document.getElementById('quickAddCancel');
  const btnSave   = document.getElementById('quickAddSave');

  function openModal() {
    overlay.classList.add('open');
    document.body.classList.add('modal-open');
    document.getElementById('qaTitle').focus();
  }

  function closeModal() {
    overlay.classList.remove('open');
    document.body.classList.remove('modal-open');
  }
btnAdds.forEach((btnAdd)=>{
    btnAdd?.addEventListener('click', openModal);
})
  btnClose?.addEventListener('click', closeModal);
  btnCancel?.addEventListener('click', closeModal);

  // کلیک روی پس‌زمینه = بستن
  overlay?.addEventListener('click', (e) => {
    if (e.target === overlay) closeModal();
  });

  // بستن با کلید Esc
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
  });

  // ذخیره (نمونه — اینجا می‌تونی fetch/ajax بزنی)
  btnSave?.addEventListener('click', () => {
    const title    = document.getElementById('qaTitle').value.trim();
    const priority = document.getElementById('qaPriority').value;
    const assign   = document.getElementById('qaAssign').value.trim();

    if (!title) {
      document.getElementById('qaTitle').focus();
      return;
    }

    console.log({ title, priority, assign });
    // TODO: اینجا با fetch به سرور بفرست

    closeModal();
    document.getElementById('qaTitle').value = '';
    document.getElementById('qaAssign').value = '';
  });
})();
    </script>

<script src="{{ asset("jpd-datepiker/jdp.js") }}"></script>

    <script>
        /* ═══ داده‌ها ═══ */

const stats=[
  {icon:'checkcircle',color:'green',delta:'۳+',val:'۲۴',sub:'از ۳۱ مورد امروز',label:'وظایف تکمیل‌شده'},
  {icon:'clock',color:'brand',val:'۷',sub:'۳ مورد تا قبل از ۱۴:۰۰',label:'وظایف در انتظار'},
  {icon:'alert',color:'red',val:'۳',sub:'نیازمند اقدام فوری',label:'وظایف عقب‌افتاده'},
  {icon:'dollar',color:'green',delta:'۲۱ م ت+',val:'۱۲۸ م ت',sub:'از پیگیری‌های امروز',label:'فرصت‌های درآمد'},
  {icon:'star',color:'gold',val:'۵',sub:'نیاز به توجه ویژه',label:'بیماران اولویت بالا'},
];
const followUps=[
  {init:'ک‌م',color:'#db2777',name:'کلودیا مورتی',treat:'ترمیم بوتاکس',days:'۲۸',prob:'۸۷٪',pc:'green',price:'۲۸ م ت'},
  {init:'د‌ا',color:'#2563eb',name:'دیوید اوکافور',treat:'جلسه لیزر شماره ۴',days:'۱۴',prob:'۹۴٪',pc:'green',price:'۴۵ م ت'},
  {init:'ن‌ه',color:'#0d9488',name:'نینا هارگریوز',treat:'پیگیری PRP',days:'۲۱',prob:'۷۲٪',pc:'green',price:'۶۸ م ت'},
  {init:'آ‌س',color:'#ea580c',name:'الکس سانتوس',treat:'تماس پس از درمان',days:'۳',prob:'۹۸٪',pc:'green'},
  {init:'ا‌ل',color:'#7c3aed',name:'ایزابلا لورن',treat:'بازخورد مشتری',days:'۷',prob:'۶۵٪',pc:'amber'},
];
const aiTasks=[
  {chip:'نگهداشت',ccls:'ai-retention',impact:'۹۴/۱۰۰',title:'تماس با ۵ بیمار VIP غیرفعال',desc:'این بیماران بیش از ۶۰ روز مراجعه نکرده‌اند و از نظر تاریخی ارزش عمر بالایی دارند. تماس شخصی ۳.۲ برابر بهتر از پیامک خودکار تبدیل می‌شود.',rev:'۴۲۰ م ت'},
  {chip:'درآمد',ccls:'ai-revenue',impact:'۸۸/۱۰۰',title:'زمان‌بندی سری لیزر برای ۳ بیمار',desc:'بر اساس سابقه مشاوره، این بیماران کاندیدای ایده‌آل پکیج لیزر هستند. زمان‌بندی الان از خالی ماندن دستگاه جلوگیری می‌کند.',rev:'۲۸۵ م ت'},
  {chip:'فروش مکمل',ccls:'ai-upsell',impact:'۷۹/۱۰۰',title:'فروش پکیج مراقبت پوست — پس از مشاوره',desc:'۱۲ بیمار این هفته مشاوره داشتند بدون خرید پکیج. پیشنهاد هدفمند نرخ الحاق را ۴۱٪ افزایش می‌دهد.',rev:'۱۶۸ م ت'},
];
const staffTasks=[
  {name:'تأیید ۱۴ نوبت فردا',due:'مهلت ۱۴:۰۰',badge:'در انتظار',bcls:'sb-pending',pct:30},
  {name:'پردازش ۳ ثبت‌نام بیمار جدید',due:'مهلت ۱۲:۰۰',badge:'در حال انجام',bcls:'sb-progress',pct:67},
  {name:'به‌روزرسانی اطلاعات تماس ۸ بیمار',due:'مهلت پایان روز',badge:'در انتظار',bcls:'sb-pending',pct:0},
];
const timeline=[
  {time:'۰۹:۰۰',name:'جلسه تیم',color:'var(--green)',done:true},
  {time:'۰۹:۳۰',name:'جیمز ر. — پذیرش هایدرافیشیال',color:'var(--green)',done:true},
  {time:'۱۰:۳۰',name:'پیگیری لیزر — اِما ت.',color:'var(--brand)',now:true},
  {time:'۱۲:۰۰',name:'بررسی شارژ انبار',color:'var(--text-3)'},
  {time:'۱۴:۰۰',name:'سرویس دستگاه — لیزر شماره ۲',color:'#f59e0b'},
  {time:'۱۵:۰۰',name:'نوبت VIP — سوفیا ر.',color:'var(--purple)'},
  {time:'۱۶:۳۰',name:'گزارش پایان روز',color:'var(--text-3)'},
];
const respBreak=[
  {l:'بحرانی',pct:22,color:'var(--red)',v:'۸د'},
  {l:'زیاد',pct:48,color:'#f59e0b',v:'۱۸د'},
  {l:'عادی',pct:88,color:'var(--brand)',v:'۳۴د'},
];
const returnBreak=[
  {l:'پس از پیگیری',pct:84,color:'var(--green)',v:'۸۴٪'},
  {l:'بدون پیگیری',pct:41,color:'var(--green)',v:'۴۱٪'},
  {l:'بیماران VIP',pct:92,color:'var(--green)',v:'۹۲٪'},
];
const revBars=[45,72,55,80,62,95];
const activity=[
  {icon:'checkcircle',color:'green',text:'تماس پیگیری تکمیل شد — اِما تامپسون',time:'۲ دقیقه پیش'},
  {icon:'appointments',color:'brand',text:'نوبت رزرو شد — جلسه PRP، ع. کامارا',time:'۱۵ دقیقه پیش'},
  {icon:'send',color:'purple',text:'واتساپ به ۲۳ سرنخ کمپین تابستان ارسال شد',time:'۳۴ دقیقه پیش'},
  {icon:'card',color:'teal',text:'پرداخت ثبت شد — پکیج لیزر ۸۵ میلیون تومان',time:'۱ ساعت پیش'},
  {icon:'box',color:'orange',text:'هشدار انبار — موجودی فیلر زیر حد مجاز',time:'۲ ساعت پیش'},
  {icon:'chart',color:'brand',text:'گزارش ماهانه برای مدیر کلینیک ارسال شد',time:'۳ ساعت پیش'},
];
const alerts=[
  {cls:'red',icon:'alert',txt:'پیگیری‌های از‌دست‌رفته',n:'۳'},
  {cls:'amber',icon:'wrench',txt:'سرویس دستگاه',n:'۱'},
  {cls:'orange',icon:'box',txt:'اقلام کم‌موجودی',n:'۴'},
  {cls:'gold',icon:'star',txt:'VIP — بدون رزرو فعال',n:'۲'},
  {cls:'red',icon:'xcircle',txt:'نوبت‌های لغوشده',n:'۱'},
];
const glance=[
  {icon:'appointments',cls:'gb-blue',v:'۱۴',l:'نوبت'},
  {icon:'dollar',cls:'gb-green',v:'۸۲ م ت',l:'درآمد'},
  {icon:'userplus',cls:'gb-purple',v:'۳',l:'بیمار جدید'},
  {icon:'activity',cls:'gb-teal',v:'۹',l:'پرسنل فعال'},
];


document.getElementById('statGrid').innerHTML=stats.map(s=>`
  <div class="stat-card">
    <div class="stat-top"><span class="stat-ic" style="background:var(--${s.color}-soft);color:var(--${s.color})">${svg(s.icon,18)}</span>${s.delta?`<span class="stat-delta">↗ ${s.delta}</span>`:''}</div>
    <div class="stat-val">${s.val}</div>
    <div class="stat-sub">${s.sub}</div>
    <div class="stat-label">${s.label}</div>
  </div>`).join('');

document.getElementById('followUps').innerHTML=followUps.map(f=>`
  <div class="fu-row">
    <span class="fu-avatar" style="background:${f.color}">${f.init}</span>
    <div class="fu-body"><div class="fu-name">${f.name}</div><div class="fu-treat">${f.treat}</div></div>
    <div class="fu-stat"><div class="v">${f.days} روز</div><div class="l">از مراجعه</div></div>
    <div class="fu-stat"><div class="v ${f.pc}">${f.prob}</div><div class="l">احتمال بازگشت</div></div>
    ${f.price?`<span class="fu-price">${f.price}</span>`:'<span style="width:64px"></span>'}
  </div>`).join('');

document.getElementById('aiTasks').innerHTML=aiTasks.map(a=>`
  <div class="ai-card">
    <div class="ai-top">
      <span class="ai-chip ${a.ccls}">${svg('sparkle',14)}${a.chip}</span>
      <div class="ai-impact"><div class="l">تأثیر</div><div class="v">${a.impact}</div></div>
    </div>
    <div class="ai-title">${a.title}</div>
    <div class="ai-desc">${a.desc}</div>
    <div class="ai-foot">
      <div class="ai-rev"><div class="l">درآمد تخمینی</div><div class="v">${a.rev}</div></div>
      <button class="ai-start">شروع وظیفه ↗</button>
    </div>
  </div>`).join('');

document.getElementById('staffTasks').innerHTML=staffTasks.map(s=>`
  <div class="st-row">
    <div class="st-body"><div class="st-name">${s.name}</div><div class="st-due">${s.due}</div></div>
    <span class="st-badge ${s.bcls}">${s.badge}</span>
    <div class="st-prog"><div class="st-bar"><div class="st-fill" style="width:${s.pct}%"></div></div><span class="st-pct">${toFa(s.pct)}٪</span></div>
  </div>`).join('');

document.getElementById('timeline').innerHTML=timeline.map(t=>`
  <div class="tl-row ${t.now?'now':''} ${t.done?'done':''}">
    <span class="tl-time">${t.time}</span>
    <span class="tl-dot" style="background:${t.color}"></span>
    <span class="tl-name">${t.name}</span>
    ${t.now?'<span class="tl-now-tag">اکنون</span>':''}
    ${t.done?`<span class="tl-check">${svg('checkcircle',16)}</span>`:''}
  </div>`).join('');

function renderBreak(id,rows){
  document.getElementById(id).innerHTML=rows.map(r=>`
    <div class="an-brk"><span class="bl">${r.l}</span><div class="bbar"><div class="bfill" style="width:${r.pct}%;background:${r.color}"></div></div><span class="bv">${r.v}</span></div>`).join('');
}
renderBreak('respBreak',respBreak);
renderBreak('returnBreak',returnBreak);

document.getElementById('revBars').innerHTML=revBars.map(v=>`<div class="an-bar" style="height:0" data-h="${v}"></div>`).join('');
requestAnimationFrame(()=>{ document.querySelectorAll('.an-bar').forEach(b=>b.style.height=b.dataset.h+'%'); });

// نمودار خطی نرخ تکمیل
(function(){
  const w=280,h=52,pad=3,data=[58,66,62,72,68,74,77],min=50,max=85;
  const pts=data.map((v,i)=>{
    const x=pad+(i/(data.length-1))*(w-pad*2);
    const y=h-pad-((v-min)/(max-min))*(h-pad*2);
    return [x,y];
  });
  const line=pts.map((p,i)=>(i===0?'M':'L')+p[0].toFixed(1)+' '+p[1].toFixed(1)).join(' ');
  const area=line+` L${pts[pts.length-1][0].toFixed(1)} ${h-pad} L${pts[0][0].toFixed(1)} ${h-pad} Z`;
  document.getElementById('compLine').innerHTML=`
    <svg viewBox="0 0 ${w} ${h}" preserveAspectRatio="none">
      <defs><linearGradient id="cg" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="var(--brand)" stop-opacity="0.2"/><stop offset="100%" stop-color="var(--brand)" stop-opacity="0"/></linearGradient></defs>
      <path d="${area}" fill="url(#cg)"/>
      <path d="${line}" fill="none" stroke="var(--brand)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="600" stroke-dashoffset="600"><animate attributeName="stroke-dashoffset" from="600" to="0" dur="1.2s" fill="freeze" calcMode="spline" keySplines="0.16 1 0.3 1" keyTimes="0;1"/></path>
    </svg>`;
})();

document.getElementById('activityFeed').innerHTML=activity.map(a=>`
  <div class="af-row">
    <span class="af-ic" style="background:var(--${a.color}-soft);color:var(--${a.color})">${svg(a.icon,16)}</span>
    <span class="af-text">${a.text}</span>
    <span class="af-time">${a.time}</span>
  </div>`).join('');

document.getElementById('alerts').innerHTML=alerts.map(a=>`
  <div class="alert-row ${a.cls}">${svg(a.icon,17)}<span class="alert-txt">${a.txt}</span><span class="alert-n">${a.n}</span></div>`).join('');

document.getElementById('glance').innerHTML=glance.map(g=>`
  <div class="glance-box ${g.cls}"><div class="glance-ic">${svg(g.icon,17)}</div><div class="glance-v">${g.v}</div><div class="glance-l">${g.l}</div></div>`).join('');

/* ═══ تعامل‌ها ═══ */
document.getElementById('deptTabs').addEventListener('click',e=>{
  const t=e.target.closest('.dtab'); if(!t)return;
  document.querySelectorAll('.dtab').forEach(x=>x.classList.remove('active')); t.classList.add('active');
});
document.getElementById('kanban').addEventListener('click',e=>{
  const b=e.target.closest('.tc-done'); if(!b)return;
  const card=b.closest('.task-card');
  card.style.opacity='.5';
  setTimeout(()=>{ card.style.opacity=''; },700);
});

    </script>

    <script>
        function toPersianDigits(str) {
            const faDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            return String(str).replace(/\d/g, d => faDigits[d]);
        }

        const input = document.getElementById('jalaliDateInput');
        const iconDate = document.getElementById('iconDate');

        jalaliDatepicker.startWatch({
          autoShow: true,
          autoHide: true,
          hideAfterChange: true,
          showTodayBtn: true,
          showEmptyBtn: true,
          useDropDownYears: true,
          persianDigits: true,
          container: document.body,
          zIndex: 1090,
          targetValueInput: "#miladi",
            targetValueType: "gregorian",
            time: true,
            hasSecond: false
        });
        console.log(jalaliDatepicker);
        iconDate.addEventListener('click', () => jalaliDatepicker.show(input));

        /* ─────────────────────────────────────────────────────────
           جانمایی پویای تقویم نسبت به موقعیت واقعی اینپوت.
           قبلاً top/left با عدد ثابت در CSS تنظیم شده بود که فقط
           در یک سایز خاص صفحه درست می‌ایستاد و در بقیه‌ی سایزها
           (خصوصاً موبایل) باعث جابه‌جایی/همپوشانی با بقیه‌ی محتوا
           می‌شد. حالا موقعیت هر بار بر اساس رکت واقعی اینپوت و
           اندازه‌ی واقعی صفحه محاسبه و روی خود jdp-container ست
           می‌شود، پس روی هر سایز صفحه‌ای درست کار می‌کند.
           ───────────────────────────────────────────────────────── */
        (function () {
            const margin = 8;

            function positionDatepicker() {
                const jdp = document.querySelector('jdp-container');
                if (!jdp || !input) return;

                const rect = input.getBoundingClientRect();
                const jdpW = jdp.offsetWidth || 250;
                const jdpH = jdp.offsetHeight || 300;

                let left = rect.left;
                if (left + jdpW > window.innerWidth - margin) {
                    left = window.innerWidth - jdpW - margin;
                }
                if (left < margin) left = margin;

                let top = rect.bottom + margin;
                if (top + jdpH > window.innerHeight - margin) {
                    top = rect.top - jdpH - margin;
                }
                if (top < margin) top = margin;

                jdp.style.top = top + 'px';
                jdp.style.left = left + 'px';
            }

            function schedulePosition() {
                // چند بار پشت سر هم صدا می‌زنیم چون jdp-container
                // ممکن است با کمی تأخیر و بعد از رندر کامل به DOM اضافه/نمایان شود
                positionDatepicker();
                requestAnimationFrame(positionDatepicker);
                setTimeout(positionDatepicker, 60);
                setTimeout(positionDatepicker, 200);
            }

            input.addEventListener('focus', schedulePosition);
            input.addEventListener('click', schedulePosition);
            iconDate.addEventListener('click', schedulePosition);

            window.addEventListener('resize', positionDatepicker);
            window.addEventListener('scroll', positionDatepicker, true);

            // برای اطمینان، وقتی jdp-container به DOM اضافه می‌شود هم موقعیتش را تنظیم می‌کنیم
            const mo = new MutationObserver(schedulePosition);
            mo.observe(document.body, { childList: true });
        })();

    </script>

    @endsection