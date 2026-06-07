<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli</title>
    <style>
        :root {
            --sea-50: #f6fbff;
            --sea-100: #eef7ff;
            --sea-200: #dcefff;
            --sea-300: #c5e0ff;
            --sea-500: #8cbfe6;
            --sea-700: #4f84b8;
            --ink: #20324a;
            --ink-soft: #6d7f95;
            --powder-100: #f8fbff;
            --powder-200: #ecf5ff;
            --powder-300: #dbeaff;
            --powder-500: #91bde8;
            --shell: rgba(255, 255, 255, 0.88);
        }

        * {
            box-sizing: border-box;
            font-family: "Trebuchet MS", "Segoe UI", Arial, sans-serif;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 12% 10%, rgba(220, 239, 255, 0.75), transparent 24%),
                radial-gradient(circle at 88% 14%, rgba(245, 225, 255, 0.55), transparent 18%),
                linear-gradient(135deg, #ffffff 0%, #f7fbff 42%, #edf6ff 100%);
            color: var(--ink);
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                linear-gradient(115deg, rgba(255, 255, 255, 0.72) 0%, rgba(255, 255, 255, 0) 38%),
                repeating-linear-gradient(90deg, rgba(143, 189, 232, 0.08) 0 1px, transparent 1px 120px);
            pointer-events: none;
            z-index: 0;
        }

        .navbar {
            position: relative;
            z-index: 1;
            background: linear-gradient(90deg, #5f95dd 0%, #6aa0e6 55%, #74aaf0 100%);
            color: #ffffff;
            padding: 20px 32px;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            box-shadow: 0 18px 38px rgba(79, 143, 218, 0.20);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        }

        .layout {
            position: relative;
            z-index: 1;
            width: 100%;
            margin: 0;
            display: grid;
            grid-template-columns: 280px minmax(0, 1fr);
            min-height: calc(100vh - 68px);
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: calc(100vh - 68px);
            padding: 16px 14px 18px;
            background: transparent;
            backdrop-filter: blur(16px);
            display: flex;
            justify-content: center;
            align-items: stretch;
        }

        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 14%, rgba(255, 255, 255, 0.7), transparent 22%),
                radial-gradient(circle at 82% 8%, rgba(214, 232, 255, 0.7), transparent 20%),
                linear-gradient(135deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0));
            pointer-events: none;
        }

        .sidebar::after {
            content: "";
            position: absolute;
            left: -80px;
            bottom: -80px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(143, 189, 232, 0.18);
            filter: blur(12px);
            pointer-events: none;
        }

        .sidebar-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            border-radius: 30px;
            padding: 18px 16px 16px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.99) 0%, rgba(241, 248, 255, 0.98) 52%, rgba(214, 234, 255, 0.98) 100%);
            border: 1px solid rgba(143, 189, 232, 0.24);
            box-shadow: 0 24px 48px rgba(99, 169, 230, 0.12);
            display: flex;
            flex-direction: column;
            gap: 18px;
            overflow: hidden;
        }

        .sidebar-title {
            position: relative;
            z-index: 1;
            display: none;
        }

        .sidebar-brand {
            position: relative;
            z-index: 1;
            padding: 18px 12px 12px;
            border-radius: 24px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(237, 246, 255, 0.98));
            border: 1px solid rgba(143, 189, 232, 0.18);
            text-align: center;
            margin-bottom: 0;
        }

        .sidebar-text {
            display: none;
        }

        .sidebar-nav {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 12px;
            margin-top: 2px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 18px;
            border-radius: 18px;
            text-decoration: none;
            color: #5f7392;
            background: transparent;
            border: 1px solid transparent;
            transition:
                transform 0.24s ease,
                box-shadow 0.24s ease,
                border-color 0.24s ease,
                background 0.24s ease;
            box-shadow: none;
        }

        .sidebar-link:hover {
            transform: translateX(6px);
            color: #ffffff;
            background: linear-gradient(90deg, #8ac8ff 0%, #63a9e6 52%, #4f8fda 100%);
            box-shadow: 0 14px 28px rgba(99, 169, 230, 0.24);
        }

        .sidebar-link:hover small {
            color: rgba(255, 255, 255, 0.82);
        }

        .sidebar-link:hover span {
            color: #ffffff;
        }

        .sidebar-link span {
            font-weight: 700;
        }

        .sidebar-link small {
            color: #7c90aa;
            font-size: 12px;
        }

        .sidebar-link.logout {
            margin-top: auto;
            background: linear-gradient(135deg, #9fd7ff, #7fbaf0);
            color: #fff;
            border: 1px solid transparent;
            box-shadow: 0 16px 30px rgba(127, 186, 240, 0.18);
        }

        .sidebar-link.logout small {
            color: rgba(255, 255, 255, 0.84);
        }

        .main-content {
            min-width: 0;
            padding: 10px 20px 44px 4px;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: none;
            margin: 0 auto;
        }

        .page-top {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
        }

        .page-hero {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 24px 28px;
            border-radius: 26px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.98) 0%, rgba(247, 250, 255, 0.98) 58%, rgba(226, 241, 255, 0.96) 100%);
            border: 1px solid rgba(143, 189, 232, 0.20);
            box-shadow: 0 18px 42px rgba(99, 169, 230, 0.08);
            margin-bottom: 18px;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .page-hero::after {
            content: "";
            position: absolute;
            inset: auto -40px -40px auto;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 169, 230, 0.12), transparent 68%);
            pointer-events: none;
        }

        .page-hero-content {
            position: relative;
            z-index: 1;
        }

        .page-hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(227, 243, 255, 0.94);
            color: #2f74ba;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .page-hero-title {
            margin: 0;
            font-size: 42px;
            letter-spacing: -0.04em;
            line-height: 1.05;
            color: #173152;
        }

        .page-hero-subtitle {
            margin: 10px 0 0;
            color: #58708b;
            font-size: 17px;
            line-height: 1.6;
            max-width: 860px;
        }

        .page-title {
            margin: 0;
            font-size: 42px;
            letter-spacing: -0.04em;
            color: #22314a;
        }

        .page-subtitle {
            margin: 8px 0 0;
            color: var(--ink-soft);
            line-height: 1.65;
            max-width: 760px;
        }

        .section-title {
            margin: 0 0 12px;
            font-size: 22px;
            color: #4f84b8;
        }

        .chart-list {
            display: grid;
            gap: 12px;
        }

        .chart-row {
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr) 56px;
            align-items: center;
            gap: 12px;
        }

        .chart-label {
            font-weight: 700;
            color: var(--ink);
            font-size: 14px;
        }

        .chart-track {
            height: 14px;
            border-radius: 999px;
            background: rgba(143, 189, 232, 0.18);
            overflow: hidden;
        }

        .chart-fill {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #8cbfe6, #b7d8fb, #d7b5ea);
        }

        .chart-value {
            text-align: right;
            font-weight: 700;
            color: var(--sea-700);
        }

        .day-table {
            width: 100%;
            border-collapse: collapse;
        }

        .day-table th,
        .day-table td {
            padding: 11px 10px;
        }

        .rank-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 10px;
        }

        .rank-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 16px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(240, 246, 255, 0.94) 100%);
            border: 1px solid rgba(143, 189, 232, 0.16);
            font-weight: 700;
        }

        .rank-index {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #8cbfe6, #7aaee0);
            color: white;
            font-size: 13px;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: auto -40px -40px auto;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(143, 189, 232, 0.14), transparent 65%);
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: -30px auto auto 60%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(214, 232, 255, 0.2), transparent 70%);
        }

        .hero h1 {
            position: relative;
            z-index: 1;
            margin: 0 0 10px;
            font-size: 40px;
            letter-spacing: -0.04em;
        }

        .hero p {
            position: relative;
            z-index: 1;
            margin: 0;
            max-width: 720px;
            line-height: 1.7;
            color: var(--ink-soft);
        }

        .hero-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 12px;
            margin-top: 18px;
            position: relative;
            z-index: 1;
        }

        .hero-pill {
            padding: 14px 16px;
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(240, 246, 255, 0.94));
            border: 1px solid rgba(143, 189, 232, 0.16);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.76);
        }

        .hero-pill-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            opacity: 1;
            margin-bottom: 6px;
            color: #7b98bb;
        }

        .hero-pill-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--ink);
        }
        
        .card,
        .panel,
        .action-card,
        .mini-status {
            background: var(--shell);
            border: 1px solid rgba(143, 189, 232, 0.16);
            border-radius: 26px;
            box-shadow: 0 18px 42px rgba(79, 132, 184, 0.07);
            backdrop-filter: blur(14px);
        }

        .card,
        .panel,
        .action-card {
            padding: 22px;
        }

        .card h3,
        .panel h3,
        .action-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #4f84b8;
            letter-spacing: -0.02em;
        }

        .stat {
            font-size: 40px;
            font-weight: 700;
            margin: 6px 0 8px;
            color: var(--ink);
        }

        .circle-stat {
            min-height: 218px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
        }

        .circle-stat .number-bubble {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin-top: 10px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72), 0 14px 26px rgba(79, 132, 184, 0.10);
        }

        .shape-blue {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.98) 0%, rgba(232, 244, 255, 0.96) 52%, rgba(214, 232, 255, 0.88) 100%);
        }

        .shape-blue .number-bubble {
            background: rgba(255, 255, 255, 0.9);
            color: #4f84b8;
        }

        .shape-sand {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.98) 0%, rgba(244, 249, 255, 0.96) 62%, rgba(220, 239, 255, 0.9) 100%);
            border-radius: 24px 54px 24px 24px;
        }

        .shape-sand .number-bubble {
            background: rgba(255, 255, 255, 0.9);
            color: #5f8fbd;
        }

        .shape-alert {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.98) 0%, rgba(244, 249, 255, 0.95) 48%, rgba(228, 241, 255, 0.9) 100%);
            border-radius: 56px 24px 24px 24px;
        }

        .shape-alert .number-bubble {
            background: rgba(214, 232, 255, 0.88);
            color: #5f8fbd;
        }

        .muted {
            color: var(--ink-soft);
        }

        .summary-table {
            margin-bottom: 22px;
        }

        .summary-table-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-top: 12px;
        }

        .summary-item {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94) 0%, rgba(222, 241, 255, 0.34) 100%);
            border: 1px solid rgba(94, 168, 216, 0.18);
            border-radius: 20px;
            padding: 18px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .summary-title {
            font-size: 12px;
            color: #7d8f95;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .summary-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--sea-700);
            margin-bottom: 6px;
        }

        .summary-note {
            color: var(--ink-soft);
            font-size: 13px;
            line-height: 1.45;
        }

        .overview-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .mini-status-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 12px;
        }

        .mini-status {
            position: relative;
            padding: 18px 18px 16px;
            border-radius: 22px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(227, 243, 255, 0.88) 100%);
            border: 1px solid rgba(99, 169, 230, 0.18);
            box-shadow: 0 14px 28px rgba(47, 116, 186, 0.07);
            overflow: hidden;
        }

        .mini-status:nth-child(even) {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(235, 246, 255, 0.92) 100%);
            border-color: rgba(99, 169, 230, 0.22);
        }

        .mini-status::after {
            content: "";
            position: absolute;
            right: -18px;
            bottom: -22px;
            width: 82px;
            height: 82px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 169, 230, 0.14), transparent 68%);
            pointer-events: none;
        }

        .mini-status-title {
            font-size: 12px;
            color: #5f7fa3;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .mini-status strong {
            display: block;
            font-size: 36px;
            line-height: 1;
            color: #2f74ba;
            letter-spacing: -0.04em;
        }

        .warning {
            color: #4f87aa;
        }

        .success {
            color: #0c7a61;
        }
        
        .table-wrap {
            overflow-x: auto;
            border-radius: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid rgba(24, 52, 59, 0.08);
            vertical-align: top;
        }

        th {
            background: linear-gradient(90deg, rgba(45, 159, 134, 0.14), rgba(214, 236, 255, 0.42));
            color: var(--sea-700);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        table tr:hover td {
            background: rgba(243, 252, 248, 0.72);
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 16px;
        }

        .action-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94) 0%, rgba(243, 252, 248, 0.88) 100%);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .action-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 40px rgba(32, 88, 80, 0.12);
            border-color: rgba(94, 168, 216, 0.28);
        }

        .action-card p {
            color: #4e6870;
            line-height: 1.7;
            min-height: 72px;
        }

        .action-card.circle-stat {
            min-height: 218px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .shape-blue {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.96) 0%, rgba(220, 245, 235, 0.92) 52%, rgba(222, 241, 255, 0.82) 100%);
        }

        .shape-blue .number-bubble {
            background: rgba(255, 255, 255, 0.78);
            color: var(--sea-700);
        }

        .shape-sand {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.98) 0%, rgba(245, 251, 255, 0.94) 62%, rgba(199, 228, 255, 0.72) 100%);
            border-radius: 24px 54px 24px 24px;
        }

        .shape-sand .number-bubble {
            background: rgba(255, 255, 255, 0.82);
            color: #4f87aa;
        }

        .shape-alert {
            background: linear-gradient(160deg, rgba(244, 250, 255, 0.98) 0%, rgba(255, 255, 255, 0.96) 48%, rgba(193, 234, 220, 0.74) 100%);
            border-radius: 56px 24px 24px 24px;
        }

        .shape-alert .number-bubble {
            background: rgba(199, 228, 255, 0.82);
            color: #3e7ba3;
        }

        .shape-teal {
            background: linear-gradient(145deg, #9cc3e8 0%, #c5ddf6 58%, #e3f0ff 110%);
            border-radius: 24px 24px 54px 24px;
            color: var(--ink);
        }

        .shape-teal .number-bubble {
            background: rgba(255, 255, 255, 0.88);
            color: #4f84b8;
            box-shadow: none;
        }

        .shape-teal h3,
        .shape-teal p {
            color: var(--ink);
        }

        .number-bubble {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin-top: 10px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(214, 232, 255, 0.9);
            color: #5f8fbd;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .shape-teal .badge {
            background: rgba(255, 255, 255, 0.88);
            color: #5f8fbd;
        }

        .btn {
            display: inline-block;
            margin-top: 12px;
            padding: 11px 18px;
            background: linear-gradient(135deg, #8cbfe6, #7aaee0);
            color: white;
            text-decoration: none;
            border-radius: 14px;
            font-weight: 700;
            box-shadow: 0 12px 20px rgba(79, 132, 184, 0.16);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(79, 132, 184, 0.22);
            filter: saturate(1.05);
        }

        .btn-danger {
            background: linear-gradient(135deg, #c7dff4, #9fc2ea);
            box-shadow: 0 12px 22px rgba(79, 132, 184, 0.16);
        }

        .shape-teal .btn:not(.btn-danger) {
            background: white;
            color: #4f84b8;
            box-shadow: 0 14px 26px rgba(79, 132, 184, 0.12);
        }

        .empty {
            padding: 20px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px dashed rgba(143, 189, 232, 0.30);
            border-radius: 18px;
            color: var(--ink-soft);
        }

        @media (max-width: 980px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                height: auto;
            }

            .overview-grid {
                grid-template-columns: 1fr;
            }
        
            .mini-status-grid {
                grid-template-columns: 1fr 1fr;
            }
        
            .summary-table-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .page-top {
                align-items: flex-start;
                flex-direction: column;
            }
        }
        
        @media (max-width: 640px) {
            .navbar {
                padding: 18px 20px;
                font-size: 18px;
                letter-spacing: 0.08em;
            }

            .layout {
                min-height: auto;
            }

            .main-content {
                padding: 18px 14px 34px;
            }

            .hero {
                padding: 22px 20px;
                border-radius: 24px;
            }

            .hero h1 {
                font-size: 30px;
            }

            .summary-table-grid {
                grid-template-columns: 1fr;
            }

            .chart-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">Ana Sayfa</div>
    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-title">Admin Menu</div>
                <div class="sidebar-brand">
                    <img src="{{ asset('images/yoklama-app-logo.png') }}" alt="Yoklama App Logo" style="width: 100%; max-width: 190px; height: auto; display: block; margin: 0 auto;">
                </div>

                <nav class="sidebar-nav">
                    <a href="/admin" class="sidebar-link">
                        <div>
                            <span>Ana Sayfa</span><br>
                            <small>İlk panel ekranına dön</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/kullanicilar" class="sidebar-link">
                        <div>
                            <span>Kullanıcılar</span><br>
                            <small>Hesapları gör ve yönet</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/dersler" class="sidebar-link">
                        <div>
                            <span>Ders Yönetimi</span><br>
                            <small>Dersleri düzenle</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/ders-atama" class="sidebar-link">
                        <div>
                            <span>Ders Atama</span><br>
                            <small>Öğrenci ve öğretmen bağla</small>
                        </div>
                        <span>›</span>
                    </a>
                    <a href="/logout" class="sidebar-link logout">
                        <div>
                            <span>Çıkış</span><br>
                            <small>Oturumu sonlandır</small>
                        </div>
                        <span>›</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="main-content">
            <div class="container">
                <div class="page-hero">
                    <div class="page-hero-content">
                        <div class="page-hero-kicker">Ana Sayfa</div>
                        <h1 class="page-hero-title">Hoş geldin Admin</h1>
                        <p class="page-hero-subtitle">Sistemin genel durumunu tek bakışta görebilir, kullanıcı ve ders yönetimini hızlı kartlar üzerinden yapabilirsin.</p>
                    </div>
                </div>

                <div class="panel" style="margin-bottom: 18px;">
                    <h3 class="section-title">Hızlı Durum</h3>
                    <p class="muted" style="margin: -2px 0 14px; line-height: 1.6;">
                        Sistemin anlık özeti burada. Toplam kullanıcı, ders, atama ve aktif QR bilgilerini tek bakışta görebilirsin.
                    </p>
                    <div class="mini-status-grid">
                        <div class="mini-status">
                            <div class="mini-status-title">Toplam Kullanıcı</div>
                            <strong>{{ $istatistikler['toplam_kullanici'] }}</strong>
                        </div>
                        <div class="mini-status">
                            <div class="mini-status-title">Toplam Ders</div>
                            <strong>{{ $istatistikler['toplam_ders'] }}</strong>
                        </div>
                        <div class="mini-status">
                            <div class="mini-status-title">Toplam Atama</div>
                            <strong>{{ $istatistikler['toplam_atama'] }}</strong>
                        </div>
                        <div class="mini-status">
                            <div class="mini-status-title">Aktif QR</div>
                            <strong>{{ $istatistikler['aktif_qr'] }}</strong>
                        </div>
                    </div>
                </div>

                <div class="overview-grid" style="margin-top: 18px;">
                    <div class="panel">
                        <h3>En Aktif Öğrenciler</h3>
                        <ol class="rank-list">
                            @forelse($enAktifOgrenciler as $index => $ogrenci)
                                <li><span class="rank-index">{{ $index + 1 }}</span> {{ $ogrenci }}</li>
                            @empty
                                <div class="empty">Henüz öğrenci verisi yok.</div>
                            @endforelse
                        </ol>
                    </div>

                    <div class="panel">
    <h3>Yönetici Bilgilendirme</h3>

    <p class="muted" style="line-height:1.9;">
        • Sistem yönetimi yalnızca yetkili kullanıcılar tarafından yapılmalıdır.<br>
        • Kullanıcı ve ders bilgileri düzenli olarak güncellenmelidir.<br>
        • QR tabanlı yoklama işlemleri periyodik olarak kontrol edilmelidir.<br>
        • Sistem üzerinde gerçekleştirilen tüm işlemler kayıt altına alınmaktadır.<br>
        • Ders ve öğretmen atamalarının doğruluğu kontrol edilmelidir.
    </p>
</div>
                </div>

                                        
                     <div class="panel" style="margin-top: 18px;">
                       <h3>Yoklama App Hakkında</h3>

    <p class="muted" style="line-height:1.8;">
        Yoklama App, QR kod teknolojisi ile öğrenci devam takibini
        hızlı, güvenli ve dijital ortamda gerçekleştirmek amacıyla
        geliştirilmiş bir yoklama yönetim sistemidir.
    </p>

    <div class="summary-table-grid" style="margin-top:15px;">
        <div class="summary-item">
            <div class="summary-title">Sistem Versiyonu</div>
            <div class="summary-value">v1.0</div>
        </div>

        <div class="summary-item">
            <div class="summary-title">Son Güncelleme</div>
            <div class="summary-value" style="font-size:22px;">04.06.2026</div>
        </div>

        <div class="summary-item">
            <div class="summary-title">Geliştirici</div>
            <div class="summary-value" style="font-size:22px;">Tuğba Azsoy</div>
        </div>

        <div class="summary-item">
            <div class="summary-title">Durum</div>
            <div class="summary-value success">Aktif</div>
        </div>
    </div>
</div>
            </div>
        </main>
    </div>
</body>
</html>
