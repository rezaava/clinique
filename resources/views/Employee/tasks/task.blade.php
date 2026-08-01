@extends('layout.master')

@section('title')
اوراکلینیک — مرکز وظایف منشی
@endsection

@section('name-page')
مرکز وظایف
@endsection

@section('head')

<style>
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