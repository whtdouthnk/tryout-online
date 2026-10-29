<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Tryout Online</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>

        body{
            min-height:100vh;

            background:
                linear-gradient(135deg, rgba(34,197,94,.95), rgba(22,163,74,.95)),
                url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200&auto=format&fit=crop');

            background-size:cover;
            background-position:center;

            display:flex;
            align-items:center;
            justify-content:center;

            font-family:'Segoe UI', sans-serif;
        }

        .login-card{
            border:none;
            border-radius:28px;

            background: rgba(255,255,255,.92);

            backdrop-filter: blur(10px);

            box-shadow: 0 15px 40px rgba(0,0,0,.15);

            overflow:hidden;
        }

        .login-left{
            background: linear-gradient(180deg,#166534,#16a34a);

            color:white;

            padding:3rem;

            display:flex;
            flex-direction:column;
            justify-content:center;
            height:100%;
        }

        .login-right{
            padding:3rem;
        }

        .brand-icon{
            width:80px;
            height:80px;

            border-radius:20px;

            background: rgba(255,255,255,.15);

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:2rem;

            margin-bottom:1.5rem;
        }

        .form-control{
            border-radius:14px;
            padding:.85rem 1rem;
            border:1px solid #d1d5db;
        }

        .form-control:focus{
            border-color:#22c55e;
            box-shadow: 0 0 0 .2rem rgba(34,197,94,.15);
        }

        .btn-login{
            background: linear-gradient(135deg,#22c55e,#16a34a);
            border:none;

            border-radius:14px;

            padding:.9rem;

            font-weight:600;
        }

        .btn-login:hover{
            background: linear-gradient(135deg,#16a34a,#15803d);
        }

        .text-muted-custom{
            color:#d1fae5;
        }

        @media(max-width:768px){

            .login-left{
                display:none;
            }

            .login-right{
                padding:2rem;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card login-card">

                <div class="row g-0">

                    {{-- LEFT SIDE --}}

                    <div class="col-md-5">

                        <div class="login-left">

                            <div class="brand-icon">
                                <i class="bi bi-journal-check"></i>
                            </div>

                            <h2 class="fw-bold mb-3">
                                Tryout Online
                            </h2>

                            <p class="text-muted-custom mb-4">
                                Platform ujian online modern untuk siswa dan guru.
                            </p>

                            <div class="d-flex flex-column gap-3">

                                <div>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Ujian Online Real Time
                                </div>

                                <div>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Hasil Otomatis
                                </div>

                                <div>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Dashboard Modern
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT SIDE --}}

                    <div class="col-md-7">

                        <div class="login-right">

                            <div class="mb-4">

                                <h3 class="fw-bold text-success mb-2">
                                    Selamat Datang 👋
                                </h3>

                                <p class="text-muted">
                                    Masuk ke akun kamu untuk melanjutkan.
                                </p>

                            </div>

                            @if($errors->any())

                                <div class="alert alert-danger rounded-4 border-0">

                                    {{ $errors->first() }}

                                </div>

                            @endif

                            <form method="POST" action="{{ route('login.post') }}">

                                @csrf

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Email
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                            <i class="bi bi-envelope"></i>
                                        </span>

                                        <input type="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               class="form-control border-start-0 rounded-end-4"
                                               placeholder="email@sekolah.sch.id"
                                               required>

                                    </div>

                                </div>

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Password
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                            <i class="bi bi-lock"></i>
                                        </span>

                                        <input type="password"
                                               name="password"
                                               class="form-control border-start-0 rounded-end-4"
                                               placeholder="••••••••"
                                               required>

                                    </div>

                                </div>

                               

                                <button type="submit"
                                        class="btn btn-login text-white w-100">

                                    <i class="bi bi-box-arrow-in-right"></i>
                                    Masuk Sekarang

                                </button>
                                <div class="text-center mt-4">
                                    <p class="mb-0">Belum punya akun? 
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                            Daftar sebagai Siswa
                                        </a>
                                    </p>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>