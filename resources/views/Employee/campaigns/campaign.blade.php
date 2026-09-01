@extends('layout.master')

@section('title')
اوراکلینیک — کمپین ها
@endsection

@section('name-page')
کمپین ها
@endsection

@section('head')

<style>
    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 15px;
        border-radius: 20px;
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

    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--brand);
        color: #fff;
        padding: 9px 18px;
        border-radius: 20px;
        font-weight: 600;
        font-size: .88rem;
        transition: filter .18s ease;
        white-space: nowrap;
    }

    .btn-create:hover {
        filter: brightness(1.08);
    }

    .body-grid {
        display: grid;
        grid-template-columns: 1fr var(--rail-w);
        gap: var(--gap);
        padding: 20px;
        align-items: start;
    }

    .cm-main {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: var(--gap);
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
    }

    .card-pad {
        padding: 20px;
    }

    /* آمار */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 14px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 17px;
        box-shadow: var(--shadow-sm);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-title {
        font-size: .7rem;
        font-weight: 700;
        color: var(--text-3);
        letter-spacing: .05em;
        margin-bottom: 9px;
    }

    .stat-val {
        font-size: 1.6rem;
        font-weight: 700;
        letter-spacing: -.02em;
        line-height: 1.1;
        margin-bottom: 9px;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: .74rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .sp-green {
        background: var(--green-soft);
        color: var(--green);
    }

    .sp-amber {
        background: var(--amber-soft);
        color: var(--amber);
    }

    .sp-gray {
        background: var(--surface-2);
        color: var(--text-3);
        border: 1px solid var(--border);
    }

    /* پیشنهاد AI */
    .ai-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .ai-ic {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: var(--brand);
        color: #fff;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .ai-t {
        font-weight: 700;
        font-size: 1.05rem;
    }

    .ai-s {
        font-size: .82rem;
        color: var(--text-3);
    }

    .ai-tag {
        margin-inline-start: auto;
        background: var(--brand-soft);
        color: var(--brand);
        font-size: .68rem;
        font-weight: 700;
        padding: 5px 11px;
        border-radius: 20px;
        letter-spacing: .04em;
    }

    .sugg-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .sugg {
        border: 1px solid var(--border);
        border-radius: var(--r-md);
        padding: 17px;
        transition: box-shadow .2s ease;
    }

    .sugg:hover {
        box-shadow: var(--shadow-md);
    }

    .sugg-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 3px;
    }

    .sugg-name {
        font-weight: 700;
        font-size: .98rem;
    }

    .sugg-chip {
        font-size: .68rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .ch-blue {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .ch-violet {
        background: var(--violet-soft);
        color: var(--violet);
    }

    .ch-amber {
        background: var(--amber-soft);
        color: var(--amber);
    }

    .ch-rose {
        background: var(--rose-soft);
        color: var(--rose);
    }

    .ch-emerald {
        background: var(--emerald-soft);
        color: var(--emerald);
    }

    .sugg-desc {
        font-size: .82rem;
        color: var(--text-3);
        margin-bottom: 15px;
    }

    .sugg-metrics {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 14px;
    }

    .sm-l {
        font-size: .72rem;
        color: var(--text-3);
        margin-bottom: 2px;
    }

    .sm-v {
        font-weight: 700;
        font-size: .94rem;
    }

    .sm-v.green {
        color: var(--green);
    }

    .conf-label {
        font-size: .72rem;
        color: var(--text-3);
        margin-bottom: 6px;
    }

    .conf-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
    }

    .conf-bar {
        flex: 1;
        height: 6px;
        border-radius: 20px;
        background: var(--surface-2);
        overflow: hidden;
    }

    .conf-fill {
        height: 100%;
        border-radius: 20px;
        transition: width 1s cubic-bezier(.16, 1, .3, 1);
    }

    .conf-pct {
        font-size: .78rem;
        font-weight: 600;
        color: var(--text-2);
        font-variant-numeric: tabular-nums;
    }

    .launch-btn {
        width: 100%;
        padding: 11px;
        border-radius: var(--r-md);
        font-weight: 600;
        font-size: .88rem;
        transition: all .18s ease;
    }

    .launch-primary {
        background: var(--brand);
        color: #fff;
    }

    .launch-primary:hover {
        filter: brightness(1.08);
    }

    .launch-ghost {
        background: var(--surface-2);
        border: 1px solid var(--border);
        color: var(--text-2);
    }

    .launch-ghost:hover {
        border-color: var(--border-strong);
        color: var(--text);
    }

    /* جدول کمپین */
    .card-title-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 20px 14px;
    }

    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
    }

    .card-links {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: .84rem;
    }

    .card-links .cnt {
        color: var(--text-3);
    }

    .card-links a {
        color: var(--brand);
        font-weight: 600;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 820px;
    }

    thead th {
        text-align: right;
        font-size: .72rem;
        font-weight: 600;
        color: var(--text-3);
        letter-spacing: .04em;
        padding: 11px 20px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        font-size: .88rem;
        white-space: nowrap;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr:hover {
        background: var(--surface-2);
    }

    .td-name {
        font-weight: 600;
    }

    .td-mut {
        color: var(--text-2);
    }

    .td-rev {
        color: var(--green);
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }

    .td-roi {
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .78rem;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 20px;
    }

    .status::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .st-active {
        background: var(--green-soft);
        color: var(--green);
    }

    .st-sched {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .st-draft {
        background: var(--amber-soft);
        color: var(--amber);
    }

    .st-done {
        background: var(--surface-2);
        color: var(--text-2);
        border: 1px solid var(--border);
    }

    /* سگمنت‌ها */
    .seg-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .seg-title {
        font-size: 1.05rem;
        font-weight: 700;
    }

    .seg-link {
        color: var(--brand);
        font-weight: 600;
        font-size: .84rem;
    }

    .seg-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .seg-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 16px;
        box-shadow: var(--shadow-sm);
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .seg-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .seg-top {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 14px;
    }

    .seg-ic {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .seg-name {
        font-weight: 700;
        font-size: .94rem;
    }

    .seg-count {
        font-size: .8rem;
        color: var(--text-3);
    }

    .seg-bot {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 10px;
    }

    .seg-rev-l {
        font-size: .72rem;
        color: var(--text-3);
    }

    .seg-rev-v {
        font-weight: 700;
        font-size: .98rem;
        color: var(--green);
    }

    .seg-btn {
        font-size: .76rem;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
        white-space: nowrap;
        transition: filter .18s ease;
    }

    .seg-btn:hover {
        filter: brightness(.95);
    }

    /* سازنده کمپین */
    .chan-row {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 26px;
    }

    .chan {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 20px;
        border: 1.5px solid var(--border);
        font-size: .86rem;
        font-weight: 600;
        color: var(--text-2);
        cursor: pointer;
        transition: all .18s ease;
    }

    .chan:hover {
        border-color: var(--border-strong);
        color: var(--text);
    }

    .chan.active {
        border-color: var(--brand);
        background: var(--brand-soft);
        color: var(--brand);
    }

    .chan .ci {
        display: grid;
        place-items: center;
    }

    .steps {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        position: relative;
    }

    .steps::before {
        content: '';
        position: absolute;
        top: 22px;
        inset-inline: 60px;
        height: 2px;
        background: var(--border);
    }

    .step {
        text-align: center;
        position: relative;
    }

    .step-ic {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--brand-soft);
        color: var(--brand);
        display: grid;
        place-items: center;
        margin: 0 auto 12px;
        border: 2px solid var(--surface);
        position: relative;
        z-index: 1;
    }

    .step-day {
        font-size: .72rem;
        font-weight: 700;
        color: var(--brand);
        letter-spacing: .05em;
    }

    .step-name {
        font-weight: 700;
        font-size: .92rem;
        margin-top: 3px;
    }

    .step-desc {
        font-size: .78rem;
        color: var(--text-3);
        margin-top: 2px;
    }

    /* نمودارها */
    .chart-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--gap);
    }

    .ch-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 18px;
        gap: 12px;
    }

    .ch-t {
        font-size: 1.02rem;
        font-weight: 700;
    }

    .ch-s {
        font-size: .8rem;
        color: var(--text-3);
        margin-top: 1px;
    }

    .ch-val {
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--green);
    }

    .ch-pill {
        font-size: .76rem;
        font-weight: 600;
        color: var(--text-2);
        background: var(--surface-2);
        border: 1px solid var(--border);
        padding: 5px 12px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .line-box {
        height: 170px;
        display: flex;
        gap: 8px;
    }

    .y-axis {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: .7rem;
        color: var(--text-3);
        text-align: left;
        padding-bottom: 20px;
    }

    .line-area {
        flex: 1;
        position: relative;
    }

    .line-area svg {
        width: 100%;
        height: 150px;
    }

    .x-axis {
        display: flex;
        justify-content: space-between;
        font-size: .72rem;
        color: var(--text-3);
        margin-top: 4px;
    }

    .bars-box {
        height: 170px;
        display: flex;
        gap: 8px;
    }

    .bars-area {
        flex: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        gap: 12px;
        height: 150px;
        border-bottom: 1px dashed var(--border);
    }

    .bar-group {
        display: flex;
        gap: 3px;
        align-items: flex-end;
        height: 100%;
    }

    .bar {
        width: 6px;
        border-radius: 4px;
        transition: height .9s cubic-bezier(.16, 1, .3, 1);
    }

    .legend {
        display: flex;
        gap: 16px;
        margin-top: 14px;
        font-size: .78rem;
        color: var(--text-2);
        flex-wrap: wrap;
    }

    .lg {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .lg::before {
        content: '';
        width: 9px;
        height: 9px;
        border-radius: 50%;
    }

    .lg.open::before {
        background: var(--brand);
    }

    .lg.book::before {
        background: var(--green);
    }

    .lg.ret::before {
        background: var(--violet);
    }

    /* جریان فعالیت */
    .act-row {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
    }

    .act-row:last-child {
        border-bottom: none;
    }

    .act-ic {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .act-body {
        flex: 1;
        min-width: 0;
    }

    .act-t {
        font-weight: 600;
        font-size: .9rem;
    }

    .act-s {
        font-size: .8rem;
        color: var(--text-3);
        margin-top: 1px;
    }

    .act-time {
        font-size: .78rem;
        color: var(--text-3);
        white-space: nowrap;
    }

    /* ستون کناری */
    .rail {
        position: sticky;
        top: calc(66px + 20px);
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
        justify-content: space-between;
        margin-bottom: 13px;
    }

    .rail-label {
        font-size: .68rem;
        font-weight: 700;
        color: var(--text-3);
        letter-spacing: .07em;
    }

    .rail-n {
        background: var(--red-soft);
        color: var(--red);
        font-size: .74rem;
        font-weight: 700;
        min-width: 22px;
        height: 22px;
        border-radius: 20px;
        display: grid;
        place-items: center;
        padding: 0 7px;
    }

    .qa-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--brand);
        color: #fff;
        padding: 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: .9rem;
        margin-bottom: 10px;
        transition: filter .18s ease;
    }

    .qa-primary:hover {
        filter: brightness(1.08);
    }

    .qa-row {
        display: flex;
        align-items: center;
        gap: 11px;
        width: 100%;
        padding: 11px 13px;
        border-radius: var(--r-md);
        border: 1px solid var(--border);
        font-weight: 500;
        font-size: .86rem;
        color: var(--text-2);
        margin-bottom: 9px;
        transition: all .18s ease;
    }

    .qa-row:last-child {
        margin-bottom: 0;
    }

    .qa-row:hover {
        background: var(--surface-2);
        color: var(--text);
        border-color: var(--border-strong);
    }

    .qa-row .qi {
        color: var(--text-3);
    }

    .smart-alert {
        border-radius: var(--r-md);
        padding: 12px 13px;
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
    }

    .smart-alert:last-child {
        margin-bottom: 0;
    }

    .sa-amber {
        background: var(--amber-soft);
    }

    .sa-green {
        background: var(--green-soft);
    }

    .sa-blue {
        background: var(--brand-soft);
    }

    .sa-gray {
        background: var(--surface-2);
        border: 1px solid var(--border);
    }

    .sa-ic {
        flex-shrink: 0;
        margin-top: 2px;
    }

    .sa-amber .sa-ic {
        color: var(--amber);
    }

    .sa-green .sa-ic {
        color: var(--green);
    }

    .sa-blue .sa-ic {
        color: var(--brand);
    }

    .sa-gray .sa-ic {
        color: var(--text-3);
    }

    .sa-t {
        font-weight: 700;
        font-size: .85rem;
    }

    .sa-d {
        font-size: .78rem;
        color: var(--text-2);
        margin-top: 2px;
    }

    .month-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        font-size: .86rem;
        border-bottom: 1px solid var(--border);
    }

    .month-row:last-child {
        border-bottom: none;
    }

    .month-l {
        color: var(--text-2);
    }

    .month-v {
        font-weight: 700;
        color: var(--brand);
        font-variant-numeric: tabular-nums;
    }

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

        .sugg-grid {
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

        .seg-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width:1024px) {
        .chart-2 {
            grid-template-columns: 1fr;
        }

        .steps {
            grid-template-columns: 1fr 1fr;
        }

        .steps::before {
            display: none;
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

        .sugg-grid {
            grid-template-columns: 1fr;
        }

        .seg-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width:560px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .steps {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 1.1rem;
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
</style>

@endsection

@section('btn')
<button class="filter-btn"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 3H2l8 9.5V19l4 2v-8.5z" />
    </svg>همه وضعیت‌ها<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round">
        <path d="m6 9 6 6 6-6" />
    </svg></button>
<button class="filter-btn"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 3H2l8 9.5V19l4 2v-8.5z" />
    </svg>همه انواع<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round">
        <path d="m6 9 6 6 6-6" />
    </svg></button>
<button class="btn-create"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2.3" stroke-linecap="round">
        <path d="M12 5v14M5 12h14" />
    </svg>ایجاد کمپین</button>
@endsection

@section('subtitle')

@endsection

@section('text-search')
جستجو کمپین ها
@endsection

@section('content')
<div class="body-grid">
    <div class="cm-main">
        <div class="stat-grid" id="statGrid"></div>

        <!-- پیشنهاد AI -->
        <div class="card card-pad">
            <div class="ai-head">
                <span class="ai-ic"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z" />
                    </svg></span>
                <div>
                    <div class="ai-t">پیشنهادهای هوش مصنوعی</div>
                    <div class="ai-s">بر اساس الگوی رفتار بیماران · ۵ دقیقه پیش به‌روز شد</div>
                </div>
                <span class="ai-tag">مبتنی بر هوش مصنوعی</span>
            </div>
            <div class="sugg-grid" id="suggGrid"></div>
        </div>

        <!-- جدول کمپین -->
        <div class="card">
            <div class="card-title-row">
                <span class="card-title">فهرست کمپین‌ها</span>
                <div class="card-links"><span class="cnt">۶ کمپین</span><a href="#">مشاهده همه</a></div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>نام کمپین</th>
                            <th>مخاطب</th>
                            <th>کانال</th>
                            <th>وضعیت</th>
                            <th>تاریخ شروع</th>
                            <th>تبدیل</th>
                            <th>درآمد</th>
                            <th>بازگشت سرمایه</th>
                        </tr>
                    </thead>
                    <tbody id="campBody"></tbody>
                </table>
            </div>
        </div>

        <!-- سگمنت‌ها -->
        <div>
            <div class="seg-head"><span class="seg-title">بخش‌بندی بیماران</span><a href="#" class="seg-link">مدیریت
                    بخش‌ها</a></div>
            <div class="seg-grid" id="segGrid"></div>
        </div>

        <!-- سازنده کمپین -->
        <div class="card card-pad">
            <div class="ch-head">
                <div>
                    <div class="ch-t">سازنده کمپین چندکاناله</div>
                    <div class="ch-s">کانال‌ها را انتخاب و توالی ارتباط را پیکربندی کنید</div>
                </div>
                <button class="filter-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>افزودن گام</button>
            </div>
            <div class="chan-row" id="chanRow"></div>
            <div class="steps" id="steps"></div>
        </div>

        <!-- نمودارها -->
        <div class="chart-2">
            <div class="card card-pad">
                <div class="ch-head">
                    <div>
                        <div class="ch-t">درآمد ایجادشده</div>
                        <div class="ch-s">درآمد منتسب به کمپین · ۶ ماه اخیر</div>
                    </div>
                    <span class="ch-val">۱٬۲۸۴ م ت</span>
                </div>
                <div class="line-box">
                    <div class="y-axis">
                        <span>۱۴۰۰م</span><span>۱۰۵۰م</span><span>۷۰۰م</span><span>۳۵۰م</span><span>۰</span>
                    </div>
                    <div class="line-area">
                        <div id="revLine"></div>
                        <div class="x-axis" id="revX"></div>
                    </div>
                </div>
            </div>
            <div class="card card-pad">
                <div class="ch-head">
                    <div>
                        <div class="ch-t">نرخ‌های عملکرد کمپین</div>
                        <div class="ch-s">باز شدن · پاسخ · رزرو · بازگشت</div>
                    </div>
                    <span class="ch-pill">۶ ماه اخیر</span>
                </div>
                <div class="bars-box">
                    <div class="y-axis"><span>۱۰۰٪</span><span>۷۵٪</span><span>۵۰٪</span><span>۲۵٪</span><span>۰٪</span>
                    </div>
                    <div style="flex:1">
                        <div class="bars-area" id="perfBars"></div>
                        <div class="x-axis" id="perfX"></div>
                    </div>
                </div>
                <div class="legend"><span class="lg open">نرخ باز شدن</span><span class="lg book">نرخ رزرو</span><span
                        class="lg ret">نرخ بازگشت</span></div>
            </div>
        </div>

        <!-- جریان فعالیت -->
        <div class="card">
            <div class="card-title-row">
                <span class="card-title" style="display:flex;align-items:center;gap:9px"><svg width="18" height="18"
                        viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>جریان فعالیت کمپین‌ها</span>
                <div class="card-links"><a href="#">مشاهده همه</a></div>
            </div>
            <div id="actFeed"></div>
        </div>
    </div>

    <!-- ستون کناری -->
    <div class="rail">
        <div class="rail-card">
            <div class="rail-head"><span class="rail-label">اقدامات سریع</span></div>
            <button class="qa-primary"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.3" stroke-linecap="round">
                    <path d="M12 5v14M5 12h14" />
                </svg>ایجاد کمپین</button>
            <div id="quickActions"></div>
        </div>
        <div class="rail-card">
            <div class="rail-head"><span class="rail-label">هشدارهای هوشمند</span><span class="rail-n">۴</span></div>
            <div id="smartAlerts"></div>
        </div>
        <div class="rail-card">
            <div class="rail-head"><span class="rail-label">این ماه</span></div>
            <div id="monthStats"></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    /* داده‌ها */
const navItems=[
  {id:'dashboard',label:'داشبورد'},{id:'patients',label:'بیماران'},
  {id:'appointments',label:'نوبت‌ها'},{id:'calendar',label:'تقویم'},
  {id:'tasks',label:'مرکز وظایف'},{id:'growth',label:'کمپین‌های رشد',active:true},
  {id:'inventory',label:'انبار'},{id:'devices',label:'دستگاه‌ها'},
  {id:'finance',label:'مالی'},{id:'reports',label:'گزارش‌ها'},{id:'settings',label:'تنظیمات'},
];
const stats=[
  {t:'کمپین‌های فعال',v:'۱۲',pill:'۳+ این هفته',cls:'sp-green'},
  {t:'بیماران در دسترس',v:'۴٬۸۹۱',pill:'۱۲.۴٪+ نسبت به ماه قبل',cls:'sp-green'},
  {t:'بیماران بازگشته',v:'۳۴۷',pill:'۸۹ این هفته',cls:'sp-green'},
  {t:'درآمد ایجادشده',v:'۱٬۲۸۴ م ت',pill:'۱۸.۲٪+ نسبت به ماه قبل',cls:'sp-green'},
  {t:'کمپین‌های در انتظار',v:'۵',pill:'۲ مورد فردا اجرا می‌شود',cls:'sp-amber'},
  {t:'پیام‌های امروز',v:'۱٬۲۴۰',pill:'زمان‌بندی برای ۱۰:۰۰',cls:'sp-gray'},
];
const suggestions=[
  {name:'یادآوری ترمیم بوتاکس',chip:'آبی',ccls:'ch-blue',desc:'بیماران ۱۰ تا ۱۲ هفته پس از درمان',reach:'۲۸۴',ret:'۶۸٪',rev:'۴۲۶ م ت',conf:94,cc:'var(--green)',primary:true},
  {name:'بازیابی جلسات لیزر',chip:'بنفش',ccls:'ch-violet',desc:'پکیج‌های ناتمام لیزر، بیش از ۴۵ روز',reach:'۱۵۶',ret:'۵۵٪',rev:'۳۱۲ م ت',conf:87,cc:'var(--brand)'},
  {name:'بازگشت مشتریان VIP',chip:'کهربایی',ccls:'ch-amber',desc:'بیماران باارزش، بیش از ۶۰ روز غیرفعال',reach:'۷۳',ret:'۷۱٪',rev:'۵۸۴ م ت',conf:91,cc:'var(--green)',primary:true},
  {name:'کمپین تولد',chip:'صورتی',ccls:'ch-rose',desc:'تولدهای ۱۴ روز آینده — پیشنهاد هدیه',reach:'۴۸',ret:'۶۲٪',rev:'۱۴۴ م ت',conf:85,cc:'var(--brand)'},
  {name:'فروش مکمل مراقبت پوست',chip:'زمردی',ccls:'ch-emerald',desc:'بیماران بدون روتین فعال مراقبت پوست',reach:'۴۱۲',ret:'۳۴٪',rev:'۲۴۷ م ت',conf:76,cc:'#f59e0b'},
  {name:'تمدید پکیج',chip:'آبی',ccls:'ch-blue',desc:'پکیج‌هایی که ظرف ۳۰ روز منقضی می‌شوند',reach:'۹۱',ret:'۷۸٪',rev:'۳۶۴ م ت',conf:96,cc:'var(--green)',primary:true},
];
const campaigns=[
  {name:'ترمیم بوتاکس بهار',aud:'پس از درمان (۱۰ هفته)',chan:'پیامک + واتساپ',st:'active',stL:'فعال',date:'۲۶ دی ۱۴۰۳',conv:'۶۸٪',rev:'۴۲۶ م ت',roi:'۴.۸×'},
  {name:'بازگشت مشتریان VIP',aud:'بیماران VIP (۶۰ روز غیرفعال)',chan:'واتساپ + ایمیل',st:'active',stL:'فعال',date:'۲۹ دی ۱۴۰۳',conv:'۷۱٪',rev:'۳۱۲ م ت',roi:'۶.۲×'},
  {name:'کمپین هدیه تولد',aud:'تولدهای این ماه',chan:'پیامک + نوتیفیکیشن',st:'active',stL:'فعال',date:'۱۲ بهمن ۱۴۰۳',conv:'۶۲٪',rev:'۱۴۴ م ت',roi:'۳.۶×'},
  {name:'برنامه بازیابی لیزر',aud:'پکیج‌های ناتمام لیزر',chan:'ایمیل + دایرکت اینستاگرام',st:'sched',stL:'زمان‌بندی‌شده',date:'۲۱ بهمن ۱۴۰۳',conv:'—',rev:'—',roi:'—'},
  {name:'فروش مکمل مراقبت پوست',aud:'بدون روتین فعال',chan:'پیامک + ایمیل',st:'draft',stL:'پیش‌نویس',date:'۲۶ بهمن ۱۴۰۳',conv:'—',rev:'—',roi:'—'},
  {name:'یادآوری تازه‌سازی فیلر',aud:'بیماران فیلر (۶ ماه+)',chan:'واتساپ + تماس تلفنی',st:'done',stL:'تکمیل‌شده',date:'۲۰ آذر ۱۴۰۳',conv:'۵۹٪',rev:'۲۲۸ م ت',roi:'۵.۱×'},
];
const segments=[
  {icon:'clock',color:'amber',name:'بیماران غیرفعال',count:'۸۴۷ بیمار',rev:'۱٬۶۹۴ م ت',bcls:'ch-amber'},
  {icon:'star',color:'purple',name:'بیماران VIP',count:'۱۲۴ بیمار',rev:'۲٬۴۸۰ م ت',bcls:'ch-violet'},
  {icon:'zap',color:'brand',name:'بیماران لیزر',count:'۳۱۲ بیمار',rev:'۹۳۶ م ت',bcls:'ch-blue'},
  {icon:'syringe',color:'brand',name:'بیماران بوتاکس',count:'۵۸۴ بیمار',rev:'۱٬۷۵۲ م ت',bcls:'ch-blue'},
  {icon:'drop',color:'rose',name:'بیماران فیلر',count:'۲۶۷ بیمار',rev:'۸۰۱ م ت',bcls:'ch-rose'},
  {icon:'gem',color:'emerald',name:'ارزش عمر بالا',count:'۸۹ بیمار',rev:'۳٬۵۶۰ م ت',bcls:'ch-emerald'},
  {icon:'userplus',color:'teal',name:'مراجعان اولین‌بار',count:'۲۰۳ بیمار',rev:'۴۰۶ م ت',bcls:'ch-blue'},
  {icon:'refresh',color:'green',name:'موعد پیگیری',count:'۴۴۱ بیمار',rev:'۱٬۳۲۳ م ت',bcls:'ch-emerald'},
  {icon:'swap',color:'red',name:'درمان‌های ناتمام',count:'۱۷۸ بیمار',rev:'۸۹۰ م ت',bcls:'ch-rose'},
];
const channels=[
  {icon:'sms',label:'پیامک',color:'var(--brand)',active:true},
  {icon:'whatsapp',label:'واتساپ',color:'var(--green)',active:true},
  {icon:'email',label:'ایمیل',color:'var(--text-3)'},
  {icon:'push',label:'نوتیفیکیشن',color:'var(--text-3)'},
  {icon:'phone',label:'تماس تلفنی',color:'var(--text-3)'},
  {icon:'instagram',label:'دایرکت اینستاگرام',color:'var(--text-3)'},
];
const steps=[
  {icon:'send',day:'روز ۰',name:'یادآوری اولیه',desc:'پیامک و واتساپ شخصی‌سازی‌شده'},
  {icon:'chat',day:'روز ۳',name:'پیگیری',desc:'پیام بررسی همراه با پیشنهاد'},
  {icon:'tag',day:'روز ۷',name:'پیشنهاد ویژه',desc:'۱۰٪ تخفیف — زمان محدود'},
  {icon:'alarm',day:'روز ۱۴',name:'یادآوری نهایی',desc:'آخرین فرصت رزرو'},
];
const revData=[700,780,820,810,950,1284];
const revMonths=['شهریور','مهر','آبان','آذر','دی','بهمن'];
const perfData=[
  {open:82,book:58,ret:70},{open:85,book:60,ret:74},{open:86,book:62,ret:76},
  {open:84,book:59,ret:72},{open:88,book:63,ret:78},{open:88,book:63,ret:80},
];
const activity=[
  {icon:'growth',color:'brand',t:'کمپین ترمیم بوتاکس بهار آغاز شد',s:'۲۸۴ بیمار هدف‌گذاری شدند',time:'۲ دقیقه پیش'},
  {icon:'sms',color:'purple',t:'۲۸۴ پیامک به بخش بوتاکس ارسال شد',s:'تحویل‌شده: ۲۷۹ · ناموفق: ۵',time:'۴ دقیقه پیش'},
  {icon:'whatsapp',color:'green',t:'واتساپ به ۱۵۶ بیمار VIP تحویل شد',s:'رسید خوانده‌شدن: ۱۰۸ بیمار',time:'۱۱ دقیقه پیش'},
  {icon:'appointments',color:'brand',t:'سارا م. نوبت بوتاکس رزرو کرد',s:'از طریق لینک کمپین · ۲۳ بهمن، ۱۴:۳۰',time:'۱۸ دقیقه پیش'},
  {icon:'dollar',color:'green',t:'۱۲ میلیون تومان درآمد از کمپین VIP ثبت شد',s:'۳ رزرو تأیید شد',time:'۲۴ دقیقه پیش'},
  {icon:'check',color:'teal',t:'کمپین یادآوری تازه‌سازی فیلر تکمیل شد',s:'تبدیل ۵۹٪ · درآمد ۲۲۸ میلیون تومان',time:'۱ ساعت پیش'},
  {icon:'email',color:'amber',t:'ایمیل انبوه به ۴۱۲ بیمار مراقبت پوست ارسال شد',s:'نرخ باز شدن: ۶۱٪ · نرخ کلیک: ۲۸٪',time:'۲ ساعت پیش'},
  {icon:'appointments',color:'brand',t:'جیمز ت. جلسه لیزر رزرو کرد',s:'از طریق کمپین واتساپ · ۲۳ بهمن، ۱۶:۰۰',time:'۲ ساعت پیش'},
];
const quickActions=[
  {icon:'copy',label:'کپی کمپین'},
  {icon:'upload',label:'ورود بیماران'},
  {icon:'layers',label:'ایجاد بخش'},
  {icon:'calendar',label:'زمان‌بندی کمپین'},
];
const smartAlerts=[
  {cls:'sa-amber',icon:'clock',t:'ترمیم بوتاکس تا ۳ روز دیگر تمام می‌شود',d:'قبل از بستن نتایج را بررسی کنید'},
  {cls:'sa-green',icon:'zap',t:'بازگشت VIP: تبدیل ۷۱٪!',d:'بهترین کمپین شما در این ماه'},
  {cls:'sa-blue',icon:'cake',t:'۴۸ بیمار این هفته تولد دارند',d:'هیچ کمپین تولدی فعال نیست'},
  {cls:'sa-gray',icon:'warn',t:'بخش مراقبت پوست کمپین فعال ندارد',d:'۴۱۲ بیمار بدون ارتباط'},
];
const monthStats=[
  {l:'میانگین نرخ باز شدن',v:'۸۸٪'},
  {l:'میانگین نرخ پاسخ',v:'۵۲٪'},
  {l:'نرخ رزرو',v:'۶۳٪'},
  {l:'نرخ بازگشت بیمار',v:'۵۷٪'},
  {l:'بازگشت سرمایه کمپین',v:'۵.۴×'},
];

/* رندر */
document.getElementById('nav').innerHTML='<div class="nav-label">منوی اصلی</div>'+navItems.map(i=>`<a href="#" class="nav-item ${i.active?'active':''}" ${i.active?'aria-current="page"':''}>${svg(i.id)}<span>${i.label}</span></a>`).join('');

document.getElementById('statGrid').innerHTML=stats.map(s=>`
  <div class="stat-card"><div class="stat-title">${s.t}</div><div class="stat-val">${s.v}</div><span class="stat-pill ${s.cls}">${s.cls==='sp-green'?'↗ ':''}${s.pill}</span></div>`).join('');

document.getElementById('suggGrid').innerHTML=suggestions.map(s=>`
  <div class="sugg">
    <div class="sugg-top"><span class="sugg-name">${s.name}</span><span class="sugg-chip ${s.ccls}">${s.chip}</span></div>
    <div class="sugg-desc">${s.desc}</div>
    <div class="sugg-metrics">
      <div><div class="sm-l">دسترسی</div><div class="sm-v">${s.reach}</div></div>
      <div><div class="sm-l">بازگشت</div><div class="sm-v green">${s.ret}</div></div>
      <div><div class="sm-l">درآمد</div><div class="sm-v">${s.rev}</div></div>
    </div>
    <div class="conf-label">امتیاز اطمینان</div>
    <div class="conf-row">
      <div class="conf-bar"><div class="conf-fill" style="width:0;background:${s.cc}" data-w="${s.conf}"></div></div>
      <span class="conf-pct">${toFa(s.conf)}٪</span>
    </div>
    <button class="launch-btn ${s.primary?'launch-primary':'launch-ghost'}">اجرای کمپین</button>
  </div>`).join('');
requestAnimationFrame(()=>{ document.querySelectorAll('.conf-fill').forEach(f=>f.style.width=f.dataset.w+'%'); });

document.getElementById('campBody').innerHTML=campaigns.map(c=>`
  <tr>
    <td class="td-name">${c.name}</td><td class="td-mut">${c.aud}</td><td>${c.chan}</td>
    <td><span class="status st-${c.st}">${c.stL}</span></td>
    <td class="td-mut">${c.date}</td><td>${c.conv}</td>
    <td class="${c.rev!=='—'?'td-rev':'td-mut'}">${c.rev}</td><td class="td-roi">${c.roi}</td>
  </tr>`).join('');

document.getElementById('segGrid').innerHTML=segments.map(s=>`
  <div class="seg-card">
    <div class="seg-top">
      <span class="seg-ic" style="background:var(--${s.color}-soft);color:var(--${s.color})">${svg(s.icon,18)}</span>
      <div><div class="seg-name">${s.name}</div><div class="seg-count">${s.count}</div></div>
    </div>
    <div class="seg-bot">
      <div><div class="seg-rev-l">درآمد تخمینی</div><div class="seg-rev-v">${s.rev}</div></div>
      <button class="seg-btn ${s.bcls}">کمپین</button>
    </div>
  </div>`).join('');

document.getElementById('chanRow').innerHTML=channels.map(c=>`
  <button class="chan ${c.active?'active':''}"><span class="ci" style="color:${c.active?'':'var(--text-3)'}">${svg(c.icon,16)}</span>${c.label}</button>`).join('');

document.getElementById('steps').innerHTML=steps.map(s=>`
  <div class="step">
    <div class="step-ic">${svg(s.icon,19)}</div>
    <div class="step-day">${s.day}</div>
    <div class="step-name">${s.name}</div>
    <div class="step-desc">${s.desc}</div>
  </div>`).join('');

// نمودار خطی درآمد
(function(){
  const w=400,h=150,pad=4,min=600,max=1400;
  const pts=revData.map((v,i)=>{
    const x=pad+(i/(revData.length-1))*(w-pad*2);
    const y=h-pad-((v-min)/(max-min))*(h-pad*2);
    return [x,y];
  });
  const line=pts.map((p,i)=>(i===0?'M':'L')+p[0].toFixed(1)+' '+p[1].toFixed(1)).join(' ');
  const area=line+` L${pts[pts.length-1][0].toFixed(1)} ${h} L${pts[0][0].toFixed(1)} ${h} Z`;
  document.getElementById('revLine').innerHTML=`
    <svg viewBox="0 0 ${w} ${h}" preserveAspectRatio="none" style="width:100%;height:150px">
      <defs><linearGradient id="rg" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="var(--green)" stop-opacity="0.2"/><stop offset="100%" stop-color="var(--green)" stop-opacity="0"/></linearGradient></defs>
      ${[0,1,2,3].map(i=>`<line x1="0" y1="${(h/4)*i}" x2="${w}" y2="${(h/4)*i}" stroke="var(--border)" stroke-dasharray="3 4" stroke-width="1"/>`).join('')}
      <path d="${area}" fill="url(#rg)"/>
      <path d="${line}" fill="none" stroke="var(--green)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="900" stroke-dashoffset="900"><animate attributeName="stroke-dashoffset" from="900" to="0" dur="1.3s" fill="freeze" calcMode="spline" keySplines="0.16 1 0.3 1" keyTimes="0;1"/></path>
    </svg>`;
  document.getElementById('revX').innerHTML=revMonths.map(m=>`<span>${m}</span>`).join('');
})();

document.getElementById('perfBars').innerHTML=perfData.map(d=>`
  <div class="bar-group">
    <div class="bar" style="height:0;background:var(--brand)" data-h="${d.open}"></div>
    <div class="bar" style="height:0;background:var(--green)" data-h="${d.book}"></div>
    <div class="bar" style="height:0;background:var(--violet)" data-h="${d.ret}"></div>
  </div>`).join('');
document.getElementById('perfX').innerHTML=revMonths.map(m=>`<span>${m}</span>`).join('');
requestAnimationFrame(()=>{ document.querySelectorAll('.bar').forEach(b=>b.style.height=b.dataset.h+'%'); });

document.getElementById('actFeed').innerHTML=activity.map(a=>`
  <div class="act-row">
    <span class="act-ic" style="background:var(--${a.color}-soft);color:var(--${a.color})">${svg(a.icon,16)}</span>
    <div class="act-body"><div class="act-t">${a.t}</div><div class="act-s">${a.s}</div></div>
    <span class="act-time">${a.time}</span>
  </div>`).join('');

document.getElementById('quickActions').innerHTML=quickActions.map(q=>`
  <button class="qa-row"><span class="qi">${svg(q.icon,17)}</span>${q.label}</button>`).join('');

document.getElementById('smartAlerts').innerHTML=smartAlerts.map(a=>`
  <div class="smart-alert ${a.cls}"><span class="sa-ic">${svg(a.icon,17)}</span><div><div class="sa-t">${a.t}</div><div class="sa-d">${a.d}</div></div></div>`).join('');

document.getElementById('monthStats').innerHTML=monthStats.map(m=>`
  <div class="month-row"><span class="month-l">${m.l}</span><span class="month-v">${m.v}</span></div>`).join('');

/* تعامل‌ها */
document.getElementById('chanRow').addEventListener('click',e=>{
  const c=e.target.closest('.chan'); if(!c)return;
  c.classList.toggle('active');
});
</script>
@endsection