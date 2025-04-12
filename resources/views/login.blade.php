<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <style>
        body {
            background-image: url('https://scontent.fmnl9-2.fna.fbcdn.net/v/t1.6435-9/135855556_102349538492192_97676168925477488_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=cc71e4&_nc_eui2=AeFKPsokWu49ytK2BMAcNHFNotSZ1BVPJRyi1JnUFU8lHI8GvxDBokWQOXGLaM88MIWZV6ftfqFnKHM4XapkOPsZ&_nc_ohc=699Kle-B-WoQ7kNvgHdQNv7&_nc_zt=23&_nc_ht=scontent.fmnl9-2.fna&_nc_gid=Az1p49EcV-TQ46x2fZPxEV5&oh=00_AYD3EteIL80sj8fzmIfhTI7CeBCgc606N8WYwhfzad-cug&oe=67CA56B5'); /* Set your background image URL here */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 24px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .input-field {
            margin-bottom: 16px;
            padding: 12px 20px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            font-size: 1rem;
            color: #333;
        }

        .input-field:focus {
            outline: none;
            border-color: #4caf50;
        }

        .login-btn {
            background-color: #4caf50;
            color: white;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .login-btn:hover {
            background-color: #388e3c;
        }

        .checkbox-label {
            color: #555;
            font-size: 0.875rem;
        }

        .forgot-password {
            font-size: 0.875rem;
            color: #4caf50;
            text-decoration: none;
            margin-top: 10px;
            display: block;
            text-align: center;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
            font-size: 0.875rem;
        }

        .error-message ul {
            padding-left: 0;
            list-style: none;
        }

        .error-message li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <main>
        <div class="form-container">
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input class="input-field" type="email" name="email" placeholder="Email" required />
                <input class="input-field" type="password" name="password" placeholder="Password" required />
                <button class="login-btn" type="submit">Log In</button>
            </form>
        </div>
    </main>
</body>
</html>
