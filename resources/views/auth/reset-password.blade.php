<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Kafetani</title>
    <meta name="description" content="Buat password baru untuk akun Kafetani Anda.">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style-auth.css') }}">
    <style>
        .auth-logo { display: block; text-align: center; margin-bottom: 1.5rem; }
        .auth-logo img { height: 36px; }
        .alert-error {
            background: #fcebea;
            color: #c0392b;
            border: 1px solid #f5d1cf;
            padding: .75rem 1rem;
            font-size: .85rem;
            margin-bottom: 1rem;
            text-align: left;
            border-left: 3px solid #c0392b;
        }
        .back-link { display: block; text-align: center; margin-top: 1rem; font-size: .8rem; color: #A9967E; }
        .password-strength {
            height: 3px;
            border-radius: 3px;
            margin-top: -16px;
            margin-bottom: 16px;
            transition: all .3s;
            background: #D9CEBC;
        }
    </style>
</head>
<body>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        {{-- Token dan email hidden --}}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <a href="{{ url('/') }}" class="auth-logo">
            <img src="{{ asset('logo_v3.svg') }}" alt="Kafetani">
        </a>

        <h2>Reset Password</h2>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <label>Email:</label>
        <input type="text" value="{{ $email }}" disabled style="opacity:.6; cursor:not-allowed;">

        <label for="password">Password Baru:</label>
        <div class="password-row">
            <input type="password" id="password" name="password"
                   required
                   placeholder="Minimal 6 karakter"
                   autocomplete="new-password"
                   oninput="checkStrength(this.value)">
            <button type="button" onclick="togglePass('password', this)" title="Tampilkan">👁</button>
        </div>
        <div class="password-strength" id="pw-strength"></div>

        <label for="konfirmasi_password">Konfirmasi Password Baru:</label>
        <div class="password-row">
            <input type="password" id="konfirmasi_password" name="konfirmasi_password"
                   required
                   placeholder="Ulangi password baru"
                   autocomplete="new-password">
            <button type="button" onclick="togglePass('konfirmasi_password', this)" title="Tampilkan">👁</button>
        </div>

        <input type="submit" value="Simpan Password Baru">

        <a href="{{ url('/') }}" class="back-link">← Kembali ke Beranda</a>
    </form>

    <script>
        function togglePass(id, btn) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁';
            }
        }

        function checkStrength(val) {
            const bar = document.getElementById('pw-strength');
            if (!bar) return;
            if (val.length === 0) { bar.style.width = '0'; bar.style.background = '#D9CEBC'; return; }
            if (val.length < 6)   { bar.style.width = '30%'; bar.style.background = '#e74c3c'; return; }
            if (val.length < 10)  { bar.style.width = '60%'; bar.style.background = '#f39c12'; return; }
            bar.style.width = '100%';
            bar.style.background = '#27ae60';
        }
    </script>
</body>
</html>
