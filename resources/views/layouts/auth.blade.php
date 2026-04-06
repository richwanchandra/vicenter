<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Vilo Gelato</title>
    

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-free/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <style>
        :root {
            --vilo-blue: #1d4e89;
            --vilo-light-blue: #f0f5fa;
            --vilo-font: "Avenir Next", "Avenir", sans-serif;
        }
        body {
            font-family: var(--vilo-font);
            background-color: var(--vilo-light-blue);
        }
        .bg-login {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .brand-logo {
            color: var(--vilo-blue);
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: -0.02em;
            text-decoration: none;
        }
        .vilo-sign-in {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 30px;
            text-transform: uppercase;
        }
        .btn-vilo {
            background-color: var(--vilo-blue);
            color: #ffffff;
            padding: 12px;
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-vilo:hover {
            background-color: #153a66;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-login">
        <div class="row w-100 align-items-center justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="text-center mb-4">
                    <a href="/" class="brand-logo">VILO GELATO INTERNAL</a>
                    <h3 class="vilo-sign-in">@yield('page-title')</h3>
                </div>

                {{-- Error Handling --}}
                @if ($errors->any())
                    <div class="alert alert-danger py-2" style="font-size: 0.85rem;">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success py-2" style="font-size: 0.85rem;">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Main Form Content --}}
                <div class="card border-0 shadow-sm p-4" style="border-radius: 8px;">
                    @yield('content')
                </div>

                <div class="text-center mt-4">
                    <p class="small text-muted">
                        &copy; 2026 Vilo Gelato. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('scripts')
</body>
</html>