@extends('auth.layout.master')

@section('title', 'ورود به سیستم')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6 col-lg-4">
        <div class="auth-card">
            <div class="logo">
                <i class="fas fa-clinic-medical" style="font-size: 60px; color: #667eea;"></i>
                <h2>کلینیک زیبایی</h2>
                <p>ورود به حساب کاربری</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-1"></i> شماره تلفن
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" 
                               placeholder="09123456789" required>
                    </div>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i> رمز عبور
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="******" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i> ورود
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted">
                    حساب کاربری ندارید؟
                    <a href="{{ route('register') }}" class="auth-link">ثبت نام</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        let password = document.getElementById('password');
        let icon = this.querySelector('i');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection