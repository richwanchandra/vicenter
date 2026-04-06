<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VILO Internal Management System - Operation Handbook">
    <title>@yield('title', 'VIMS - Operation Handbook')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- User CSS --}}
    <style>
        /* ============================================
           VIMS USER LAYOUT — Corporate Dark Theme
           ============================================ */

        :root {
            --vims-primary: #1a1e2e;
            --vims-primary-light: #252a3a;
            --vims-accent: #4f8cff;
            --vims-accent-hover: #6da0ff;
            --vims-accent-subtle: rgba(79, 140, 255, 0.08);
            --vims-bg: #f4f6f9;
            --vims-card: #ffffff;
            --vims-border: #e2e6ed;
            --vims-text: #2d3748;
            --vims-text-light: #718096;
            --vims-text-muted: #a0aec0;
            --vims-success: #48bb78;
            --vims-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
            --vims-shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08);
            --vims-radius: 8px;
            --vims-transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --vims-dropdown-bg: #252a3a;
            --vims-dropdown-text: #E6EAF2;
            --vims-dropdown-hover-bg: rgba(255, 255, 255, 0.06);
            --vims-submenu-bg: rgba(255, 255, 255, 0.04);
            --vims-gold: #b88a44;
        }

        html {
            scroll-behavior: smooth;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--vims-bg);
            color: var(--vims-text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ---- Typography ---- */
        h1,
        .vims-h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            font-size: 2rem;
            color: var(--vims-primary);
            line-height: 1.3;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--vims-primary);
        }

        h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--vims-primary);
        }

        /* ---- Top Bar ---- */
        .vims-topbar {
            background: var(--vims-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            height: 60px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .vims-topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #fff;
        }

        .vims-topbar-brand-icon {
            width: 36px;
            height: 36px;
            background: var(--vims-accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .vims-topbar-brand-text h1 {
            font-family: 'Inter', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .vims-topbar-brand-text span {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.3px;
        }

        .vims-topbar-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .vims-user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .vims-user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--vims-accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .vims-user-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--vims-text);
        }

        .vims-logout-btn {
            background: none;
            border: 1px solid var(--vims-border);
            color: var(--vims-text-light);
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: var(--vims-transition);
        }

        .vims-logout-btn:hover {
            background: var(--vims-bg);
            color: var(--vims-accent);
            border-color: var(--vims-accent-subtle);
        }

        /* ---- Main Navbar ---- */
        .vims-navbar {
            background: var(--vims-card);
            border-bottom: 1px solid var(--vims-border);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .vims-navbar-inner {
            display: flex;
            align-items: center;
            padding: 0 2rem;
            overflow: visible;
        }

        .vims-navbar-inner::-webkit-scrollbar {
            height: 0;
        }

        .vims-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-right: 1.5rem;
            margin-right: 1rem;
            border-right: none;
        }

        .vims-brand-logo {
            height: 36px;
            display: block;
        }

        .vims-navbar-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .vims-menu {
            display: flex;
            align-items: stretch;
            justify-content: center;
            gap: 0.5rem;
            flex: 1;
        }

        .vims-nav-root {
            position: relative;
        }

        .vims-nav-root>.vims-nav-link {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.85rem 1.1rem;
            color: var(--vims-text);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            white-space: nowrap;
            transition: var(--vims-transition);
            border-bottom: 2px solid transparent;
        }

        .vims-nav-root>.vims-nav-link:hover,
        .vims-nav-root.active>.vims-nav-link {
            color: var(--vims-accent);
            background: transparent;
            border-bottom-color: var(--vims-accent);
        }

        .vims-nav-link .caret {
            font-size: 0.6rem;
            transition: transform var(--vims-transition);
        }

        /* ---- Dropdown Panel ---- */
        .vims-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 280px;
            background: var(--vims-card);
            border: 1px solid var(--vims-border);
            border-radius: 0 0 var(--vims-radius) var(--vims-radius);
            box-shadow: var(--vims-shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-4px);
            transition: opacity 0.2s, transform 0.2s, visibility 0.2s;
            z-index: 1002;
        }

        .vims-nav-root:hover>.vims-dropdown,
        .vims-nav-root.open>.vims-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* ---- Mega Dropdown ---- */
        .vims-mega {
            background: var(--vims-card);
            color: var(--vims-text);
            min-width: 760px;
            padding: 0;
        }

        .vims-mega .vims-mega-inner {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 280px;
        }

        .vims-mega-left {
            background: #fafafa;
            border-right: 1px solid var(--vims-border);
            padding: 1rem 0;
        }

        .vims-mega-left-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.25rem;
            color: var(--vims-text);
            text-decoration: none;
            transition: var(--vims-transition);
        }

        .vims-mega-left-item:hover,
        .vims-mega-left-item.active {
            color: var(--vims-gold);
            background: rgba(184, 138, 68, 0.08);
        }

        .vims-mega-left-item i {
            color: var(--vims-gold);
            font-size: 0.85rem;
        }

        .vims-mega-right {
            padding: 1.25rem 1.5rem 1.75rem;
        }

        .vims-mega-panel {
            display: none;
            animation: fadeIn 0.18s ease;
        }

        .vims-mega-panel.active {
            display: block;
        }

        .vims-mega-panel h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--vims-gold);
            margin-bottom: 0.75rem;
        }

        .vims-mega-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.5rem 2rem;
        }

        .vims-mega-link {
            display: inline-block;
            color: var(--vims-text);
            text-decoration: none;
            padding: 0.3rem 0;
            transition: var(--vims-transition);
        }

        .vims-mega-link:hover {
            color: var(--vims-accent);
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .vims-dropdown-list {
            list-style: none;
            padding: 0.5rem 0;
        }

        .vims-dropdown-item {
            position: relative;
        }

        .vims-dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 1.2rem;
            color: var(--vims-text);
            text-decoration: none;
            font-size: 0.82rem;
            transition: var(--vims-transition);
        }

        .vims-dropdown-link:hover {
            background: var(--vims-accent-subtle);
            color: var(--vims-accent);
        }

        .vims-dropdown-link.active-link {
            background: var(--vims-accent-subtle);
            color: var(--vims-accent);
            font-weight: 600;
        }

        .vims-dropdown-link .sub-caret {
            font-size: 0.55rem;
            color: var(--vims-text-muted);
            transition: transform var(--vims-transition);
        }

        /* ---- Nested Submenu (Accordion style inside dropdown) ---- */
        .vims-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(0, 0, 0, 0.015);
        }

        .vims-submenu.open {
            max-height: 2000px;
        }

        .vims-submenu .vims-dropdown-link {
            padding-left: 2rem;
            font-size: 0.8rem;
            color: var(--vims-text-light);
        }

        .vims-submenu .vims-submenu .vims-dropdown-link {
            padding-left: 3rem;
            font-size: 0.78rem;
        }

        .vims-submenu .vims-submenu .vims-submenu .vims-dropdown-link {
            padding-left: 4rem;
            font-size: 0.76rem;
        }

        .vims-dropdown-item.expanded>.vims-dropdown-link .sub-caret .fa-chevron-down {
            display: none;
        }

        .vims-dropdown-item:not(.expanded)>.vims-dropdown-link .sub-caret .fa-chevron-up {
            display: none;
        }

        .vims-dropdown-item.expanded>.vims-dropdown-link .sub-caret {
            transform: rotate(0);
        }

        /* ---- Breadcrumb ---- */
        .vims-breadcrumb {
            padding: 1rem 2.5rem;
            background: var(--vims-card);
            border-bottom: 1px solid var(--vims-border);
        }

        .vims-breadcrumb-list {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            flex-wrap: wrap;
        }

        .vims-breadcrumb-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.82rem;
        }

        .vims-breadcrumb-list li a {
            color: var(--vims-accent);
            text-decoration: none;
            transition: var(--vims-transition);
        }

        .vims-breadcrumb-list li a:hover {
            color: var(--vims-accent-hover);
            text-decoration: underline;
        }

        .vims-breadcrumb-list li span.current {
            color: var(--vims-text-light);
            font-weight: 500;
        }

        .vims-breadcrumb-separator {
            color: var(--vims-text-muted);
            font-size: 0.7rem;
        }

        /* ---- Main Content ---- */
        .vims-main {
            max-width: 960px;
            margin: 0 auto;
            padding: 2.5rem;
        }

        .vims-content-card {
            background: var(--vims-card);
            border: 1px solid var(--vims-border);
            border-radius: var(--vims-radius);
            padding: 2.5rem;
            box-shadow: var(--vims-shadow);
            margin-bottom: 1.5rem;
        }

        .vims-content-card h1 {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--vims-border);
        }

        /* Content body prose */
        .vims-prose {
            font-size: 0.95rem;
            line-height: 1.8;
            color: var(--vims-text);
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
        }

        .vims-prose i,
        .vims-prose em {
            font-style: italic !important;
        }

        .vims-prose p {
            margin-bottom: 1rem;
        }

        .vims-prose h2 {
            margin: 2rem 0 1rem;
            font-size: 1.35rem;
        }

        .vims-prose h3 {
            margin: 1.5rem 0 0.75rem;
            font-size: 1.1rem;
        }

        .vims-prose ul,
        .vims-prose ol {
            margin: 0.75rem 0;
            padding-left: 1.5rem;
        }

        .vims-prose li {
            margin-bottom: 0.4rem;
        }

        .vims-prose img {
            max-width: 100% !important;
            height: auto !important;
            display: block;
            margin: 1.5rem auto;
            border-radius: var(--vims-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .vims-prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            min-width: 640px;
        }

        .vims-prose th,
        .vims-prose td {
            padding: 0.6rem 1rem;
            border: 1px solid var(--vims-border);
            text-align: left;
        }

        .vims-prose th {
            background: var(--vims-bg);
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Responsive table wrapper */
        .vims-table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border: 1px solid var(--vims-border);
            border-radius: var(--vims-radius);
            background: #fff;
        }

        @media (max-width: 768px) {
            .vims-prose table {
                min-width: 520px;
            }
            .vims-prose th,
            .vims-prose td {
                padding: 0.5rem 0.75rem;
            }
        }

        .vims-prose blockquote {
            border-left: 3px solid var(--vims-accent);
            padding: 0.75rem 1.25rem;
            margin: 1rem 0;
            background: var(--vims-accent-subtle);
            border-radius: 0 var(--vims-radius) var(--vims-radius) 0;
        }

        .vims-prose a {
            color: var(--vims-accent);
            text-decoration: none;
        }

        .vims-prose a:hover {
            text-decoration: underline;
        }

        /* ---- Child Modules Grid ---- */
        .vims-children-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .vims-child-card {
            background: var(--vims-card);
            border: 1px solid var(--vims-border);
            border-radius: var(--vims-radius);
            padding: 1.25rem;
            text-decoration: none;
            color: var(--vims-text);
            transition: var(--vims-transition);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .vims-child-card:hover {
            border-color: var(--vims-accent);
            box-shadow: var(--vims-shadow-lg);
            transform: translateY(-2px);
        }

        .vims-child-card-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--vims-accent-subtle);
            color: var(--vims-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .vims-child-card-text h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--vims-primary);
        }

        .vims-child-card-text span {
            font-size: 0.75rem;
            color: var(--vims-text-muted);
        }

        /* ---- Dashboard Cards ---- */
        .vims-dashboard-hero {
            text-align: center;
            padding: 3rem 2rem 2rem;
        }

        .vims-dashboard-hero h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .vims-dashboard-hero p {
            color: var(--vims-text-light);
            font-size: 0.95rem;
        }

        .vims-module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.25rem;
            padding: 0 2.5rem 3rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .vims-module-card {
            background: var(--vims-card);
            border: 1px solid var(--vims-border);
            border-radius: var(--vims-radius);
            padding: 1.5rem;
            text-decoration: none;
            color: var(--vims-text);
            transition: var(--vims-transition);
            display: flex;
            flex-direction: column;
        }

        .vims-module-card:hover {
            border-color: var(--vims-accent);
            box-shadow: var(--vims-shadow-lg);
            transform: translateY(-3px);
        }

        .vims-module-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .vims-module-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--vims-accent), #7c5cff);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .vims-module-card-icon.alt1 {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }

        .vims-module-card-icon.alt2 {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
        }

        .vims-module-card-icon.alt3 {
            background: linear-gradient(135deg, #e53e3e, #c53030);
        }

        .vims-module-card-icon.alt4 {
            background: linear-gradient(135deg, #9f7aea, #805ad5);
        }

        .vims-module-card-icon.alt5 {
            background: linear-gradient(135deg, #38b2ac, #319795);
        }

        .vims-module-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--vims-primary);
        }

        .vims-module-card-desc {
            font-size: 0.82rem;
            color: var(--vims-text-light);
            margin-top: auto;
        }

        /* ---- Attachments Section ---- */
        .vims-attachments {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--vims-border);
        }

        .vims-attachments h3 {
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            color: var(--vims-text-light);
        }

        /* ---- Empty State ---- */
        .vims-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--vims-text-muted);
        }

        .vims-empty i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .vims-empty p {
            font-size: 1rem;
        }

        /* ---- Flash Messages ---- */
        .vims-flash {
            padding: 0.85rem 1.25rem;
            border-radius: var(--vims-radius);
            margin-bottom: 1.5rem;
            font-size: 0.88rem;
        }

        .vims-flash-success {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            color: #276749;
        }

        .vims-flash-error {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #9b2c2c;
        }

        /* ---- Mobile Hamburger ---- */
        .vims-hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--vims-text);
            font-size: 1.3rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        .vims-mobile-topbar,
        .vims-mobile-menu-header,
        .vims-mobile-back {
            display: none;
        }

        /* ---- Responsive ---- */
        @media (max-width: 768px) {
            .vims-mobile-topbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1.5rem;
                background: var(--vims-card);
                border-bottom: 1px solid var(--vims-border);
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .vims-mobile-logo {
                height: 32px;
            }

            .vims-topbar {
                padding: 0 1rem;
            }

            .vims-hamburger {
                display: block;
            }

            .vims-user-name {
                display: none;
            }

            .vims-navbar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100vh;
                background: #fff;
                border-right: none;
                box-shadow: none;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1001;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
            }

            .vims-navbar.mobile-open {
                left: 0;
            }

            .vims-mobile-menu-header {
                background: var(--vims-primary);
                padding: 1.25rem 1.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                color: #fff;
            }

            .vims-mobile-menu-header .vims-brand-logo {
                height: 40px;
                filter: brightness(0) invert(1);
            }

            .vims-mobile-close {
                background: none;
                border: none;
                color: #fff;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .vims-mobile-back {
                background: #fff;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid var(--vims-border);
                display: none;
                align-items: center;
                gap: 0.75rem;
                color: var(--vims-primary);
                font-weight: 600;
                font-size: 0.95rem;
                cursor: pointer;
            }

            .vims-mobile-back.active {
                display: flex;
            }

            .vims-navbar-inner {
                flex-direction: column;
                padding: 0;
                height: auto;
                flex: 1;
                display: block;
            }

            .vims-brand {
                display: none !important;
            }

            .vims-menu {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                padding: 0;
            }

            .vims-nav-root {
                border-bottom: 1px solid #f0f0f0;
            }

            .vims-nav-root>.vims-nav-link {
                color: var(--vims-text);
                padding: 1.1rem 1.5rem;
                border-bottom: none;
                border-left: none;
                justify-content: space-between;
                font-size: 1rem;
                font-weight: 400;
            }

            .vims-nav-root.has-children>.vims-nav-link {
                color: var(--vims-gold);
                font-weight: 600;
            }

            .vims-nav-root.active>.vims-nav-link {
                color: var(--vims-accent);
                background: transparent;
            }

            .vims-nav-root>.vims-nav-link .caret {
                font-size: 0.8rem;
                color: var(--vims-text-muted);
            }

            .vims-nav-root.active-subview > .vims-nav-link {
                display: none !important;
            }

            .vims-nav-root.open > .vims-nav-link .caret {
                transform: rotate(90deg);
            }

            .vims-dropdown {
                position: static;
                box-shadow: none;
                border: none;
                border-radius: 0;
                opacity: 1;
                visibility: visible;
                transform: none;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
                background: #fff;
            }

            .vims-nav-root.open>.vims-dropdown {
                max-height: 2000px;
            }

            .vims-dropdown-link {
                padding: 1rem 1.5rem;
                font-size: 0.95rem;
                border-bottom: 1px solid #f8f8f8;
            }

            .vims-mega {
                min-width: auto;
                width: 100%;
                padding: 0;
            }

            .vims-mega .vims-mega-inner {
                display: block;
            }

            .vims-mega-left {
                display: none; /* Sembunyikan daftar kiri di mobile */
            }

            .vims-mega-right {
                padding: 0;
            }

            .vims-mega-panel {
                display: block;
            }

            .vims-mega-grid {
                display: none; /* Sembunyikan grid secara default di mobile */
            }

            .vims-mega-grid.show {
                display: block; /* Tampilkan grid saat memiliki class .show */
            }

            .vims-mega-panel-header.active .grid-caret .fa-chevron-down {
                display: none;
            }
            
            .vims-mega-panel-header:not(.active) .grid-caret .fa-chevron-up {
                display: none;
            }

            .vims-mobile-only {
                display: inline-block !important;
            }

            .vims-mega-panel-header {
                padding: 1rem 1.5rem;
                border-bottom: 1px solid #f8f8f8;
            }

            .vims-mega-panel-header h4 {
                margin-bottom: 0 !important;
                font-size: 0.95rem;
                font-weight: 600;
            }

            .vims-mega-link {
                display: block;
                padding: 0.9rem 2.5rem;
                border-bottom: 1px solid #f8f8f8;
                font-size: 0.9rem;
            }

            .vims-navbar-actions {
                margin: 0;
                padding: 0;
                border-top: 1px solid var(--vims-border);
                flex-direction: column;
                align-items: stretch;
            }

            .vims-user-info {
                padding: 1.1rem 1.5rem;
                border-bottom: 1px solid #f0f0f0;
                margin-bottom: 0;
            }

            .vims-navbar-actions .vims-nav-root .vims-nav-link {
                padding: 1.1rem 1.5rem;
            }

            .vims-logout-btn {
                width: 100%;
                text-align: left;
                padding: 1.1rem 1.5rem;
                border: none;
                border-bottom: 1px solid #f0f0f0;
                border-radius: 0;
                color: var(--vims-text);
                font-size: 1rem;
            }

            .vims-main {
                padding: 1.5rem;
            }

            .vims-content-card {
                padding: 1.5rem;
            }

            .vims-module-grid {
                padding: 0 1.5rem 2rem;
            }

            .vims-breadcrumb {
                padding: 0.75rem 1.5rem;
            }
        }

        /* ---- Mobile Overlay ---- */
        .vims-overlay {
            display: none;
            position: fixed;
            inset: 0;
            top: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .vims-overlay.active {
            display: block;
        }

        /* ---- Footer ---- */
        .vims-footer {
            background: var(--vims-card);
            border-top: 1px solid var(--vims-border);
            padding: 4rem 0 3rem;
            text-align: center;
        }

        .vims-footer-logo {
            height: 60px;
            width: auto;
            margin-bottom: 2rem;
            transition: var(--vims-transition);
        }

        .vims-footer-socials {
            display: flex;
            justify-content: center;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .vims-footer-socials a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: #185b9d;
            /* Vilo Blue */
            color: #fff;
            border-radius: 50%;
            font-size: 1.1rem;
            transition: var(--vims-transition);
            box-shadow: 0 4px 10px rgba(24, 91, 157, 0.2);
            text-decoration: none;
        }

        .vims-footer-socials a:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(24, 91, 157, 0.35);
            background: #13467a;
            color: #fff;
        }

        .vims-footer-copy {
            font-size: 0.85rem;
            color: var(--vims-text-light);
        }
    </style>

    @stack('styles')
