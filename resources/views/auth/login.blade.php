<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hablame!</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-header {
            background: linear-gradient(135deg, #3a77ff 0%, #6c8eff 100%);
            padding: 40px 30px 30px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo {
            height: 80px;
            width: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .welcome-text {
            color: white;
            margin-bottom: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            margin-top: 5px;
        }

        .login-body {
            padding: 40px 35px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            color: #4a5568;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            color: #3a77ff;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            height: auto;
        }

        .form-control:focus {
            border-color: #3a77ff;
            box-shadow: 0 0 0 3px rgba(58, 119, 255, 0.1);
            transform: translateY(-1px);
        }

        .form-control.is-invalid {
            border-color: #fc8181;
            background-image: none;
        }

        .form-control.is-invalid:focus {
            border-color: #fc8181;
            box-shadow: 0 0 0 3px rgba(252, 129, 129, 0.1);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-control {
            padding-left: 45px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 10;
        }

        .input-icon-password {
            cursor: pointer;
            right: 15px;
            left: auto;
            color: #718096;
        }

        .input-icon-password:hover {
            color: #3a77ff;
        }

        .error-message {
            color: #fc8181;
            font-size: 0.875rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 5px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .form-check {
            margin-bottom: 0;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid #e2e8f0;
            margin-right: 8px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #3a77ff;
            border-color: #3a77ff;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(58, 119, 255, 0.1);
        }

        .form-check-label {
            color: #4a5568;
            font-size: 0.95rem;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: #3a77ff;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #2c5fd4;
            text-decoration: underline;
        }

        .btn-login {
            background: linear-gradient(135deg, #3a77ff 0%, #6c8eff 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(58, 119, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(58, 119, 255, 0.4);
            background: linear-gradient(135deg, #2c5fd4 0%, #5a7cff 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            font-size: 1.2rem;
        }

        .login-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .register-link {
            color: #4a5568;
            font-size: 0.95rem;
        }

        .register-link a {
            color: #3a77ff;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: #2c5fd4;
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 25px;
            padding: 15px 20px;
        }

        .alert-success {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .alert-error {
            background-color: #fed7d7;
            color: #742a2a;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                max-width: 100%;
            }

            .login-header {
                padding: 30px 20px 25px;
            }

            .login-body {
                padding: 30px 25px;
            }

            .logo {
                height: 70px;
            }

            .welcome-text {
                font-size: 1.3rem;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .forgot-link {
                align-self: flex-end;
            }
        }

        @media (max-width: 380px) {
            .login-header {
                padding: 25px 15px 20px;
            }

            .login-body {
                padding: 25px 20px;
            }

            .logo {
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <!-- Cabeçalho com Logo -->
        <div class="login-header">
            <div class="logo-container">
                <img src="{{ asset('img/logo.png') }}" alt="Hablame Logo" class="logo">
            </div>
            <h1 class="welcome-text">Bem-vindo de volta</h1>
            <p class="subtitle">Entre na sua conta para continuar</p>
        </div>

        <!-- Corpo do Formulário -->
        <div class="login-body">
            <!-- Mensagens de Status/Erro -->
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Oops!</strong> Por favor, verifique os campos abaixo.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Campo Email -->
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="bi bi-envelope"></i>
                        Endereço de Email
                    </label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope input-icon"></i>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="exemplo@email.com"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Campo Senha -->
                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="bi bi-lock"></i>
                        Senha
                    </label>
                    <div class="input-with-icon">
                        <i class="bi bi-lock input-icon"></i>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Sua senha"
                            required
                        >
                        <i class="bi bi-eye input-icon input-icon-password" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Lembrar-me e Esqueci a senha -->
                <div class="remember-forgot">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Lembrar-me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            Esqueceu sua senha?
                        </a>
                    @endif
                </div>

                <!-- Botão de Login -->
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Entrar na Conta
                </button>

                <!-- Link para Registro -->
                <div class="login-footer">
                    <p class="register-link">
                        Não tem uma conta?
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Criar conta</a>
                        @endif
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alternar visibilidade da senha
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Alterar ícone
                    if (type === 'password') {
                        this.classList.remove('bi-eye-slash');
                        this.classList.add('bi-eye');
                    } else {
                        this.classList.remove('bi-eye');
                        this.classList.add('bi-eye-slash');
                    }
                });
            }

            // Validação em tempo real
            const emailInput = document.getElementById('email');
            const passwordInput2 = document.getElementById('password');

            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            if (emailInput) {
                emailInput.addEventListener('blur', function() {
                    if (this.value && !validateEmail(this.value)) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                emailInput.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                    }
                });
            }

            // Feedback visual no submit
            const loginForm = document.getElementById('loginForm');
            const submitBtn = loginForm.querySelector('.btn-login');

            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    // Adicionar efeito de loading
                    submitBtn.innerHTML = `
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Entrando...
                    `;
                    submitBtn.disabled = true;
                });
            }

            // Foco automático no primeiro campo com erro
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            }
        });
    </script>
</body>
</html>
