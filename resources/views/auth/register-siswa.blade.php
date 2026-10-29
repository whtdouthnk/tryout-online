<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi — Tryout Online</title>

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

        .register-card{
            border:none;
            border-radius:28px;

            background: rgba(255,255,255,.92);

            backdrop-filter: blur(10px);

            box-shadow: 0 15px 40px rgba(0,0,0,.15);

            overflow:hidden;
        }

        .register-left{
            background: linear-gradient(180deg,#166534,#16a34a);

            color:white;

            padding:3rem;

            display:flex;
            flex-direction:column;
            justify-content:center;
            height:100%;
        }

        .register-right{
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

        .btn-register{
            background: linear-gradient(135deg,#22c55e,#16a34a);
            border:none;

            border-radius:14px;

            padding:.9rem;

            font-weight:600;
        }

        .btn-register:hover{
            background: linear-gradient(135deg,#16a34a,#15803d);
        }

        .text-muted-custom{
            color:#d1fae5;
        }

        @media(max-width:768px){

            .register-left{
                display:none;
            }

            .register-right{
                padding:2rem;
            }

        }

        /* Password toggle style */
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            z-index: 10;
        }
        
        .password-toggle:hover {
            color: #16a34a;
        }
        
        .input-group-text {
            border-radius: 14px 0 0 14px;
        }
        
        .form-control.rounded-end-4 {
            border-radius: 0 14px 14px 0;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card register-card">

                <div class="row g-0">

                    {{-- LEFT SIDE --}}

                    <div class="col-md-5">

                        <div class="register-left">

                            <div class="brand-icon">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>

                            <h2 class="fw-bold mb-3">
                                Daftar Akun
                            </h2>

                            <p class="text-muted-custom mb-4">
                                Bergabunglah sebagai siswa dan ikuti ujian online.
                            </p>

                            <div class="d-flex flex-column gap-3">

                                <div>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Registrasi Gratis
                                </div>

                                <div>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Ikuti Tryout Kapan Saja
                                </div>

                                <div>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Lihat Hasil Langsung
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT SIDE --}}

                    <div class="col-md-7">

                        <div class="register-right">

                            <div class="mb-4">

                                <h3 class="fw-bold text-success mb-2">
                                    Daftar Sekarang 🎓
                                </h3>

                                <p class="text-muted">
                                    Isi data diri kamu dengan lengkap untuk mendaftar.
                                </p>

                            </div>

                            @if($errors->any())

                                <div class="alert alert-danger rounded-4 border-0">

                                    @foreach($errors->all() as $error)
                                        <div><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</div>
                                    @endforeach

                                </div>

                            @endif

                            @if(session('error'))

                                <div class="alert alert-danger rounded-4 border-0">

                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    {{ session('error') }}

                                </div>

                            @endif

                            <form method="POST" action="{{ route('register.post') }}">

                                @csrf

                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Nama Lengkap
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                            <i class="bi bi-person"></i>
                                        </span>

                                        <input type="text"
                                               name="name"
                                               value="{{ old('name') }}"
                                               class="form-control border-start-0 rounded-end-4"
                                               placeholder="Masukkan nama lengkap"
                                               required>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            NIS
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                                <i class="bi bi-credit-card"></i>
                                            </span>

                                            <input type="text"
                                                   name="nis"
                                                   value="{{ old('nis') }}"
                                                   class="form-control border-start-0 rounded-end-4"
                                                   placeholder="Nomor Induk Siswa"
                                                   required>

                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">
                                            Kelas
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                                <i class="bi bi-building"></i>
                                            </span>

                                            <input type="text"
                                                   name="kelas"
                                                   value="{{ old('kelas') }}"
                                                   class="form-control border-start-0 rounded-end-4"
                                                   placeholder="Contoh: XII RPL 1"
                                                   required>

                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">

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

                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Password
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                            <i class="bi bi-lock"></i>
                                        </span>

                                        <input type="password"
                                               name="password"
                                               id="password"
                                               class="form-control border-start-0 rounded-end-4"
                                               placeholder="Minimal 6 karakter"
                                               required>

                                        <span class="password-toggle" onclick="togglePassword('password', 'eyeIcon1')">
                                            <i id="eyeIcon1" class="bi bi-eye-slash"></i>
                                        </span>

                                    </div>

                                </div>

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        Konfirmasi Password
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white border-end-0 rounded-start-4">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>

                                        <input type="password"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               class="form-control border-start-0 rounded-end-4"
                                               placeholder="Ulangi password Anda"
                                               required>

                                        <span class="password-toggle" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                                            <i id="eyeIcon2" class="bi bi-eye-slash"></i>
                                        </span>

                                    </div>

                                </div>

                                <button type="submit"
                                        class="btn btn-register text-white w-100">

                                    <i class="bi bi-person-plus-fill"></i>
                                    Daftar Sekarang

                                </button>

                                <div class="text-center mt-4">
                                    <p class="mb-0">Sudah punya akun? 
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-success">
                                            Login di sini
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

<script>

    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }

</script>

</body>
</html>