</head>

<body>
    {{-- Mobile Topbar --}}
    <div class="vims-mobile-topbar">
        <a href="{{ route('dashboard') }}" class="vims-brand-link">
            <img src="/images/content/logo.svg" alt="VILO" class="vims-mobile-logo">
        </a>
        <button class="vims-hamburger" id="vims-mobile-hamburger" aria-label="Toggle menu" title="Menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    {{-- Navbar (with brand and actions) --}}
    <nav class="vims-navbar" id="vims-navbar">
        <div class="vims-mobile-menu-header">
            <a href="{{ route('dashboard') }}">
                <img src="/images/content/logo.svg" alt="VILO" class="vims-brand-logo">
            </a>
            <button class="vims-mobile-close" id="vims-mobile-close" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="vims-mobile-back" id="vims-mobile-back">
            <i class="fas fa-chevron-left"></i>
            <span id="vims-mobile-back-text">Back</span>
        </div>

        <div class="vims-navbar-inner">
            <div class="vims-brand">
                <button class="vims-hamburger" id="vims-hamburger" aria-label="Toggle menu" title="Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="vims-brand-link" aria-label="Home">
                    <img src="/images/content/logo.svg" alt="VILO" class="vims-brand-logo">
                </a>
            </div>

            <div class="vims-menu">
                <div class="vims-nav-root">
                    <a href="{{ route('user.home') }}" class="vims-nav-link">Home</a>
                </div>
                <div class="vims-nav-root">
                    <a href="{{ route('user.story') }}" class="vims-nav-link">Vilo Story</a>
                </div>

                @php
                    if (!isset($moduleTree) && auth()->check()) {
                        $moduleTree = app(\App\Services\ModuleTreeService::class)->getTreeForUser(auth()->user());
                    }
                @endphp


                @if(isset($moduleTree))
                    @foreach($moduleTree as $rootModule)
                        @include('components.user-nav-item', ['module' => $rootModule, 'isRoot' => true])
                    @endforeach
                @endif

             

                <div class="vims-nav-root {{ request()->routeIs('user.contact') ? 'active' : '' }}">
                    <a href="{{ route('user.contact') }}" class="vims-nav-link">Contact Us</a>
                </div>
                <div class="vims-navbar-actions">
                    <div class="vims-nav-root">
                        <a href="#" class="vims-nav-link" style="gap: 0.5rem; cursor: pointer; padding-right: 0;">
                            <i class="fas fa-user-circle" style="font-size: 1.25rem;"></i>
                            <span style="font-weight: 500;">{{ auth()->user()->name }}</span>
                            <i class="fas fa-caret-down caret"></i>
                        </a>

                        <div class="vims-dropdown" style="min-width: 180px; right: 0; left: auto;">
                            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="vims-dropdown-link" style="margin:0; border-bottom: 1px solid #f0f0f0;">
                                    <span><i class="fas fa-user-shield mr-2 text-blue-600"></i> Admin Dashboard</span>
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" style="margin:0">
                                @csrf
                                <button type="submit" class="vims-dropdown-link"
                                    style="width: 100%; border: none; background: transparent; text-align: left; cursor: pointer;">
                                    <span><i class="fas fa-sign-out-alt mr-2 text-red-500"></i> Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </nav>

    {{-- Mobile Overlay --}}
    <div class="vims-overlay" id="vims-overlay"></div>

    {{-- Hero Section (Full Width) --}}
    @yield('hero')

    {{-- Breadcrumb --}}


    {{-- Flash Messages --}}
    <div class="vims-main">
        @if(session('success'))
            <div class="vims-flash vims-flash-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="vims-flash vims-flash-error">
                <ul style="list-style:none">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="vims-footer">
        <div class="vims-main" style="padding: 0 2.5rem;">
            <img src="/images/content/logo.svg" class="vims-footer-logo" alt="Vilo Logo">
            <div class="vims-footer-socials">
                <a href="https://api.whatsapp.com/send/?phone=628161639999" target="_blank" aria-label="WhatsApp"><i
                        class="fab fa-whatsapp"></i></a>
                <a href="https://www.instagram.com/vilogelato/" target="_blank" aria-label="Instagram"><i
                        class="fab fa-instagram"></i></a>
                <a href="https://tiktok.com/vilogelato" target="_blank" aria-label="TikTok"><i
                        class="fab fa-tiktok"></i></a>
                <a href="https://www.linkedin.com/company/vilo-gelato01/" target="_blank" aria-label="LinkedIn"><i
                        class="fab fa-linkedin"></i></a>
            </div>
            <p class="vims-footer-copy">© 2026 Vilo Gelato. All rights reserved.</p>
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Mobile menu toggle ---
            const hamburger = document.getElementById('vims-hamburger');
            const mobileHamburger = document.getElementById('vims-mobile-hamburger');
            const mobileClose = document.getElementById('vims-mobile-close');
            const mobileBack = document.getElementById('vims-mobile-back');
            const mobileBackText = document.getElementById('vims-mobile-back-text');
            const navbar = document.getElementById('vims-navbar');
            const overlay = document.getElementById('vims-overlay');
            const menu = document.querySelector('.vims-menu');

            function toggleMenu() {
                navbar.classList.toggle('mobile-open');
                overlay.classList.toggle('active');
                if (!navbar.classList.contains('mobile-open')) {
                    resetMobileMenu();
                }
            }

            function resetMobileMenu() {
                document.querySelectorAll('.vims-nav-root').forEach(el => {
                    el.classList.remove('open', 'active-subview');
                    el.style.display = '';
                });
                mobileBack.classList.remove('active');
            }

            if (hamburger) hamburger.addEventListener('click', toggleMenu);
            if (mobileHamburger) mobileHamburger.addEventListener('click', toggleMenu);
            if (mobileClose) mobileClose.addEventListener('click', toggleMenu);

            if (mobileBack) {
                mobileBack.addEventListener('click', function() {
                    resetMobileMenu();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', toggleMenu);
            }

            // --- Desktop: dropdown on hover handled by CSS ---
            // Mega menu (left list controls right panel)
            document.querySelectorAll('.vims-mega').forEach(function (mega) {
                const leftItems = mega.querySelectorAll('.vims-mega-left-item');
                const panels = mega.querySelectorAll('.vims-mega-panel');
                const activate = function (id) {
                    panels.forEach(function (p) { p.classList.toggle('active', p.id === id); });
                    leftItems.forEach(function (a) { a.classList.toggle('active', a.dataset.target === id); });
                };
                if (leftItems.length > 0) {
                    activate(leftItems[0].dataset.target);
                }
                leftItems.forEach(function (a) {
                    a.addEventListener('mouseenter', function () { activate(a.dataset.target); });
                    a.addEventListener('focus', function () { activate(a.dataset.target); });
                });
            });

            // --- Mobile & nested accordion toggle ---
            document.querySelectorAll('.vims-toggle-sub').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const item = this.closest('.vims-dropdown-item, .vims-nav-root');
                    const submenu = item.querySelector(':scope > .vims-submenu, :scope > .vims-dropdown');

                    if (submenu) {
                        item.classList.toggle('expanded');
                        item.classList.toggle('open');
                        submenu.classList.toggle('open');
                    }
                });
            });

            // --- Mobile sub-sub content (grid) toggle ---
            if (window.innerWidth <= 768) {
                document.querySelectorAll('.vims-mobile-toggle-grid').forEach(function (header) {
                    header.addEventListener('click', function (e) {
                        e.preventDefault();
                        const panel = this.closest('.vims-mega-panel');
                        const grid = panel.querySelector('.vims-mega-grid');
                        if (grid) {
                            grid.classList.toggle('show');
                            this.classList.toggle('active');
                        }
                    });
                });
            }

            // --- Mobile root toggle ---
            if (window.innerWidth <= 768) {
                document.querySelectorAll('.vims-nav-root > .vims-nav-link').forEach(function (link) {
                    const root = link.closest('.vims-nav-root');
                    const dropdown = root.querySelector(':scope > .vims-dropdown');

                    if (dropdown) {
                        link.addEventListener('click', function (e) {
                            e.preventDefault();
                            
                            // Hide other root items
                            document.querySelectorAll('.vims-nav-root').forEach(el => {
                                if (el !== root) el.style.display = 'none';
                            });

                            root.classList.add('open', 'active-subview');
                            mobileBack.classList.add('active');
                            mobileBackText.textContent = link.textContent.trim();
                        });
                    }
                });

                document.querySelectorAll('.vims-dropdown-link').forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (navbar.classList.contains('mobile-open')) {
                            toggleMenu();
                        }
                    });
                });
            }

            // --- Wrap tables inside module content for responsiveness ---
            document.querySelectorAll('.vims-prose table').forEach(function(tbl){
                const wrap = document.createElement('div');
                wrap.className = 'vims-table-wrap';
                const parent = tbl.parentNode;
                parent.insertBefore(wrap, tbl);
                wrap.appendChild(tbl);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
