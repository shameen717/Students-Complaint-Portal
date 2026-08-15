<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Complaint Portal') | IUB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-scp sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            {{-- IUB Logo: use official SVG/PNG from public/images/iub-logo.png if available --}}
            <img src="{{ asset('images/iub-logo.png') }}"
                 onerror="this.style.display='none'"
                 alt="IUB" class="navbar-brand-logo">
            <span class="navbar-brand-text">
                <span class="navbar-brand-title">Student Complaint Portal</span>
                <span class="navbar-brand-sub">Islamia University of Bahawalpur</span>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-1"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.complaints.index') }}"><i class="fa-solid fa-list-check me-1"></i>Manage Complaints</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('complaints.create') }}"><i class="fa-solid fa-plus me-1"></i>Register Complaint</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('complaints.index') }}"><i class="fa-solid fa-inbox me-1"></i>My Complaints</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('complaints.track') }}"><i class="fa-solid fa-magnifying-glass me-1"></i>Track</a></li>
                    <li class="nav-item ms-lg-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-scp-outline" type="submit" style="padding:.5rem 1.3rem;">
                                <i class="fa-solid fa-right-from-bracket me-1"></i>{{ Str::limit(auth()->user()->name, 12) }}
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('complaints.track') }}"><i class="fa-solid fa-magnifying-glass me-1"></i>Track Complaint</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn-scp" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fa-solid fa-triangle-exclamation me-1"></i>Please fix the following:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<footer class="footer-scp text-center py-3 mt-5">
    <small>
        <img src="{{ asset('images/iub-logo.png') }}" onerror="this.style.display='none'" alt="" style="height:18px;vertical-align:middle;margin-right:6px;filter:brightness(0) invert(1);opacity:.7;">
        &copy; {{ date('Y') }} The Islamia University of Bahawalpur — Department of Information Technology &middot; Student Complaint Portal (FYP)
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
