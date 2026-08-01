@extends('layout.master')

@section('title')
اوراکلینیک — تقویم منشی
@endsection

@section('name-page')
تقویم
@endsection
@section('head')

<style>
    .date-nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav-arrow {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        color: var(--text-2);
        transition: all .18s ease;
    }

    .nav-arrow:hover {
        background: var(--surface-2);
        color: var(--text);
    }

    .cur-date {
        font-weight: 700;
        font-size: 1rem;
        white-space: nowrap;
    }

    .btn-today {
        padding: 8px 18px;
        border-radius: 30px;
        background: var(--brand-soft);
        color: var(--brand);
        font-weight: 600;
        font-size: .88rem;
    }

    .view-switch {
        display: flex;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: 30px;
        padding: 3px;
    }

    .vs-btn {
        padding: 6px 18px;
        border-radius: 30px;
        font-weight: 600;
        font-size: .86rem;
        color: var(--text-2);
        transition: all .18s ease;
    }

    .vs-btn.active {
        background: var(--surface);
        color: var(--text);
        box-shadow: var(--shadow-sm);
    }

    .filters {
        display: flex;
        gap: 8px;
        margin-inline-start: auto;
        flex-wrap: wrap;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 14px;
        border-radius: 30px;
        border: 1px solid var(--border);
        background: var(--surface);
        font-size: .86rem;
        font-weight: 500;
        color: var(--text-2);
        transition: all .18s ease;
        white-space: nowrap;
    }

    .filter-btn:hover {
        border-color: var(--border-strong);
        color: var(--text);
    }

    .icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
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

    /* Responsive Calendar Header */

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap
    }

    @media(max-width:992px) {
        .date-nav {
            width: 100%;
            justify-content: center;
            order: 1
        }

        .btn-today {
            order: 2
        }

        .view-switch {
            order: 3
        }

        .filters {
            order: 4;
            width: 100%;
            justify-content: center
        }

        .filter-btn {
            flex: 1;
            justify-content: center
        }
    }

    @media(max-width:576px) {
        .date-nav {
            gap: 5px
        }

        .cur-date {
            font-size: .85rem;
            text-align: center
        }

        .nav-arrow {
            width: 32px;
            height: 32px
        }

        .btn-today {
            width: 100%;
            padding: 9px
        }

        .view-switch {
            width: 100%;
            justify-content: space-between
        }

        .vs-btn {
            flex: 1;
            padding: 8px 10px;
            font-size: .8rem
        }

        .filters {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            width: 100%
        }

        .filter-btn {
            width: 100%;
            padding: 9px 10px;
            justify-content: center;
            font-size: .8rem
        }

        .filter-btn svg {
            width: 12px;
            height: 12px
        }
    }

    @media(max-width:360px) {
        .filters {
            grid-template-columns: 1fr
        }

        .cur-date {
            font-size: .78rem
        }
    }
</style>

@endsection

@section('text-search')
جستجو بیمار
@endsection

@section('btn')
<div class="calendar-header">
    <div class="date-nav">
        <button class="nav-arrow" aria-label="روز قبل"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
            </svg></button>
        <span class="cur-date">سه‌شنبه، ۲۵ دی ۱۴۰۳</span>
        <button class="nav-arrow" aria-label="روز بعد"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg></button>
    </div>
    <button class="btn-today">امروز</button>
    <div class="view-switch" id="viewSwitch">
        <button class="vs-btn">روز</button>
        <button class="vs-btn active">هفته</button>
        <button class="vs-btn">ماه</button>
    </div>
    <div class="filters">
        <button class="filter-btn">پزشک<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round">
                <path d="m6 9 6 6 6-6" />
            </svg></button>
        <button class="filter-btn">درمان<svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="m6 9 6 6 6-6" />
            </svg></button>
        <button class="filter-btn">اتاق<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round">
                <path d="m6 9 6 6 6-6" />
            </svg></button>
        <button class="filter-btn">دستگاه<svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="m6 9 6 6 6-6" />
            </svg></button>
    </div>
</div>
@endsection

@section('subtitle')

@endsection