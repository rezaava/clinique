@extends('auth.layout.master')

@section('title', 'ثبت نام')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-8 col-lg-6">
        <div class="auth-card">
            <div class="logo">
                <i class="fas fa-user-plus" style="font-size: 50px; color: #667eea;"></i>
                <h2>کلینیک زیبایی</h2>
                <p>ایجاد حساب کاربری جدید</p>
            </div>

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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">
                            <i class="fas fa-user me-1"></i> نام
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name') }}" 
                                   placeholder="علی" required>
                        </div>
                        @error('first_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">
                            <i class="fas fa-user me-1"></i> نام خانوادگی
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                   placeholder="محمدی" required>
                        </div>
                        @error('last_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

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
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i> ایمیل (اختیاری)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="example@gmail.com">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="national_code" class="form-label">
                        <i class="fas fa-id-card me-1"></i> کد ملی (اختیاری)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input type="text" class="form-control @error('national_code') is-invalid @enderror" 
                               id="national_code" name="national_code" value="{{ old('national_code') }}" 
                               placeholder="1234567890" maxlength="10">
                    </div>
                    @error('national_code')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">
                            <i class="fas fa-venus-mars me-1"></i> جنسیت
                        </label>
                        <select class="form-control @error('gender') is-invalid @enderror" 
                                id="gender" name="gender">
                            <option value="">انتخاب کنید</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>آقا</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>خانم</option>
                        </select>
                        @error('gender')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label">
                            <i class="fas fa-calendar me-1"></i> تاریخ تولد
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                        </div>
                        @error('birth_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
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
                    <small class="text-muted">حداقل ۸ کاراکتر</small>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-check-circle me-1"></i> تکرار رمز عبور
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="******" required>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-user-plus me-2"></i> ثبت نام
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted">
                    قبلاً ثبت نام کرده‌اید؟
                    <a href="{{ route('login') }}" class="auth-link">ورود به سیستم</a>
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