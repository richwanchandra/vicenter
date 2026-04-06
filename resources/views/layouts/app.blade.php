<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VILO Internal Center')</title>
    <script src="https://cdn.tailwindcss.com"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif, 'Montserrat';
        }

        body {
            background-color: #f8f9fa;
        }

        .sidebar-item.active {
            background-color: #e3f2fd;
            border-left: 4px solid #1976d2;
        }

        /* Sidebar Animation */
        #sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
        }

        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                transform: translateX(-100%);
            }
            #sidebar.mobile-open {
                transform: translateX(0);
            }
            #sidebar-overlay {
                display: none;
            }
            #sidebar-overlay.active {
                display: block;
            }
        }

        @media (min-width: 1024px) {
            #sidebar {
                transform: translateX(0) !important;
                position: relative;
            }
            #mobile-toggle {
                display: none;
            }
        }

        /* Table to Card Transformation */
        @media (max-width: 767px) {
            .responsive-table thead {
                display: none;
            }
            .responsive-table tbody tr {
                display: block;
                margin-bottom: 1rem;
                background: white;
                border-radius: 0.5rem;
                padding: 1rem;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .responsive-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 0;
                border: none;
                text-align: right;
            }
            .responsive-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
                margin-right: 1rem;
                color: #6b7280;
            }
        }

        .table-responsive-force-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    @stack('styles')
</head>

<body>
    @if(auth()->check() && !request()->routeIs('verification.notice', 'verification.verified'))
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 shadow-sm flex flex-col shrink-0">
                <div class="p-6 border-b flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-bold text-blue-600 logo-text">Vilo Internal</h1>
                        <p class="text-xs text-gray-500 logo-text">Internal System</p>
                    </div>
                    <button id="close-sidebar" class="lg:hidden text-gray-500 hover:text-blue-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- User Info -->
                <div class="p-4 bg-gray-50 border-b">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 overflow-y-auto p-4">
                    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <div class="mb-6">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Admin</p>
                            <a href="{{ route('admin.dashboard') }}"
                                class="sidebar-item block px-4 py-2 text-sm rounded hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-chart-line mr-2"></i>Dashboard
                            </a>
                            <a href="{{ route('user.home') }}"
                                class="sidebar-item block px-4 py-2 text-sm rounded hover:bg-gray-100">
                                <i class="fas fa-home mr-2"></i>Back to Home
                            </a>
                            <a href="{{ route('admin.modules.index') }}"
                                class="sidebar-item block px-4 py-2 text-sm rounded hover:bg-gray-100 {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                                <i class="fas fa-folder mr-2"></i>Modules
                            </a>
                            <a href="{{ route('admin.roles.index') }}"
                                class="sidebar-item block px-4 py-2 text-sm rounded hover:bg-gray-100 {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                <i class="fas fa-shield-alt mr-2"></i>Roles
                            </a>
                            <a href="{{ route('admin.user-roles.index') }}"
                                class="sidebar-item block px-4 py-2 text-sm rounded hover:bg-gray-100 {{ request()->routeIs('admin.user-roles.*') ? 'active' : '' }}">
                                <i class="fas fa-user-lock mr-2"></i>User Roles
                            </a>
                            @if(auth()->user()->isSuperAdmin()) 
                                <a href="{{ route('admin.users.index') }}"
                                    class="sidebar-item block px-4 py-2 text-sm rounded hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="fas fa-users mr-2"></i>Users
                                </a>
                            @endif
                        </div>
                    @endif

                    @if(!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin())
                        <div class="mb-6">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Modules</p>
                            @php
                                $ids = auth()->user()->accessibleModules();
                                $modules = \App\Models\Module::whereIn('id', $ids)
                                    ->where('parent_id', null)
                                    ->orderBy('order_number')
                                    ->get();
                            @endphp
                            @forelse($modules as $module)
                                <a href="{{ route('module.show', $module->slug) }}"
                                    class="sidebar-item block px-4 py-2 text-sm rounded hover:bg-gray-100 {{ request()->route('module.slug') === $module->slug ? 'active' : '' }}">
                                    <i class="fas fa-book mr-2"></i>{{ $module->name }}
                                </a>
                            @empty
                                <p class="px-4 py-2 text-xs text-gray-500">No modules assigned</p>
                            @endforelse
                        </div>
                    @endif

                    <div class="border-t pt-4">
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-auto bg-gray-50">
                <div class="bg-white border-b border-gray-200 p-4 lg:p-6 sticky top-0 z-10">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <button id="mobile-toggle" class="lg:hidden p-2 text-gray-500 hover:text-blue-600 border rounded">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 truncate">@yield('page_title')</h2>
                        </div>
                        <div class="flex items-center space-x-2 lg:space-x-4 overflow-x-auto pb-1 lg:pb-0">
                            @yield('header_actions')
                        </div>
                    </div>
                </div>

                <div class="p-4 lg:p-6">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    @else
        @yield('content')
    @endif


    @unless(request()->routeIs('admin.*', 'login', 'register', 'password.*'))
    <footer class="footer-modern py-5 text-center">
        <div class="container">
            <img src="/images/content/logo.svg" width="150" class="mb-4" alt="Vilo Logo">
            <div class="social-icons mb-4">
                <a href="https://api.whatsapp.com/send/?phone=628161639999" target="_blank" class="mx-2 text-dark"><i
                        class="fab fa-whatsapp fa-lg"></i></a>
                <a href="https://www.instagram.com/vilogelato/" target="_blank" class="mx-2 text-dark"><i
                        class="fab fa-instagram fa-lg"></i></a>
                <a href="https://tiktok.com/vilogelato" target="_blank" class="mx-2 text-dark"><i
                        class="fab fa-tiktok fa-lg"></i></a>
                <a href="https://www.linkedin.com/company/vilo-gelato01/" target="_blank" class="mx-2 text-dark"><i
                        class="fab fa-linkedin fa-lg"></i></a>
            </div>
            <p class="small text-muted mb-0">© 2026 Vilo Gelato. All rights reserved.</p>
        </div>
    </footer>
    @endunless

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            const sidebar = $('#sidebar');
            const overlay = $('#sidebar-overlay');
            const toggle = $('#mobile-toggle');
            const close = $('#close-sidebar');

            function toggleSidebar() {
                sidebar.toggleClass('mobile-open');
                overlay.toggleClass('active');
                $('body').toggleClass('overflow-hidden');
            }

            toggle.on('click', toggleSidebar);
            close.on('click', toggleSidebar);
            overlay.on('click', toggleSidebar);
        });
    </script>
    @stack('scripts')




</body>

</html>
