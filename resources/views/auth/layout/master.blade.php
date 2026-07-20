<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'کلینیک زیبایی')</title>
    
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')}}">
    <script src="{{ asset('bootstrap/bootstrap.min.js') }}"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'IRANSans', Tahoma, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .auth-card {
            max-width: 450px;
            margin: 50px auto;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            background: white;
            padding: 30px;
        }
        .auth-card .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .auth-card .logo h2 {
            color: #667eea;
            font-weight: bold;
        }
        .auth-card .logo p {
            color: #999;
            font-size: 14px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .alert {
            border-radius: 10px;
        }
        .auth-link {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        .auth-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        .form-label {
            font-weight: bold;
            color: #555;
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            background: #f8f9fa;
        }
        .auth-card .form-control {
            border-radius: 0 10px 10px 0;
        }
        .auth-card .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }
        .auth-card .input-group .input-group-text {
            border-radius: 10px 0 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>