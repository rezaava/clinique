<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap  rel="
        stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* ===================== فونت وزیرمتن ===================== */
        @font-face {
            font-family: "Vazirmatn";
            src: url("https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-Regular.woff2") format("woff2");
            font-weight: 400;
            font-display: swap;
        }

        @font-face {
            font-family: "Vazirmatn";
            src: url("https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-Medium.woff2") format("woff2");
            font-weight: 500;
            font-display: swap;
        }

        @font-face {
            font-family: "Vazirmatn";
            src: url("https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-SemiBold.woff2") format("woff2");
            font-weight: 600;
            font-display: swap;
        }

        @font-face {
            font-family: "Vazirmatn";
            src: url("https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/fonts/webfonts/Vazirmatn-Bold.woff2") format("woff2");
            font-weight: 700;
            font-display: swap;
        }

        /* ===================== توکن‌های طراحی (سیستم مشترک) ===================== */
        :root {
            /* رنگ‌های برند */
            --brand: #2563eb;
            --brand-hover: #1d4ed8;
            --brand-soft: #eff4ff;
            --purple: #7c3aed;
            --purple-soft: #f3efff;
            --orange: #ea580c;
            --orange-soft: #fff3ec;
            --green: #059669;
            --green-soft: #ecfdf5;
            --amber: #d97706;
            --amber-soft: #fffbeb;
            --red: #dc2626;
            --red-soft: #fef2f2;

            /* سطوح روشن */
            --bg: #f6f7f9;
            --surface: #ffffff;
            --surface-2: #fbfbfc;
            --sidebar: #ffffff;
            --border: #eaecef;
            --border-strong: #dfe2e7;

            /* متن */
            --text: #0f172a;
            --text-2: #475569;
            --text-3: #94a3b8;

            /* رادیوس و سایه */
            --r-sm: 8px;
            --r-md: 12px;
            --r-lg: 16px;
            --r-xl: 20px;
            --shadow-sm:
                0 1px 2px rgba(16, 24, 40, 0.04), 0 1px 3px rgba(16, 24, 40, 0.06);
            --shadow-md:
                0 4px 12px rgba(16, 24, 40, 0.06), 0 2px 6px rgba(16, 24, 40, 0.04);
            --shadow-lg: 0 12px 32px rgba(16, 24, 40, 0.1);

            /* چیدمان */
            --sidebar-w: 248px;
            --header-h: 72px;
            --gap: 20px;
            --rail-w:300px;

            --font: "Vazirmatn", system-ui, -apple-system, sans-serif;
        }

        /* ===================== دارک‌مود ===================== */
        html[data-theme="dark"] {
            --brand: #3b82f6;
            --brand-hover: #60a5fa;
            --brand-soft: #1a2740;
            --purple: #a78bfa;
            --purple-soft: #241f3d;
            --orange: #fb923c;
            --orange-soft: #35271c;
            --green: #34d399;
            --green-soft: #16281f;
            --amber: #fbbf24;
            --amber-soft: #2c2410;
            --red: #f87171;
            --red-soft: #2e1a1a;

            --bg: #0b0f17;
            --surface: #131824;
            --surface-2: #171d2b;
            --sidebar: #0f141e;
            --border: #232a38;
            --border-strong: #2c3444;

            --text: #f1f5f9;
            --text-2: #a4b0c2;
            --text-3: #6b7688;

            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.35);
            --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 15px;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            transition:
                background 0.3s ease,
                color 0.3s ease;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            background: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        :focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* اسکرول‌بار */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-strong);
            border-radius: 20px;
            border: 2px solid var(--bg);
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        /* ===================== چیدمان اصلی ===================== */
        .app {
            display: flex;
            min-height: 100vh;
        }

        /* ===================== سایدبار ===================== */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            inset-block: 0;
            inset-inline-start: 0;
            z-index: 50;
            transition:
                transform 0.3s ease,
                background 0.3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 22px 20px;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--brand), var(--purple));
            display: grid;
            place-items: center;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .brand-name {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .nav {
            flex: 1;
            padding: 8px 12px;
            overflow-y: auto;
        }

        .nav-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-3);
            padding: 14px 12px 6px;
            letter-spacing: 0.04em;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--r-md);
            color: var(--text-2);
            font-weight: 500;
            font-size: 0.94rem;
            margin-bottom: 2px;
            transition: all 0.18s ease;
            position: relative;
        }

        .nav-item:hover {
            background: var(--surface-2);
            color: var(--text);
        }

        .nav-item.active {
            background: var(--brand-soft);
            color: var(--brand);
            font-weight: 600;
        }

        .nav-item .ic {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-inline-start: auto;
            background: var(--surface-2);
            color: var(--text-2);
            font-size: 0.75rem;
            font-weight: 600;
            min-width: 22px;
            height: 22px;
            border-radius: 20px;
            display: grid;
            place-items: center;
            padding: 0 6px;
        }

        .nav-item.active .nav-badge {
            background: var(--brand);
            color: #fff;
        }

        .sidebar-foot {
            padding: 14px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), var(--brand));
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .sidebar-foot .info {
            min-width: 0;
        }

        .sidebar-foot .nm {
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-foot .rl {
            font-size: 0.78rem;
            color: var(--text-3);
        }

        /* ===================== محتوای اصلی ===================== */
        .main {
            flex: 1;
            margin-inline-start: var(--sidebar-w);
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* هدر */
        .header {
            height: var(--header-h);
            background: color-mix(in srgb, var(--surface) 80%, transparent);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 40;
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 0 28px;
        }

        .header .date {
            font-weight: 700;
            font-size: 1rem;
            white-space: nowrap;
        }

        .header .date span {
            color: var(--text-3);
            font-weight: 500;
        }

        .search {
            flex: 1;
            max-width: 520px;
            position: relative;
        }

        .search input {
            width: 100%;
            height: 44px;
            border-radius: var(--r-md);
            background: var(--surface-2);
            border: 1px solid var(--border);
            padding: 0 44px 0 60px;
            font-family: inherit;
            font-size: 0.92rem;
            color: var(--text);
            transition: all 0.18s ease;
        }

        .search input::placeholder {
            color: var(--text-3);
        }

        .search input:focus {
            border-color: var(--brand);
            background: var(--surface);
        }

        .search .s-ic {
            position: absolute;
            inset-inline-start: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-3);
            pointer-events: none;
        }

        .search .kbd {
            position: absolute;
            inset-inline-end: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.72rem;
            color: var(--text-3);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 2px 7px;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-inline-start: auto;
        }

        .icon-btn {
            width: 42px;
            height: 42px;
            border-radius: var(--r-md);
            background: var(--surface-2);
            border: 1px solid var(--border);
            display: grid;
            place-items: center;
            color: var(--text-2);
            transition: all 0.18s ease;
            position: relative;
        }

        .icon-btn:hover {
            background: var(--surface);
            color: var(--text);
            border-color: var(--border-strong);
        }

        .icon-btn .dot {
            position: absolute;
            top: 9px;
            inset-inline-end: 10px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--red);
            border: 2px solid var(--surface);
        }

        .header .avatar {
            width: 42px;
            height: 42px;
            cursor: pointer;
        }

        .menu-toggle {
            display: none;
        }

        .overlay {
            display: none;
        }

        @media (max-width: 860px) {
            :root {
                --sidebar-w: 240px;
            }

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



            html.nav-open .overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 45;
            }

            .header {
                padding: 0 16px;
                gap: 12px;
            }

            .header .date {
                display: none;
            }

            .page {
                padding: 18px;
            }

            .menu-toggle {
                display: grid;
            }
        }

        .page-head {
            margin-bottom: 24px;
            margin-top: 24px;
            padding: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }

        .greeting {
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .greeting .wave {
            display: inline-block;
        }

        .subtitle {
            color: var(--text-2);
            margin-top: 4px;
            font-size: 0.96rem;
        }

        .clinic-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 40px;
            padding: 9px 16px;
            font-size: 0.88rem;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green);
            position: relative;
        }

        .live-dot::after {
            content: "";
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: var(--green);
            opacity: 0.35;
            animation: pulse 2s ease-out infinite;
        }
    </style>

    <script src="{{ asset('alert/alert.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    @yield('head')
</head>