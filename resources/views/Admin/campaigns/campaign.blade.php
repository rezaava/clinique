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