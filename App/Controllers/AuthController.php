<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/users');
        }
        $this->render('auth/login', ['title' => 'Login']);
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->render('auth/login', ['error' => 'الرجاء تعبئة كل الحقول.']);
            return;
        }

        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user->password)) {
            $this->render('auth/login', ['error' => 'بيانات دخول غير صحيحة.']);
            return;
        }

        Auth::login($user->id);
        $this->redirect('/users');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
