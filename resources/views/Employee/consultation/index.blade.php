@extends('layout.master')

@section('title', 'درخواست‌های مشاوره')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/employee/calendar.css') }}">
    <style>
        .consultation-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .consultation-search {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .consultation-search input {
            width: 100%;
            height: 40px;
            border-radius: var(--r-md);
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 0 40px 0 12px;
            font-family: inherit;
            font-size: .88rem;
            color: var(--text);
        }

        .consultation-search input:focus {
            border-color: var(--brand);
            outline: none;
        }

        .consultation-search i {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-3);
        }

        .consultation-select {
            height: 40px;
            min-width: 160px;
            padding: 0 12px;
            border-radius: var(--r-md);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
            font-family: inherit;
            font-size: .86rem;
        }

        .consultation-list {
            display: flex;
            flex-direction: column;
        }

        .consultation-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: background .18s ease;
        }

        .consultation-item:last-child {
            border-bottom: none;
        }

        .consultation-item:hover {
            background: var(--surface-2);
        }

        .consultation-item.active {
            background: var(--brand-soft);
            border-inline-start: 3px solid var(--brand);
        }

        .consultation-person {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 170px;
        }

        .consultation-avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 50%;
            background: var(--brand-soft);
            color: var(--brand);
            display: grid;
            place-items: center;
            font-size: 1rem;
        }

        .consultation-person-name {
            font-size: .88rem;
            font-weight: 700;
            color: var(--text);
        }

        .consultation-person-phone {
            font-size: .76rem;
            color: var(--text-3);
            margin-top: 3px;
        }

        .consultation-meta {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            flex: 1;
        }

        .consultation-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-2);
            font-size: .78rem;
        }

        .consultation-meta-item i {
            color: var(--text-3);
        }

        .consultation-status {
            padding: 5px 11px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-pending {
            background: var(--amber-soft);
            color: var(--amber);
        }

        .status-assigned {
            background: var(--brand-soft);
            color: var(--brand);
        }

        .status-in_progress {
            background: var(--purple-soft);
            color: var(--purple);
        }

        .status-completed {
            background: var(--green-soft);
            color: var(--green);
        }

        .consultation-empty {
            padding: 45px 15px;
            text-align: center;
            color: var(--text-3);
        }

        .consultation-empty i {
            display: block;
            font-size: 2rem;
            margin-bottom: 12px;
        }

        .consultation-detail-person {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .consultation-detail-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(135deg, var(--brand), var(--purple));
            font-size: 1.1rem;
        }

        .consultation-detail-name {
            font-size: 1rem;
            font-weight: 700;
        }

        .consultation-detail-phone {
            font-size: .78rem;
            color: var(--text-3);
        }

        .consultation-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: .83rem;
        }

        .consultation-detail-row:last-child {
            border-bottom: none;
        }

        .consultation-detail-label {
            color: var(--text-2);
            flex-shrink: 0;
        }

        .consultation-detail-value {
            font-weight: 600;
            text-align: left;
            overflow-wrap: anywhere;
        }

        .consultation-description {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            padding: 12px;
            margin-top: 12px;
        }

        .consultation-description-title {
            color: var(--text-3);
            font-size: .72rem;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .consultation-description-text {
            color: var(--text-2);
            font-size: .82rem;
            line-height: 1.9;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .consultation-photo {
            margin-top: 14px;
        }

        .consultation-photo img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
            border-radius: var(--r-md);
            border: 1px solid var(--border);
            background: var(--surface-2);
        }

        .consultation-pagination {
            padding: 15px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
        }

        .consultation-pagination nav {
            display: flex;
            justify-content: center;
        }

        .consultation-pagination .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .consultation-pagination .page-link {
            display: block;
            padding: 7px 12px;
            border: 1px solid var(--border);
            border-radius: var(--r-sm);
            color: var(--text-2);
            background: var(--surface);
            font-size: .8rem;
        }

        .consultation-pagination .active .page-link {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
        }

        .consultation-pagination .disabled .page-link {
            opacity: .4;
        }

        .consultation-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            padding: 18px 20px;
            padding-bottom: 0;
        }

        .consultation-stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            padding: 14px;
            box-shadow: var(--shadow-sm);
        }

        .consultation-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 9px;
        }

        .consultation-stat-title {
            font-size: .78rem;
            color: var(--text-2);
        }

        .consultation-stat-icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            display: grid;
            place-items: center;
            background: var(--brand-soft);
            color: var(--brand);
        }

        .consultation-stat-value {
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--text);
        }

        .consultation-stat.pending .consultation-stat-icon {
            background: var(--amber-soft);
            color: var(--amber);
        }

        .consultation-stat.assigned .consultation-stat-icon {
            background: var(--brand-soft);
            color: var(--brand);
        }

        .consultation-stat.completed .consultation-stat-icon {
            background: var(--green-soft);
            color: var(--green);
        }

        @media(max-width: 1200px) {
            .consultation-item {
                flex-wrap: wrap;
            }

            .consultation-meta {
                min-width: 100%;
                padding-inline-start: 51px;
            }
        }

        @media(max-width: 860px) {
            .consultation-stats {
                padding: 14px 14px 0;
            }

            .consultation-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .consultation-search,
            .consultation-select {
                width: 100%;
            }
        }

        @media(max-width: 560px) {
            .consultation-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .consultation-stat {
                padding: 11px;
            }

            .consultation-stat-value {
                font-size: 1.2rem;
            }

            .consultation-item {
                padding: 12px;
            }

            .consultation-person {
                min-width: 0;
                flex: 1;
            }

            .consultation-meta {
                padding-inline-start: 0;
                gap: 9px;
            }

            .consultation-status {
                font-size: .68rem;
            }
        }
    </style>
