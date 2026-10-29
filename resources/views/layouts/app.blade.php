<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tryout Online') — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
    :root{
        --sidebar-w: 260px;

        --primary: #16a34a;
        --primary-dark: #15803d;
        --primary-soft: #dcfce7;

        --bg: #f0fdf4;
        --card: #ffffff;
        --text: #1f2937;
        --muted: #6b7280;
        --border: #e5e7eb;
    }

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    body{
        background: linear-gradient(135deg,#f0fdf4,#ecfeff);
        font-family: 'Segoe UI', sans-serif;
        color: var(--text);
    }

    /* SIDEBAR */

    .sidebar{
        width: var(--sidebar-w);
        min-height: 100vh;
        position: fixed;
        top:0;
        left:0;

        background: linear-gradient(180deg,#166534,#15803d);
        color:white;

        display:flex;
        flex-direction:column;

        box-shadow: 4px 0 20px rgba(0,0,0,.08);
        z-index:100;
    }

    .sidebar .brand{
        padding: 1.5rem;
        font-size: 1.25rem;
        font-weight: 700;

        border-bottom:1px solid rgba(255,255,255,.12);

        display:flex;
        align-items:center;
        gap:10px;
    }

    .sidebar .nav-link{
        color: rgba(255,255,255,.8);

        padding: .9rem 1.2rem;
        margin: .2rem .7rem;

        border-radius: 14px;

        transition: .25s ease;

        display:flex;
        align-items:center;

        font-weight:500;
    }

    .sidebar .nav-link i{
        margin-right: .8rem;
        font-size: 1rem;
    }

    .sidebar .nav-link:hover{
        background: rgba(255,255,255,.12);
        color:#fff;
        transform: translateX(4px);
    }

    .sidebar .nav-link.active{
        background:white;
        color: var(--primary-dark);
        font-weight:600;
    }

    /* MAIN */

    .main{
        margin-left: var(--sidebar-w);
        padding: 2rem;
    }

    /* TOPBAR */

    .topbar{
        background: rgba(255,255,255,.75);

        backdrop-filter: blur(10px);

        border:1px solid rgba(255,255,255,.5);

        padding: 1rem 1.5rem;

        border-radius: 20px;

        display:flex;
        justify-content:space-between;
        align-items:center;

        margin-bottom: 1.5rem;

        box-shadow: 0 8px 30px rgba(0,0,0,.05);
    }

    .topbar h6{
        font-size: 1rem;
        font-weight: 700;
    }

    /* CARD */

    .card{
        border:none;
        border-radius: 24px;
        background: rgba(255,255,255,.85);

        backdrop-filter: blur(12px);

        box-shadow: 0 10px 30px rgba(0,0,0,.05);

        overflow:hidden;
    }

    .card-body{
        padding: 1.7rem;
    }

    /* TABLE */

    .table{
        margin-bottom:0;
    }

    .table thead{
        background: var(--primary-soft);
    }

    .table th{
        border:none;
        color: var(--primary-dark);
        font-weight:700;
        padding: 1rem;
    }

    .table td{
        padding: 1rem;
        vertical-align: middle;
        border-color: var(--border);
    }

    .table tr:hover{
        background:#f9fafb;
    }

    /* BUTTON */

    .btn{
        border-radius: 12px;
        padding: .55rem 1rem;
        font-weight:600;
        border:none;
    }

    .btn-primary{
        background: linear-gradient(135deg,#22c55e,#16a34a);
    }

    .btn-primary:hover{
        background: linear-gradient(135deg,#16a34a,#15803d);
    }

    .btn-success{
        background: linear-gradient(135deg,#10b981,#059669);
    }

    /* BADGE */

    .badge{
        padding: .5rem .8rem;
        border-radius: 999px;
        font-weight:600;
    }

    .bg-primary{
        background:#dcfce7 !important;
        color:#166534 !important;
    }

    .bg-success{
        background:#bbf7d0 !important;
        color:#166534 !important;
    }

    .bg-warning{
        background:#fef9c3 !important;
        color:#854d0e !important;
    }

    /* ALERT */

    .alert{
        border:none;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0,0,0,.05);
    }

    /* SCROLLBAR */

    ::-webkit-scrollbar{
        width:8px;
    }

    ::-webkit-scrollbar-thumb{
        background:#22c55e;
        border-radius:999px;
    }

    /* RESPONSIVE */

    @media(max-width: 768px){

        .sidebar{
            width:100%;
            min-height:auto;
            position:relative;
        }

        .main{
            margin-left:0;
            padding:1rem;
        }

        .topbar{
            flex-direction:column;
            gap:10px;
            align-items:flex-start;
        }
    }
</style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="brand"><i class="bi bi-journal-check"></i> Tryout Online</div>
    <nav class="nav flex-column mt-2 flex-grow-1">
        @if(auth()->user()?->isGuru())
            <a class="nav-link @active('guru.dashboard')" href="{{ route('guru.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link @active('guru.ujian.*')" href="{{ route('guru.ujian.index') }}"><i class="bi bi-clipboard2-check"></i> Ujian</a>
        @else
            <a class="nav-link @active('siswa.dashboard')" href="{{ route('siswa.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link @active('siswa.ujian.*')" href="{{ route('siswa.ujian.index') }}"><i class="bi bi-pencil-square"></i> Daftar Ujian</a>
        @endif
    </nav>
    <div class="p-3" style="border-top:1px solid rgba(255,255,255,.12)">
        <div class="small mb-2 opacity-75">{{ auth()->user()?->name }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-light w-100"><i class="bi bi-box-arrow-left"></i> Keluar</button>
        </form>
    </div>
</div>

<main class="main">
    <div class="topbar">
        <h6 class="mb-0 fw-semibold">@yield('page_title', 'Dashboard')</h6>
        <span class="badge bg-primary">{{ ucfirst(auth()->user()?->role) }}</span>
    </div>

    @foreach(['success','error','info','warning'] as $type)
        @if(session($type))
            <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show" role="alert">
                {{ session($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
