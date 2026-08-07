@extends('layout.master')

@section('title')
اوراکلینیک — داشبورد مدیریتی
@endsection

@section('name-page')
داشبورد مدیریتی
@endsection

@section('btn')

@endsection

@section('text-search')
@endsection

@section('subtitle')
جمعه، ۲۰ تیر ۱۴۰۴ · کلینیک مرکزی
@endsection

@section('head')

<style>
    .body-grid {
        display: grid;
        grid-template-columns: 1fr var(--rail-w);
        gap: var(--gap);
        padding: 20px;
        align-items: start;
    }

    .ex-main {
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
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 19px;
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
        gap: 8px;
    }

    .stat-title {
        font-size: .72rem;
        font-weight: 700;
        color: var(--text-3);
        letter-spacing: .05em;
    }

    .stat-ic {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .stat-val {
        font-size: 1.85rem;
        font-weight: 700;
        letter-spacing: -.025em;
        line-height: 1.1;
    }

    .stat-foot {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .stat-delta {
        font-size: .8rem;
        font-weight: 600;
        color: var(--green);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-note {
        font-size: .8rem;
        color: var(--text-3);
    }

    /* سلامت کسب‌وکار + فرصت‌ها */
    .grid-health {
        display: grid;
        grid-template-columns: .85fr 1.6fr;
        gap: var(--gap);
        align-items: start;
    }

    .bh-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 20px;
    }

    .bh-t {
        font-size: 1.08rem;
        font-weight: 700;
    }

    .bh-s {
        font-size: .83rem;
        color: var(--text-3);
        margin-top: 2px;
    }

    .bh-delta {
        background: var(--green-soft);
        color: var(--green);
        font-size: .8rem;
        font-weight: 600;
        padding: 7px 13px;
        border-radius: var(--r-md);
        white-space: nowrap;
    }

    .bh-body {
        display: flex;
        align-items: center;
        gap: 22px;
        flex-wrap: wrap;
    }

    .bh-ring {
        position: relative;
        flex-shrink: 0;
    }

    .bh-ring svg {
        width: 150px;
        height: 150px;
    }

    .bh-center {
        position: absolute;
        inset: 0;
        display: grid;
        place-items: center;
        text-align: center;
    }

    .bh-score {
        font-size: 2.4rem;
        font-weight: 700;
        letter-spacing: -.03em;
        line-height: 1;
    }

    .bh-of {
        font-size: .78rem;
        color: var(--text-3);
        margin-top: 2px;
    }

    .bh-tag {
        display: inline-block;
        background: var(--green-soft);
        color: var(--green);
        font-size: .74rem;
        font-weight: 600;
        padding: 2px 11px;
        border-radius: 20px;
        margin-top: 5px;
    }

    .bh-metrics {
        flex: 1;
        min-width: 180px;
    }

    .bh-m {
        margin-bottom: 14px;
    }

    .bh-m:last-child {
        margin-bottom: 0;
    }

    .bh-m-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: .86rem;
    }

    .bh-m-l {
        color: var(--text-2);
    }

    .bh-m-v {
        font-weight: 700;
    }

    .bh-m-bar {
        height: 5px;
        border-radius: 20px;
        background: var(--surface-2);
        overflow: hidden;
    }

    .bh-m-fill {
        height: 100%;
        border-radius: 20px;
        transition: width 1s cubic-bezier(.16, 1, .3, 1);
    }

    /* فرصت‌های درآمد */
    .card-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 14px;
        padding: 20px 20px 14px;
        flex-wrap: wrap;
    }

    .card-title {
        font-size: 1.08rem;
        font-weight: 700;
    }

    .card-sub {
        font-size: .83rem;
        color: var(--text-3);
        margin-top: 2px;
    }

    .card-sub b {
        color: var(--green);
        font-weight: 700;
    }

    .card-link {
        color: var(--brand);
        font-weight: 600;
        font-size: .86rem;
        white-space: nowrap;
    }

    .opp {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        transition: background .15s ease;
        cursor: pointer;
    }

    .opp:last-child {
        border-bottom: none;
    }

    .opp:hover {
        background: var(--surface-2);
    }

    .opp-ic {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .opp-body {
        flex: 1;
        min-width: 0;
    }

    .opp-top {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
    }

    .opp-name {
        font-weight: 700;
        font-size: .95rem;
    }

    .opp-chip {
        font-size: .72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .opp-desc {
        font-size: .83rem;
        color: var(--text-3);
        margin-top: 2px;
    }

    .opp-val {
        text-align: left;
        white-space: nowrap;
    }

    .opp-amt {
        font-weight: 700;
        font-size: .98rem;
        font-family: ui-monospace, monospace;
    }

    .opp-lbl {
        font-size: .74rem;
        color: var(--text-3);
    }

    .opp-arrow {
        color: var(--brand);
        flex-shrink: 0;
    }

    /* نمودارها */
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--gap);
    }

    .chart-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .chart-t {
        font-size: 1.05rem;
        font-weight: 700;
    }

    .chart-s {
        font-size: .84rem;
        color: var(--text-2);
        margin-top: 2px;
    }

    .chart-s b {
        color: var(--green);
    }

    .chart-s .mut {
        color: var(--text-3);
    }

    .seg-tabs {
        display: inline-flex;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 3px;
    }

    .seg-tab {
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: .83rem;
        color: var(--text-2);
        transition: all .18s ease;
        white-space: nowrap;
    }

    .seg-tab.active {
        background: var(--surface);
        color: var(--text);
        box-shadow: var(--shadow-sm);
    }

    .chart-box {
        display: flex;
        gap: 10px;
    }

    .y-axis {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: .7rem;
        color: var(--text-3);
        text-align: left;
        padding-bottom: 22px;
    }

    .chart-area {
        flex: 1;
        min-width: 0;
    }

    .chart-area svg {
        width: 100%;
        height: 180px;
        display: block;
    }

    .x-axis {
        display: flex;
        justify-content: space-between;
        font-size: .73rem;
        color: var(--text-3);
        margin-top: 6px;
    }

    /* جدول */
    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 680px;
    }

    thead th {
        text-align: right;
        font-size: .68rem;
        font-weight: 700;
        color: var(--text-3);
        letter-spacing: .05em;
        padding: 11px 20px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        font-size: .88rem;
        vertical-align: middle;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr:hover {
        background: var(--surface-2);
    }

    .doc-cell {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .doc-av {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--brand-soft);
        color: var(--brand);
        display: grid;
        place-items: center;
        font-size: .72rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .doc-nm {
        font-weight: 600;
    }

    .doc-sp {
        font-size: .78rem;
        color: var(--text-3);
    }

    .mono {
        font-family: ui-monospace, monospace;
        font-weight: 600;
    }

    .conv-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 110px;
    }

    .conv-bar {
        flex: 1;
        height: 6px;
        border-radius: 20px;
        background: var(--surface-2);
        overflow: hidden;
    }

    .conv-fill {
        height: 100%;
        border-radius: 20px;
        background: var(--brand);
    }

    .rating {
        color: var(--gold);
        font-weight: 600;
        white-space: nowrap;
    }

    .score-badge {
        display: inline-grid;
        place-items: center;
        min-width: 38px;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 700;
        font-size: .86rem;
    }

    .sc-green {
        background: var(--green-soft);
        color: var(--green);
    }

    .sc-blue {
        background: var(--brand-soft);
        color: var(--brand);
    }

    .sc-amber {
        background: var(--amber-soft);
        color: var(--amber);
    }

    /* عملکرد دستگاه */
    .dev-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        padding: 0 20px 20px;
    }

    .dev-card {
        border: 1px solid var(--border);
        border-radius: var(--r-md);
        padding: 16px;
    }

    .dev-card.due {
        background: var(--red-soft);
        border-color: color-mix(in srgb, var(--red) 22%, transparent);
    }

    .dev-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .dev-ic {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: var(--brand-soft);
        color: var(--brand);
        display: grid;
        place-items: center;
    }

    .dev-card.due .dev-ic {
        background: var(--red-soft);
        color: var(--red);
    }

    .dev-badge {
        font-size: .7rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .db-active {
        background: var(--green-soft);
        color: var(--green);
    }

    .db-due {
        background: var(--red-soft);
        color: var(--red);
        border: 1px solid color-mix(in srgb, var(--red) 25%, transparent);
    }

    .dev-name {
        font-weight: 700;
        font-size: .92rem;
    }

    .dev-roi {
        color: var(--brand);
        font-weight: 700;
        font-size: .84rem;
        margin: 2px 0 12px;
    }

    .dev-row {
        display: flex;
        justify-content: space-between;
        font-size: .8rem;
        padding: 3px 0;
    }

    .dev-row .l {
        color: var(--text-2);
    }

    .dev-row .v {
        font-weight: 600;
        font-family: ui-monospace, monospace;
    }

    .dev-bar {
        height: 5px;
        border-radius: 20px;
        background: var(--surface-2);
        overflow: hidden;
        margin: 5px 0 8px;
    }

    .dev-fill {
        height: 100%;
        border-radius: 20px;
    }

    /* انبار */
    .inv-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
        padding: 0 20px 20px;
    }

    .inv-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: .88rem;
        margin-bottom: 12px;
    }

    .inv-label.low {
        color: var(--red);
    }

    .inv-label.exp {
        color: var(--amber);
    }

    .inv-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 13px 15px;
        border-radius: var(--r-md);
        margin-bottom: 10px;
    }

    .inv-row:last-child {
        margin-bottom: 0;
    }

    .inv-row.low {
        background: var(--red-soft);
        border: 1px solid color-mix(in srgb, var(--red) 18%, transparent);
    }

    .inv-row.exp {
        background: var(--amber-soft);
        border: 1px solid color-mix(in srgb, var(--amber) 18%, transparent);
    }

    .inv-row.plain {
        background: var(--surface-2);
        border: 1px solid var(--border);
    }

    .inv-nm {
        font-weight: 600;
        font-size: .9rem;
    }

    .inv-right {
        text-align: left;
        white-space: nowrap;
    }

    .inv-v {
        font-weight: 700;
        font-size: .88rem;
    }

    .inv-v.red {
        color: var(--red);
    }

    .inv-v.amber {
        color: var(--amber);
    }

    .inv-s {
        font-size: .76rem;
        color: var(--text-3);
    }

    /* بینش AI */
    .ai-head {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 20px 20px 16px;
        flex-wrap: wrap;
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
        font-size: 1.08rem;
    }

    .ai-s {
        font-size: .83rem;
        color: var(--text-3);
    }

    .ai-s b {
        color: var(--green);
    }

    .ai-live {
        margin-inline-start: auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--brand-soft);
        color: var(--brand);
        font-size: .8rem;
        font-weight: 600;
        padding: 6px 13px;
        border-radius: 20px;
    }

    .ai-live::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .ai-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        padding: 0 20px 20px;
    }

    .ai-card {
        border: 1px solid var(--border);
        border-radius: var(--r-md);
        padding: 18px;
    }

    .ai-card.high {
        background: var(--brand-soft);
        border-color: color-mix(in srgb, var(--brand) 20%, transparent);
    }

    .ai-card.crit {
        background: var(--red-soft);
        border-color: color-mix(in srgb, var(--red) 20%, transparent);
    }

    .ai-card.med {
        background: var(--amber-soft);
        border-color: color-mix(in srgb, var(--amber) 20%, transparent);
    }

    .ai-card.medg {
        background: var(--green-soft);
        border-color: color-mix(in srgb, var(--green) 20%, transparent);
    }

    .ai-c-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 13px;
        flex-wrap: wrap;
    }

    .ai-prio {
        font-size: .74rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        color: #fff;
    }

    .p-high {
        background: var(--brand);
    }

    .p-crit {
        background: var(--red);
    }

    .p-med {
        background: #f0d998;
        color: #8a6d1f;
    }

    .p-medg {
        background: #bfeada;
        color: #0b6b4c;
    }

    html[data-theme="dark"] .p-med {
        background: #4a3d16;
        color: #fbbf24;
    }

    html[data-theme="dark"] .p-medg {
        background: #164034;
        color: #34d399;
    }

    .ai-gain {
        font-weight: 700;
        font-size: .94rem;
        font-family: ui-monospace, monospace;
    }

    .ai-c-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .ai-c-desc {
        font-size: .87rem;
        color: var(--text-2);
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .ai-btn {
        width: 100%;
        padding: 12px;
        border-radius: var(--r-md);
        font-weight: 600;
        font-size: .9rem;
        transition: filter .18s ease;
    }

    .ai-btn:hover {
        filter: brightness(1.06);
    }

    .b-blue {
        background: var(--brand);
        color: #fff;
    }

    .b-red {
        background: var(--red);
        color: #fff;
    }

    .b-amber {
        background: #f5e2b0;
        color: #8a6d1f;
    }

    .b-green {
        background: #c7ecdd;
        color: #0b6b4c;
    }

    html[data-theme="dark"] .b-amber {
        background: #4a3d16;
        color: #fbbf24;
    }

    html[data-theme="dark"] .b-green {
        background: #164034;
        color: #34d399;
    }

    .pred-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--r-md);
        margin: 0 20px 20px;
    }

    .pred {
        text-align: center;
        padding: 18px 12px;
        border-inline-end: 1px solid var(--border);
    }

    .pred:last-child {
        border-inline-end: none;
    }

    .pred-l {
        font-size: .82rem;
        color: var(--text-3);
    }

    .pred-v {
        font-size: 1.5rem;
        font-weight: 700;
        margin-top: 5px;
        font-family: ui-monospace, monospace;
    }

    .pred-s {
        font-size: .78rem;
        color: var(--green);
        margin-top: 3px;
    }

    .pred-s.mut {
        color: var(--text-3);
    }

    /* جریان فعالیت */
    .af {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border);
    }

    .af:last-child {
        border-bottom: none;
    }

    .af-ic {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .af-body {
        flex: 1;
        min-width: 0;
    }

    .af-t {
        font-weight: 600;
        font-size: .92rem;
    }

    .af-d {
        font-size: .83rem;
        color: var(--text-3);
        margin-top: 1px;
    }

    .af-time {
        font-size: .79rem;
        color: var(--text-3);
        white-space: nowrap;
    }

    /* ستون کناری */
    .rail {
        position: sticky;
        top: calc(65px + 20px);
        display: flex;
        flex-direction: column;
        gap: var(--gap);
    }

    .rail-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
        padding: 17px;
    }

    .rail-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .rail-title {
        font-weight: 700;
        font-size: 1.05rem;
    }

    .rail-n {
        background: var(--red);
        color: #fff;
        font-size: .7rem;
        font-weight: 700;
        min-width: 22px;
        height: 22px;
        border-radius: 20px;
        display: grid;
        place-items: center;
        padding: 0 6px;
    }

    .rail-sec {
        font-size: .94rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .alert-item {
        border-radius: var(--r-md);
        padding: 13px;
        margin-bottom: 10px;
        display: flex;
        gap: 11px;
    }

    .alert-item:last-child {
        margin-bottom: 0;
    }

    .ai-red {
        background: var(--red-soft);
    }

    .ai-amber {
        background: var(--amber-soft);
    }

    .ai-blue {
        background: var(--brand-soft);
    }

    .al-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 6px;
    }

    .ai-red .al-dot {
        background: var(--red);
    }

    .ai-amber .al-dot {
        background: var(--amber);
    }

    .ai-blue .al-dot {
        background: var(--brand);
    }

    .al-body {
        flex: 1;
        min-width: 0;
    }

    .al-top {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        align-items: baseline;
    }

    .al-t {
        font-weight: 700;
        font-size: .87rem;
    }

    .ai-red .al-t {
        color: var(--red);
    }

    .ai-amber .al-t {
        color: var(--amber);
    }

    .ai-blue .al-t {
        color: var(--brand);
    }

    .al-time {
        font-size: .74rem;
        color: var(--text-3);
        white-space: nowrap;
    }

    .al-d {
        font-size: .81rem;
        color: var(--text-2);
        margin-top: 3px;
    }

    .qa-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 11px;
    }

    .qa-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px 10px;
        border-radius: var(--r-md);
        border: 1px solid var(--border);
        font-weight: 600;
        font-size: .84rem;
        color: var(--text-2);
        text-align: center;
        transition: all .18s ease;
        min-height: 82px;
    }

    .qa-btn:hover {
        background: var(--surface-2);
        border-color: var(--border-strong);
        color: var(--text);
    }

    .qa-btn.blue {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }

    .qa-btn.green {
        background: var(--green);
        border-color: var(--green);
        color: #fff;
    }

    .qa-btn.blue:hover,
    .qa-btn.green:hover {
        filter: brightness(1.08);
    }

    .pred-card {
        background: linear-gradient(150deg, var(--brand), #4f46e5);
        color: #fff;
        border-radius: var(--r-lg);
        padding: 18px;
        box-shadow: var(--shadow-md);
    }

    .pc-head {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: .92rem;
        margin-bottom: 14px;
    }

    .pc-l {
        font-size: .8rem;
        opacity: .85;
    }

    .pc-v {
        font-size: 1.7rem;
        font-weight: 700;
        font-family: ui-monospace, monospace;
        margin-top: 2px;
    }

    .pc-d {
        font-size: .8rem;
        opacity: .9;
        margin-top: 3px;
    }

    .pc-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, .22);
    }

    .pc-s-l {
        font-size: .78rem;
        opacity: .85;
    }

    .pc-s-v {
        font-size: 1.1rem;
        font-weight: 700;
        margin-top: 2px;
    }

    .cs-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-size: .88rem;
        border-bottom: 1px solid var(--border);
    }

    .cs-row:last-child {
        border-bottom: none;
    }

    .cs-l {
        color: var(--text-2);
    }

    .cs-v {
        font-weight: 700;
        font-family: ui-monospace, monospace;
    }

    .cs-v.amber {
        color: var(--amber);
    }

    .cs-v.red {
        color: var(--red);
    }

    .menu-toggle {
        display: none;
    }

    .overlay {
        display: none;
    }

    @media (max-width:1500px) {
        .dev-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width:1280px) {
        .body-grid {
            grid-template-columns: 1fr;
        }

        .rail {
            position: static;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .stat-grid {
            grid-template-columns: 1fr 1fr;
        }

        .grid-health {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width:1024px) {
        .grid-2 {
            grid-template-columns: 1fr;
        }

        .ai-grid {
            grid-template-columns: 1fr;
        }

        .dev-grid {
            grid-template-columns: 1fr 1fr;
        }

        .inv-grid {
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
            gap: 9px;
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

        .dev-grid {
            grid-template-columns: 1fr;
        }

        .pred-row {
            grid-template-columns: 1fr;
        }

        .pred {
            border-inline-end: none;
            border-bottom: 1px solid var(--border);
        }

        .pred:last-child {
            border-bottom: none;
        }
    }

    @media (max-width:560px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 1.3rem;
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


@section('content')

<div class="body-grid">
    <div class="ex-main">

        <div class="stat-grid" id="statGrid"></div>

        <!-- سلامت کسب‌وکار + فرصت‌ها -->
        <div class="grid-health">
            <div class="card card-pad">
                <div class="bh-head">
                    <div>
                        <div class="bh-t">امتیاز سلامت کسب‌وکار</div>
                        <div class="bh-s">شاخص کلی عملکرد کلینیک</div>
                    </div>
                    <span class="bh-delta">↗ ۴+ امتیاز این ماه</span>
                </div>
                <div class="bh-body">
                    <div class="bh-ring">
                        <svg viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="52" fill="none" stroke="var(--surface-2)" stroke-width="11" />
                            <circle id="bhArc" cx="60" cy="60" r="52" fill="none" stroke="var(--brand)"
                                stroke-width="11" stroke-linecap="round" stroke-dasharray="326.7"
                                stroke-dashoffset="326.7" transform="rotate(-90 60 60)" />
                        </svg>
                        <div class="bh-center">
                            <div>
                                <div class="bh-score">۷۸</div>
                                <div class="bh-of">از ۱۰۰</div>
                                <span class="bh-tag">خوب</span>
                            </div>
                        </div>
                    </div>
                    <div class="bh-metrics" id="bhMetrics"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-title-row">
                    <div>
                        <div class="card-title">فرصت‌های درآمد</div>
                        <div class="card-sub"><b>۱٬۴۶۶ م ت</b> قابل بازیابی در این ماه</div>
                    </div>
                    <a href="#" class="card-link">مشاهده همه ‹</a>
                </div>
                <div id="opps"></div>
            </div>
        </div>

        <!-- نمودارها -->
        <div class="grid-2">
            <div class="card card-pad">
                <div class="chart-head">
                    <div>
                        <div class="chart-t">تحلیل درآمد</div>
                        <div class="chart-s">۲٬۸۴۶ م ت <span class="mut">از ابتدای ماه</span> · <b>۸.۷٪ بالاتر از
                                هدف</b></div>
                    </div>
                    <div class="seg-tabs" id="revTabs"><button class="seg-tab active">روزانه</button><button
                            class="seg-tab">ماهانه</button><button class="seg-tab">بر اساس درمان</button></div>
                </div>
                <div class="chart-box">
                    <div class="y-axis">
                        <span>۲۰۰م</span><span>۱۵۰م</span><span>۱۰۰م</span><span>۵۰م</span><span>۰</span>
                    </div>
                    <div class="chart-area">
                        <div id="revChart"></div>
                        <div class="x-axis" id="revX"></div>
                    </div>
                </div>
            </div>
            <div class="card card-pad">
                <div class="chart-head">
                    <div>
                        <div class="chart-t">تحلیل بیماران</div>
                        <div class="chart-s">۷۲ بیمار جدید <span class="mut">این ماه</span> · <b>۸۸٪ نگهداشت</b></div>
                    </div>
                    <div class="seg-tabs" id="patTabs"><button class="seg-tab active">جذب</button><button
                            class="seg-tab">نگهداشت و ارزش عمر</button></div>
                </div>
                <div class="chart-box">
                    <div class="y-axis"><span>۲۰۰</span><span>۱۵۰</span><span>۱۰۰</span><span>۵۰</span><span>۰</span>
                    </div>
                    <div class="chart-area">
                        <div id="patChart"></div>
                        <div class="x-axis" id="patX"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- عملکرد پزشکان -->
        <div class="card">
            <div class="card-title-row">
                <div>
                    <div class="card-title">عملکرد پزشکان</div>
                    <div class="card-sub">رتبه‌بندی بر اساس امتیاز عملکرد · تیر ۱۴۰۴</div>
                </div>
                <a href="#" class="card-link">گزارش کامل ‹</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>پزشک</th>
                            <th>درآمد ماه</th>
                            <th>نوبت‌ها</th>
                            <th>نرخ تبدیل</th>
                            <th>امتیاز بیماران</th>
                            <th>میانگین فاکتور</th>
                            <th>امتیاز</th>
                        </tr>
                    </thead>
                    <tbody id="docBody"></tbody>
                </table>
            </div>
        </div>

        <!-- عملکرد دستگاه -->
        <div class="card">
            <div class="card-title-row">
                <div>
                    <div class="card-title">عملکرد دستگاه‌ها</div>
                    <div class="card-sub">۵ دستگاه فعال · ۱٬۴۷۲ م ت درآمد ماهانه</div>
                </div>
            </div>
            <div class="dev-grid" id="devGrid"></div>
        </div>

        <!-- عملکرد کمپین -->
        <div class="card">
            <div class="card-title-row">
                <div>
                    <div class="card-title">عملکرد کمپین‌ها</div>
                    <div class="card-sub">۵ کمپین · ۱٬۷۴۷ م ت درآمد ایجادشده</div>
                </div>
                <button class="qa-btn blue"
                    style="flex-direction:row;min-height:auto;padding:9px 17px;border-radius:20px"><svg width="15"
                        height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"
                        stroke-linecap="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>کمپین جدید</button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>کمپین</th>
                            <th>بیماران هدف</th>
                            <th>رزروها</th>
                            <th>درآمد</th>
                            <th>بازگشت سرمایه</th>
                            <th>نرخ تبدیل</th>
                            <th>وضعیت</th>
                        </tr>
                    </thead>
                    <tbody id="campBody"></tbody>
                </table>
            </div>
        </div>

        <!-- وضعیت انبار -->
        <div class="card">
            <div class="card-title-row">
                <div>
                    <div class="card-title">وضعیت انبار</div>
                    <div class="card-sub">۱٬۴۲۸ م ت ارزش کل · ۳ سفارش در انتظار</div>
                </div>
                <button class="pill-btn"><svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6" />
                    </svg>سفارش جدید</button>
            </div>
            <div class="inv-grid">
                <div>
                    <div class="inv-label low"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            <path d="M12 9v4M12 17h.01" />
                        </svg>موجودی کم</div>
                    <div id="lowStock"></div>
                </div>
                <div>
                    <div class="inv-label exp"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>انقضای نزدیک</div>
                    <div id="expSoon"></div>
                </div>
            </div>
        </div>

        <!-- بینش AI -->
        <div class="card">
            <div class="ai-head">
                <span class="ai-ic"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4" />
                    </svg></span>
                <div>
                    <div class="ai-t">بینش‌های هوش مصنوعی کسب‌وکار</div>
                    <div class="ai-s">۴ توصیه · <b>۹۹۲ م ت</b> فرصت شناسایی‌شده</div>
                </div>
                <span class="ai-live">تحلیل زنده داده‌های کلینیک</span>
            </div>
            <div class="ai-grid" id="aiGrid"></div>
            <div class="pred-row">
                <div class="pred">
                    <div class="pred-l">درآمد پیش‌بینی‌شده ماهانه</div>
                    <div class="pred-v">۳٬۱۲۴ م ت</div>
                    <div class="pred-s">۹.۸٪+ نسبت به ماه قبل</div>
                </div>
                <div class="pred">
                    <div class="pred-l">رشد پیش‌بینی‌شده بیماران</div>
                    <div class="pred-v">۳۴+ بیمار</div>
                    <div class="pred-s">جدید + بازگشته</div>
                </div>
                <div class="pred">
                    <div class="pred-l">امتیاز اطمینان هوش مصنوعی</div>
                    <div class="pred-v">۸۷٪</div>
                    <div class="pred-s mut">بر اساس داده ۶ ماه</div>
                </div>
            </div>
        </div>

        <!-- جریان فعالیت -->
        <div class="card">
            <div class="card-title-row"><span class="card-title">جریان فعالیت</span><a href="#" class="card-link">مشاهده
                    همه ‹</a></div>
            <div id="feed"></div>
        </div>
    </div>

    <!-- ستون کناری -->
    <div class="rail">
        <div class="rail-card">
            <div class="rail-top"><span class="rail-title">مرکز فرماندهی</span></div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:13px">
                <span class="rail-sec" style="margin-bottom:0">هشدارهای امروز</span>
                <span class="rail-n">۵</span>
            </div>
            <div id="alerts"></div>
        </div>

        <div class="rail-card">
            <div class="rail-sec">اقدامات سریع</div>
            <div class="qa-grid" id="quickActions"></div>
        </div>

        <div class="pred-card">
            <div class="pc-head"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4" />
                </svg>پیش‌بینی هوش مصنوعی</div>
            <div class="pc-l">درآمد پیش‌بینی‌شده ماهانه</div>
            <div class="pc-v">۳٬۱۲۴ م ت</div>
            <div class="pc-d">↗ ۹.۸٪ نسبت به ماه قبل</div>
            <div class="pc-split">
                <div>
                    <div class="pc-s-l">رشد بیماران</div>
                    <div class="pc-s-v">۳۴+</div>
                </div>
                <div>
                    <div class="pc-s-l">اطمینان</div>
                    <div class="pc-s-v">۸۷٪</div>
                </div>
            </div>
        </div>

        <div class="rail-card">
            <div class="rail-sec">وضعیت کلینیک</div>
            <div id="clinicStatus"></div>
        </div>

    </div>

</div>

@endsection

@section('js')

<script>
    const navMain=[
  {id:'dashboard',label:'داشبورد مدیریتی',active:true},{id:'patients',label:'بیماران'},
  {id:'appointments',label:'نوبت‌ها'},{id:'calendar',label:'تقویم'},
  {id:'tasks',label:'مرکز وظایف',badge:3},
];
const navOps=[
  {id:'growth',label:'کمپین‌های رشد'},{id:'inventory',label:'انبار',alert:true},
  {id:'devices',label:'دستگاه‌ها'},{id:'finance',label:'مالی'},
  {id:'reports',label:'گزارش‌ها'},{id:'settings',label:'تنظیمات'},
];
const stats=[
  {t:'درآمد امروز',icon:'dollar',color:'green',v:'۱۸۴ م ت',d:'۱۲.۳٪+ نسبت به دیروز'},
  {t:'درآمد ماهانه',icon:'trend',color:'brand',v:'۲٬۸۴۶ م ت',d:'۸.۷٪+ بالاتر از هدف'},
  {t:'سود خالص',icon:'medal',color:'purple',v:'۸۹۳ م ت',d:'۵.۲٪+ نسبت به ماه قبل'},
  {t:'نوبت‌های امروز',icon:'appointments',color:'brand',v:'۳۴',note:'۲ بازه هنوز آزاد است'},
  {t:'درمان‌های انجام‌شده',icon:'activity',color:'green',v:'۲۸',d:'۴+ نسبت به دیروز',note:'نرخ تکمیل ۸۲٪'},
  {t:'بیماران جدید',icon:'userplus',color:'brand',v:'۷',d:'۲+ نسبت به هفته قبل'},
  {t:'بیماران بازگشته',icon:'heart',color:'rose',v:'۲۷',d:'۳+ نسبت به هفته قبل',note:'۷۹.۴٪ از امروز'},
  {t:'نرخ عدم‌حضور',icon:'alertcircle',color:'amber',v:'۸.۲٪',d:'۱.۱٪− نسبت به ماه قبل',note:'۳ عدم‌حضور امروز'},
];
const bhMetrics=[
  {l:'مالی',v:82,color:'var(--brand)'},
  {l:'عملیات',v:75,color:'var(--green)'},
  {l:'بازاریابی',v:71,color:'var(--purple)'},
  {l:'نگهداشت مشتری',v:84,color:'#f59e0b'},
  {l:'انبار',v:73,color:'var(--red)'},
];
const opps=[
  {icon:'zap',color:'brand',name:'بیماران آماده بوتاکس',chip:'۴۷ بیمار',ccls:'brand',desc:'گذشته از بازه بهینه تمدید (۳ تا ۴ ماه)',amt:'۲۸۲ م ت'},
  {icon:'target',color:'purple',name:'خط لوله درمان لیزر',chip:'۲۳ بیمار',ccls:'purple',desc:'مشاوره شده اما هنوز رزرو نکرده‌اند',amt:'۴۱۴ م ت'},
  {icon:'star',color:'gold',name:'بیماران VIP غیرفعال',chip:'۱۲ بیمار',ccls:'gold',desc:'بیماران باارزش — بدون مراجعه بیش از ۹۰ روز',amt:'۱۹۸ م ت'},
  {icon:'refresh',color:'rose',name:'لغوشده‌های این ماه',chip:'۳۱ بیمار',ccls:'rose',desc:'قابل رزرو مجدد با ارتباط هدفمند',amt:'۲۴۸ م ت'},
  {icon:'checksq',color:'green',name:'برنامه‌های درمانی ناتمام',chip:'۱۸ بیمار',ccls:'green',desc:'بیماران میانه سری — در انتظار تکمیل',amt:'۳۲۴ م ت'},
];
const revData=[92,105,148,122,98,135,110,158,132,90,175,182];
const revDays=['۲۸ خرداد','۳۱ خرداد','۳ تیر','۶ تیر','۹ تیر','۱۲ تیر'];
const patData=[52,58,60,62,61,58,62,64,66,68,70,72];
const patMonths=['بهمن','اسفند','فروردین','اردیبهشت','خرداد','تیر'];
const doctors=[
  {init:'س‌چ',name:'دکتر سارا چن',spec:'بوتاکس و فیلر',rev:'۸۴۲ م ت',appt:'۱۵۶',conv:94,rating:'۴.۹',ticket:'۵.۴ م ت',score:'۹۷',scls:'sc-green'},
  {init:'م‌ر',name:'دکتر مارکو ریس',spec:'درمان‌های لیزری',rev:'۷۱۸ م ت',appt:'۱۳۴',conv:89,rating:'۴.۷',ticket:'۵.۳ م ت',score:'۹۱',scls:'sc-green'},
  {init:'ع‌پ',name:'دکتر عایشه پاتل',spec:'جوان‌سازی پوست',rev:'۶۲۴ م ت',appt:'۱۱۸',conv:86,rating:'۴.۸',ticket:'۵.۲ م ت',score:'۸۷',scls:'sc-blue'},
  {init:'ج‌ل',name:'دکتر جیمز لیو',spec:'فرم‌دهی بدن',rev:'۴۸۶ م ت',appt:'۱۰۲',conv:82,rating:'۴.۶',ticket:'۴.۷ م ت',score:'۸۱',scls:'sc-blue'},
  {init:'ا‌و',name:'دکتر اِما والش',spec:'ضد پیری',rev:'۱۷۶ م ت',appt:'۴۷',conv:79,rating:'۴.۵',ticket:'۳.۷ م ت',score:'۷۲',scls:'sc-amber'},
];
const devices=[
  {name:'لیزر Nd:YAG پرو',roi:'بازگشت ۲۸۴٪',rev:'۴۲۸ م ت',usage:87,hours:'۶.۲ ساعت',shots:'۸٬۴۰۰',st:'active',stL:'فعال'},
  {name:'هایدرافیشیال الیت',roi:'بازگشت ۲۰۸٪',rev:'۳۱۲ م ت',usage:92,hours:'۷.۱ ساعت',st:'active',stL:'فعال'},
  {name:'کول‌اسکالپتینگ ۳۶۰',roi:'بازگشت ۱۸۱٪',rev:'۲۸۶ م ت',usage:74,hours:'۵.۴ ساعت',st:'due',stL:'موعد سرویس',due:true},
  {name:'اولترافی SMAS',roi:'بازگشت ۱۶۲٪',rev:'۲۴۴ م ت',usage:68,hours:'۴.۸ ساعت',st:'active',stL:'فعال'},
  {name:'IPL فوتوفیشیال',roi:'بازگشت ۱۳۲٪',rev:'۱۹۸ م ت',usage:71,hours:'۵.۲ ساعت',shots:'۱۲٬۲۰۰',st:'active',stL:'فعال'},
];
const campaigns=[
  {name:'هفته زیبایی بوتاکس',reach:'۲٬۸۴۰',book:'۱۴۲',rev:'۴۸۶ م ت',roi:'۳۱۲٪',conv:'۵٪',st:'active',stL:'فعال'},
  {name:'ویژه لیزر تابستان',reach:'۱٬۹۲۰',book:'۸۷',rev:'۳۱۳ م ت',roi:'۲۱۸٪',conv:'۴.۵٪',st:'active',stL:'فعال'},
  {name:'بازگشت مشتریان VIP',reach:'۴۸۰',book:'۶۴',rev:'۳۸۴ م ت',roi:'۴۲۸٪',conv:'۱۳.۳٪',st:'done',stL:'تکمیل‌شده'},
  {name:'پاداش معرفی',reach:'۱٬۲۴۰',book:'۳۸',rev:'۱۴۸ م ت',roi:'۱۶۴٪',conv:'۳.۱٪',st:'active',stL:'فعال'},
  {name:'خوش‌آمد بیمار جدید',reach:'۳٬۶۴۰',book:'۱۵۶',rev:'۴۱۶ م ت',roi:'۲۸۷٪',conv:'۴.۳٪',st:'active',stL:'فعال'},
];
const lowStock=[
  {name:'بوتاکس ۱۰۰ واحد',v:'۸ ویال',s:'حداقل ۱۰'},
  {name:'فیلر HA یک میلی‌لیتر',v:'۱۲ سرنگ',s:'حداقل ۱۵'},
  {name:'کرم بی‌حسی ۳۰ گرم',v:'۶ تیوب',s:'حداقل ۱۰'},
];
const expSoon=[
  {name:'رستیلن لیفت',v:'۲۳ مرداد ۱۴۰۴',s:'۸ واحد'},
  {name:'ژوویدرم اولترا پلاس',v:'۳۱ مرداد ۱۴۰۴',s:'۱۱ واحد'},
];
const aiCards=[
  {cls:'high',pcls:'p-high',prio:'اولویت بالا',gain:'۲۸۲ م ت+',title:'بازگرداندن ۴۷ بیمار آماده بوتاکس',desc:'۴۷ بیمار از بازه بهینه تمدید بوتاکس گذشته‌اند. یک کمپین پیامکی هدفمند با پیشنهاد محدود می‌تواند ظرف ۱۰ تا ۱۴ روز درآمد را بازیابی کند.',btn:'اجرای کمپین',bcls:'b-blue'},
  {cls:'crit',pcls:'p-crit',prio:'اولویت بحرانی',gain:'جلوگیری از ۴۲۸ م ت زیان',title:'سفارش فوری مواد مصرفی لیزر',desc:'با نرخ مصرف فعلی، مواد مصرفی لیزر Nd:YAG ظرف ۱۲ روز تمام می‌شود. کمبود موجودی ۴۲۸ میلیون تومان درآمد ماهانه لیزر را متوقف می‌کند.',btn:'ایجاد سفارش خرید',bcls:'b-red'},
  {cls:'med',pcls:'p-med',prio:'اولویت متوسط',gain:'۱۹۸ م ت+',title:'بازیابی ۱۲ بیمار VIP غیرفعال',desc:'۱۲ بیمار با میانگین ارزش عمر بیش از ۱۶ میلیون تومان بیش از ۹۰ روز مراجعه نکرده‌اند. پیشنهاد بازگشت VIP شخصی‌سازی‌شده به‌طور تاریخی ۶۸٪ نرخ پاسخ داشته است.',btn:'ارسال پیشنهاد VIP',bcls:'b-amber'},
  {cls:'medg',pcls:'p-medg',prio:'اولویت متوسط',gain:'۸۴ م ت+ در ماه',title:'بهینه‌سازی روند مشاوره دکتر لیو',desc:'دکتر لیو با نرخ ۸۲٪ تبدیل می‌کند در برابر میانگین ۹۱٪ تیم. یک برنامه آموزشی ساختاریافته مشاوره پیش‌بینی می‌شود ۸۴ میلیون تومان در ماه اضافه کند.',btn:'زمان‌بندی آموزش',bcls:'b-green'},
];
const feed=[
  {icon:'check',color:'green',t:'درمان بوتاکس تکمیل شد',d:'میا رودریگز — دکتر سارا چن',time:'۲ دقیقه پیش'},
  {icon:'appointments',color:'brand',t:'نوبت رزرو شد',d:'جیمز پارک — لیزر روسرفیسینگ، ۲۳ مرداد',time:'۸ دقیقه پیش'},
  {icon:'dollar',color:'green',t:'پرداخت دریافت شد',d:'۱۸ میلیون تومان از سوفی لورن',time:'۱۵ دقیقه پیش'},
  {icon:'megaphone',color:'purple',t:'کمپین اجرا شد',d:'ویژه لیزر تابستان — ۱٬۹۲۰ مخاطب',time:'۱ ساعت پیش'},
  {icon:'cart',color:'amber',t:'سفارش خرید تأیید شد',d:'PO-2847 — ۱۲۴ میلیون تومان ملزومات پزشکی',time:'۲ ساعت پیش'},
  {icon:'chip',color:'teal',t:'سرویس دستگاه تکمیل شد',d:'کول‌اسکالپتینگ ۳۶۰ — گزارش سرویس ML-4421',time:'دیروز'},
];
const alerts=[
  {cls:'ai-red',t:'هشدار موجودی بحرانی',time:'اکنون',d:'بوتاکس ۱۰۰ واحد — ۸ واحد باقی‌مانده (حداقل: ۱۰)'},
  {cls:'ai-amber',t:'سرویس عقب‌افتاده',time:'۳ روز پیش',d:'سرویس کول‌اسکالپتینگ ۳۶۰ سه روز عقب افتاده'},
  {cls:'ai-blue',t:'بیمار VIP در انتظار',time:'۱۸ دقیقه',d:'الکساندرا هرینگتون — ۱۸ دقیقه در لابی'},
  {cls:'ai-amber',t:'۴ لغو در همان روز',time:'امروز',d:'۳۲ میلیون تومان درآمد امروز در معرض خطر'},
  {cls:'ai-amber',t:'ریسک ریزش شناسایی شد',time:'امروز',d:'۱۲ بیمار در آستانه ۹۰ روز بدون مراجعه'},
];
const quickActions=[
  {icon:'reports',label:'مشاهده گزارش‌ها'},
  {icon:'megaphone',label:'اجرای کمپین',cls:'blue'},
  {icon:'cart',label:'تأیید خرید'},
  {icon:'dollar',label:'تأیید پرداخت‌ها'},
  {icon:'appointments',label:'رزرو نوبت',cls:'green'},
  {icon:'file',label:'تولید PDF'},
];
const clinicStatus=[
  {l:'اتاق‌های در حال استفاده',v:'۶ / ۸'},
  {l:'پرسنل حاضر',v:'۱۲ / ۱۴'},
  {l:'میانگین زمان انتظار',v:'۸ دقیقه'},
  {l:'پرداخت‌های معوق',v:'۴۶ م ت',cls:'amber'},
  {l:'وظایف باز',v:'۳ فوری',cls:'red'},
];

document.getElementById('statGrid').innerHTML=stats.map(s=>`
  <div class="stat-card">
    <div class="stat-top"><span class="stat-title">${s.t}</span><span class="stat-ic" style="background:var(--${s.color}-soft);color:var(--${s.color})">${svg(s.icon,17)}</span></div>
    <div class="stat-val">${s.v}</div>
    <div class="stat-foot">${s.d?`<span class="stat-delta">↗ ${s.d}</span>`:''}${s.note?`<span class="stat-note">${s.note}</span>`:''}</div>
  </div>`).join('');

document.getElementById('bhMetrics').innerHTML=bhMetrics.map(m=>`
  <div class="bh-m">
    <div class="bh-m-top"><span class="bh-m-l">${m.l}</span><span class="bh-m-v">${toFa(m.v)}</span></div>
    <div class="bh-m-bar"><div class="bh-m-fill" style="width:0;background:${m.color}" data-w="${m.v}"></div></div>
  </div>`).join('');

document.getElementById('opps').innerHTML=opps.map(o=>`
  <div class="opp">
    <span class="opp-ic" style="background:var(--${o.color}-soft);color:var(--${o.color})">${svg(o.icon,18)}</span>
    <div class="opp-body">
      <div class="opp-top"><span class="opp-name">${o.name}</span><span class="opp-chip" style="background:var(--${o.ccls}-soft);color:var(--${o.ccls})">${o.chip}</span></div>
      <div class="opp-desc">${o.desc}</div>
    </div>
    <div class="opp-val"><div class="opp-amt">${o.amt}</div><div class="opp-lbl">درآمد بالقوه</div></div>
    <span class="opp-arrow">${svg('arrowl',17)}</span>
  </div>`).join('');

document.getElementById('docBody').innerHTML=doctors.map(d=>`
  <tr>
    <td><div class="doc-cell"><span class="doc-av">${d.init}</span><div><div class="doc-nm">${d.name}</div><div class="doc-sp">${d.spec}</div></div></div></td>
    <td class="mono">${d.rev}</td>
    <td class="mono">${d.appt}</td>
    <td><div class="conv-cell"><div class="conv-bar"><div class="conv-fill" style="width:${d.conv}%"></div></div><span class="mono">${toFa(d.conv)}٪</span></div></td>
    <td class="rating">★ ${d.rating}</td>
    <td class="mono">${d.ticket}</td>
    <td><span class="score-badge ${d.scls}">${d.score}</span></td>
  </tr>`).join('');

document.getElementById('devGrid').innerHTML=devices.map(d=>`
  <div class="dev-card ${d.due?'due':''}">
    <div class="dev-top"><span class="dev-ic">${svg('chip',17)}</span><span class="dev-badge ${d.due?'db-due':'db-active'}">${d.stL}</span></div>
    <div class="dev-name">${d.name}</div>
    <div class="dev-roi">${d.roi}</div>
    <div class="dev-row"><span class="l">درآمد ماهانه</span><span class="v">${d.rev}</span></div>
    <div class="dev-row"><span class="l">بهره‌وری</span><span class="v">${toFa(d.usage)}٪</span></div>
    <div class="dev-bar"><div class="dev-fill" style="width:${d.usage}%;background:${d.usage>=85?'var(--green)':'var(--brand)'}"></div></div>
    <div class="dev-row"><span class="l">ساعت روزانه</span><span class="v">${d.hours}</span></div>
    ${d.shots?`<div class="dev-row"><span class="l">شات باقی‌مانده</span><span class="v">${d.shots}</span></div>`:''}
  </div>`).join('');

document.getElementById('campBody').innerHTML=campaigns.map(c=>`
  <tr>
    <td><div class="doc-cell"><span class="doc-av">${svg('megaphone',15)}</span><span class="doc-nm">${c.name}</span></div></td>
    <td class="mono">${c.reach}</td>
    <td class="mono">${c.book}</td>
    <td class="mono">${c.rev}</td>
    <td><span class="score-badge sc-green">${c.roi}</span></td>
    <td class="mono">${c.conv}</td>
    <td><span class="score-badge ${c.st==='active'?'sc-green':'sc-blue'}" style="min-width:auto">${c.stL}</span></td>
  </tr>`).join('');

document.getElementById('lowStock').innerHTML=lowStock.map(i=>`
  <div class="inv-row low"><span class="inv-nm">${i.name}</span><div class="inv-right"><div class="inv-v red">${i.v}</div><div class="inv-s">${i.s}</div></div></div>`).join('');
document.getElementById('expSoon').innerHTML=expSoon.map(i=>`
  <div class="inv-row exp"><span class="inv-nm">${i.name}</span><div class="inv-right"><div class="inv-v amber">${i.v}</div><div class="inv-s">${i.s}</div></div></div>`).join('')
  +`<div class="inv-row plain"><span class="inv-nm">ارزش کل انبار</span><div class="inv-right"><div class="inv-v">۱٬۴۲۸ م ت</div></div></div>`;

document.getElementById('aiGrid').innerHTML=aiCards.map(a=>`
  <div class="ai-card ${a.cls}">
    <div class="ai-c-top"><span class="ai-prio ${a.pcls}">${a.prio}</span><span class="ai-gain">${a.gain}</span></div>
    <div class="ai-c-title">${a.title}</div>
    <div class="ai-c-desc">${a.desc}</div>
    <button class="ai-btn ${a.bcls}">${a.btn}</button>
  </div>`).join('');

document.getElementById('feed').innerHTML=feed.map(f=>`
  <div class="af">
    <span class="af-ic" style="background:var(--${f.color}-soft);color:var(--${f.color})">${svg(f.icon,17)}</span>
    <div class="af-body"><div class="af-t">${f.t}</div><div class="af-d">${f.d}</div></div>
    <span class="af-time">${f.time}</span>
  </div>`).join('');

document.getElementById('alerts').innerHTML=alerts.map(a=>`
  <div class="alert-item ${a.cls}">
    <span class="al-dot"></span>
    <div class="al-body"><div class="al-top"><span class="al-t">${a.t}</span><span class="al-time">${a.time}</span></div><div class="al-d">${a.d}</div></div>
  </div>`).join('');

document.getElementById('quickActions').innerHTML=quickActions.map(q=>`
  <button class="qa-btn ${q.cls||''}">${svg(q.icon,18)}${q.label}</button>`).join('');

document.getElementById('clinicStatus').innerHTML=clinicStatus.map(c=>`
  <div class="cs-row"><span class="cs-l">${c.l}</span><span class="cs-v ${c.cls||''}">${c.v}</span></div>`).join('');

/* نمودارها */
function lineChart(el,xEl,data,labels,color,min,max,dashed){
  const w=560,h=180,pad=5;
  const pts=data.map((v,i)=>{
    const x=pad+(i/(data.length-1))*(w-pad*2);
    const y=h-pad-((v-min)/(max-min))*(h-pad*2);
    return [x,y];
  });
  let d='M'+pts[0][0].toFixed(1)+' '+pts[0][1].toFixed(1);
  for(let i=1;i<pts.length;i++){
    const p0=pts[i-1],p1=pts[i],cx=(p0[0]+p1[0])/2;
    d+=` C${cx.toFixed(1)} ${p0[1].toFixed(1)}, ${cx.toFixed(1)} ${p1[1].toFixed(1)}, ${p1[0].toFixed(1)} ${p1[1].toFixed(1)}`;
  }
  const area=d+` L${pts[pts.length-1][0].toFixed(1)} ${h} L${pts[0][0].toFixed(1)} ${h} Z`;
  const gid='g'+Math.random().toString(36).slice(2,7);
  document.getElementById(el).innerHTML=`
    <svg viewBox="0 0 ${w} ${h}" preserveAspectRatio="none">
      <defs><linearGradient id="${gid}" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="${color}" stop-opacity="0.18"/><stop offset="100%" stop-color="${color}" stop-opacity="0"/></linearGradient></defs>
      ${[0,1,2,3,4].map(i=>`<line x1="0" y1="${(h/4)*i}" x2="${w}" y2="${(h/4)*i}" stroke="var(--border)" stroke-dasharray="4 5" stroke-width="1"/>`).join('')}
      <path d="${area}" fill="url(#${gid})"/>
      <path d="${d}" fill="none" stroke="${color}" stroke-width="2.4" stroke-linecap="round" ${dashed?'stroke-dasharray="6 4"':'stroke-dasharray="1600" stroke-dashoffset="1600"'}>
        ${dashed?'':'<animate attributeName="stroke-dashoffset" from="1600" to="0" dur="1.4s" fill="freeze" calcMode="spline" keySplines="0.16 1 0.3 1" keyTimes="0;1"/>'}
      </path>
    </svg>`;
  document.getElementById(xEl).innerHTML=labels.map(l=>`<span>${l}</span>`).join('');
}
lineChart('revChart','revX',revData,revDays,'var(--brand)',0,200);
lineChart('patChart','patX',patData,patMonths,'var(--green)',0,200);

/* انیمیشن‌ها */
requestAnimationFrame(()=>{
  document.querySelectorAll('.bh-m-fill').forEach(f=>f.style.width=f.dataset.w+'%');
  const arc=document.getElementById('bhArc');
  const C=2*Math.PI*52;
  arc.style.transition='stroke-dashoffset 1.2s cubic-bezier(.16,1,.3,1)';
  arc.setAttribute('stroke-dasharray',C);
  setTimeout(()=>{ arc.style.strokeDashoffset=C*(1-0.78); },60);
});

/* تعامل‌ها */
['revTabs','patTabs'].forEach(id=>{
  document.getElementById(id).addEventListener('click',e=>{
    const t=e.target.closest('.seg-tab'); if(!t)return;
    document.querySelectorAll('#'+id+' .seg-tab').forEach(x=>x.classList.remove('active'));
    t.classList.add('active');
  });
});
</script>

@endsection