@endsection

@section('content')

    {{-- آمار --}}
    <div class="consultation-stats">

        <div class="consultation-stat">
            <div class="consultation-stat-top">
                <span class="consultation-stat-title">کل درخواست‌ها</span>
                <span class="consultation-stat-icon">
                    <i class="fa fa-comments"></i>
                </span>
            </div>
            <div class="consultation-stat-value">
                {{ \App\Models\Consultation::count() }}
            </div>
        </div>

        <div class="consultation-stat pending">
            <div class="consultation-stat-top">
                <span class="consultation-stat-title">در انتظار بررسی</span>
                <span class="consultation-stat-icon">
                    <i class="fa fa-clock"></i>
                </span>
            </div>
            <div class="consultation-stat-value">
                {{ \App\Models\Consultation::where('status', 'pending')->count() }}
            </div>
        </div>

        <div class="consultation-stat assigned">
            <div class="consultation-stat-top">
                <span class="consultation-stat-title">ارجاع شده</span>
                <span class="consultation-stat-icon">
                    <i class="fa fa-user-check"></i>
                </span>
            </div>
            <div class="consultation-stat-value">
                {{ \App\Models\Consultation::where('status', 'assigned')->count() }}
            </div>
        </div>

        <div class="consultation-stat completed">
            <div class="consultation-stat-top">
                <span class="consultation-stat-title">تکمیل شده</span>
                <span class="consultation-stat-icon">
                    <i class="fa fa-check-circle"></i>
                </span>
            </div>
            <div class="consultation-stat-value">
                {{ \App\Models\Consultation::where('status', 'completed')->count() }}
            </div>
        </div>

    </div>

    {{-- بدنه اصلی --}}
    <div class="cal-body" style="  margin-top: 10px;">

        <div class="cal-left">

            <div class="cal-card">

                {{-- هدر --}}
                <div class="rail-head" style="padding: 16px; margin: 0; border-bottom: 1px solid var(--border);">
                    <div>
                        <div class="rail-eyebrow">MANAGEMENT</div>
                        <div class="rail-title">درخواست‌های مشاوره</div>
                    </div>

                    <span class="rail-tag">
                        {{ $consultations->total() }} درخواست
                    </span>
                </div>

                <div style="padding: 15px;">

                    {{-- فیلترها --}}
                    <form method="GET" action="{{ route('employee.consultation.index') }}"
                        class="consultation-toolbar">

                        <div class="consultation-search">
                            <i class="fa fa-search"></i>
                            <input type="text" name="search"
                                placeholder="نام، شماره تماس یا توضیحات..."
                                value="{{ request('search') }}">
                        </div>

                        <select name="status" class="consultation-select">
                            <option value="">تمام وضعیت‌ها</option>
                            <option value="pending" @selected(request('status') == 'pending')>در انتظار بررسی</option>
                            <option value="assigned" @selected(request('status') == 'assigned')>ارجاع شده</option>
                            <option value="in_progress" @selected(request('status') == 'in_progress')>در حال انجام</option>
                            <option value="completed" @selected(request('status') == 'completed')>تکمیل شده</option>
                        </select>

                        <button type="submit" class="filter-btn">
                            <i class="fa fa-search"></i>
                            جستجو
                        </button>

                        <a href="{{ route('employee.consultation.index') }}" class="filter-btn">
                            <i class="fa fa-times"></i>
                            پاک کردن
                        </a>

                    </form>

                    {{-- لیست --}}
                    <div class="consultation-list">

                        @forelse($consultations as $consultation)

                            @php
                                $statuses = [
                                    'pending' => ['در انتظار بررسی', 'pending'],
                                    'assigned' => ['ارجاع شده', 'assigned'],
                                    'in_progress' => ['در حال انجام', 'in_progress'],
                                    'completed' => ['تکمیل شده', 'completed'],
                                ];

                                $status = $statuses[$consultation->status] ?? ['نامشخص', 'pending'];
                            @endphp

                            <div class="consultation-item"
                                id="consultation-{{ $consultation->id }}"
                                onclick="showConsultation({{ $consultation->id }})">

                                <div class="consultation-person">
                                    <div class="consultation-avatar">
                                        <i class="fa fa-user"></i>
                                    </div>

                                    <div>
                                        <div class="consultation-person-name">
                                            {{ $consultation->name ?? ($consultation->user?->name ?? '---') }}
                                        </div>

                                        <div class="consultation-person-phone">
                                            {{ $consultation->phone ?? ($consultation->user?->phone ?? '---') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="consultation-meta">

                                    <div class="consultation-meta-item">
                                        <i class="fa fa-stethoscope"></i>
                                        {{ $consultation->service?->name ?? '---' }}
                                    </div>

                                    <div class="consultation-meta-item">
                                        <i class="fa fa-calendar"></i>
                                        {{ $consultation->consultation_date
                                            ? Verta::instance($consultation->consultation_date)->format('Y/m/d')
                                            : 'بدون تاریخ' }}
                                    </div>

                                    <div class="consultation-meta-item">
                                        <i class="fa fa-comment"></i>
                                        {{ $consultation->type ?? '---' }}
                                    </div>

                                </div>

                                <span class="consultation-status status-{{ $status[1] }}">
                                    {{ $status[0] }}
                                </span>

                            </div>

                        @empty

                            <div class="consultation-empty">
                                <i class="fa fa-inbox"></i>
                                درخواستی برای مشاوره ثبت نشده است.
                            </div>

                        @endforelse

                    </div>

                </div>

                @if($consultations->hasPages())
                    <div class="consultation-pagination">
                        {{ $consultations->links() }}
                    </div>
                @endif

            </div>

        </div>

        {{-- پنل جزئیات --}}
        <div class="rail">

            <div class="rail-card">

                <div class="rail-head">
                    <div>
                        <div class="rail-eyebrow">CONSULTATION DETAILS</div>
                        <div class="rail-title">جزئیات درخواست</div>
                    </div>

                    <span class="rail-tag">مشاوره</span>
                </div>

                <div id="consultationDetails">

                    <div class="consultation-empty">
                        <i class="fa fa-hand-pointer"></i>
                        <div>برای مشاهده جزئیات، یک درخواست را انتخاب کنید.</div>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')
    <script>
        function showConsultation(id) {

            document.querySelectorAll('.consultation-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(`consultation-${id}`)?.classList.add('active');

            const details = document.getElementById('consultationDetails');

            details.innerHTML = `
                <div class="consultation-empty">
                    <i class="fa fa-spinner fa-spin"></i>
                    در حال دریافت اطلاعات...
                </div>
            `;

            fetch(`{{ url('employee/consultation') }}/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('خطا در دریافت اطلاعات');
                    }

                    return response.json();
                })
                .then(result => {

                    if (!result.success) {
                        throw new Error('اطلاعات درخواست دریافت نشد');
                    }

                    const c = result.consultation;

                    const statuses = {
                        pending: ['در انتظار بررسی', 'pending'],
                        assigned: ['ارجاع شده', 'assigned'],
                        in_progress: ['در حال انجام', 'in_progress'],
                        completed: ['تکمیل شده', 'completed']
                    };

                    const status = statuses[c.status] || ['نامشخص', 'pending'];

                    details.innerHTML = `

                        <div class="consultation-detail-person">
                            <div class="consultation-detail-avatar">
                                <i class="fa fa-user"></i>
                            </div>

                            <div>
                                <div class="consultation-detail-name">
                                    ${escapeHtml(c.name || c.user?.name || '---')}
                                </div>

                                <div class="consultation-detail-phone">
                                    ${escapeHtml(c.phone || c.user?.phone || '---')}
                                </div>
                            </div>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">وضعیت</span>
                            <span class="consultation-status status-${status[1]}">
                                ${status[0]}
                            </span>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">خدمت</span>
                            <span class="consultation-detail-value">
                                ${escapeHtml(c.service?.name || '---')}
                            </span>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">نوع مشاوره</span>
                            <span class="consultation-detail-value">
                                حضوری
                            </span>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">تاریخ مشاوره</span>
                            <span class="consultation-detail-value">
                                ${escapeHtml(c.consultation_date || '---')}
                            </span>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">زمان دلخواه</span>
                            <span class="consultation-detail-value">
                                ${c.any_time ? 'هر زمانی' : 'زمان مشخص'}
                            </span>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">مسئول ارجاع</span>
                            <span class="consultation-detail-value">
                                ${escapeHtml(c.assigned_to?.first_name || '---')}
                                ${escapeHtml(c.assigned_to?.last_name || '---')}
                            </span>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">هزینه</span>
                            <span class="consultation-detail-value">
                                ${Number(c.price || 0).toLocaleString('fa-IR')} تومان
                            </span>
                        </div>

                        <div class="consultation-detail-row">
                            <span class="consultation-detail-label">تاریخ ارجاع</span>
                            <span class="consultation-detail-value">
                                ${escapeHtml(c.assigned_at || '---')}
                            </span>
                        </div>

                        ${renderDescription('توضیحات', c.description)}
                        ${renderDescription('یادداشت‌ها', c.notes)}
                        ${c.photo_path ? `
                            <div class="consultation-photo">
                                <div class="consultation-description-title">تصویر پیوست</div>
                                <a href="/${encodeURI(c.photo_path)}" target="_blank">
                                    <img src="/${encodeURI(c.photo_path)}" alt="تصویر پیوست">
                                </a>
                            </div>
                        ` : ''}

                    `;
                })
                .catch(error => {
                    details.innerHTML = `
                        <div class="consultation-empty" style="color:var(--red)">
                            <i class="fa fa-exclamation-circle"></i>
                            ${escapeHtml(error.message)}
                        </div>
                    `;
                });
        }

        function renderDescription(title, value) {
            return `
                <div class="consultation-description">
                    <div class="consultation-description-title">
                        ${title}
                    </div>
                    <div class="consultation-description-text">
                        ${escapeHtml(value || '---')}
                    </div>
                </div>
            `;
        }

        function escapeHtml(value) {
            return String(value).replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]);
        }
    </script>
@endsection