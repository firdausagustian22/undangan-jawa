<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Pawiwahan Ageng Adat Jawa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --c-dark-bg: #1B0E0A;
            --c-card: #2F1B14;
            --c-gold: #C6A15B;
            --c-gold-light: #EEDAA2;
            --c-ivory: #F8F1E5;
            --c-beige: #E8D8BD;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--c-dark-bg);
            color: var(--c-ivory);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: 
                radial-gradient(circle at 50% 30%, rgba(198, 161, 91, 0.15) 0%, transparent 60%),
                url("{{ asset('assets/images/ornaments/batik-pattern.svg') }}");
            background-size: cover, 140px;
            padding: 20px;
        }
        .login-card {
            background: rgba(47, 27, 20, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(198, 161, 91, 0.45);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
            text-align: center;
        }
        .form-input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            background: rgba(15, 8, 5, 0.7);
            border: 1px solid rgba(198, 161, 91, 0.3);
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            border-color: var(--c-gold-light);
            box-shadow: 0 0 0 2px rgba(198,161,91,0.25);
        }
        .input-group {
            position: relative;
            margin-bottom: 1.25rem;
            text-align: left;
        }
        .input-group i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--c-gold);
            font-size: 1rem;
        }
        .btn-gold {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #E5C378 0%, #C6A15B 100%);
            color: #2F1B14;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 10px;
            border: 1px solid #FFF1D0;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #FFF1D0 0%, #D4AF37 100%);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <img src="{{ asset('assets/images/ornaments/gunungan.svg') }}" alt="Gunungan" style="width: 80px; height: auto; margin-bottom: 1rem; filter: drop-shadow(0 4px 10px rgba(198,161,91,0.4));">
        
        <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 3px; color: var(--c-gold-light); margin-bottom: 0.25rem;">
            Pawiwahan Ageng
        </p>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.6rem; color: #FFF1D0; margin-bottom: 0.5rem; font-weight: 700;">
            Masuk Kanjeng Panitiya
        </h2>
        <p style="font-size: 0.85rem; color: var(--c-beige); margin-bottom: 2rem;">
            Akses Panel Admin Pengelolaan Undangan Digital
        </p>

        @if(session('info'))
            <div style="background: rgba(99, 179, 237, 0.2); border: 1px solid rgba(99, 179, 237, 0.4); color: #BEE3F8; padding: 10px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.25rem;">
                {{ session('info') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(245, 101, 101, 0.2); border: 1px solid rgba(245, 101, 101, 0.4); color: #FEB2B2; padding: 10px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.25rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" required value="{{ old('email', 'admin@wedding.com') }}" class="form-input" placeholder="Alamat Email Panitiya">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" required value="password123" class="form-input" placeholder="Kata Sandi">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.85rem;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--c-beige);">
                    <input type="checkbox" name="remember" checked style="accent-color: var(--c-gold);">
                    Ingat Sesi Saya
                </label>
            </div>

            <button type="submit" class="btn-gold">
                <i class="fa-solid fa-right-to-bracket" style="margin-right: 6px;"></i> Masuk Sistem
            </button>
        </form>

        <div style="margin-top: 1.75rem; padding-top: 1rem; border-top: 1px solid rgba(198,161,91,0.2); font-size: 0.75rem; color: rgba(248, 241, 229, 0.6);">
            Default Demo: <strong>admin@wedding.com</strong> | Sandi: <strong>password123</strong>
        </div>
    </div>

</body>
</html>
