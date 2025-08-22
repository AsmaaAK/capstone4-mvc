<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Core\Database;
use App\Core\App;

class AuthController extends Controller
{
    public function showLoginForm(): void
    {
        // $this->render('auth/login', ['title' => 'تسجيل الدخول', 'error' => $error]);
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';

        $user = User::findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_role'] = $user->role;
            if($user->role === 'admin'){
            $this->redirect('/volunteer-managment/public/admin/dashboard');
            }elseif($user->role === 'volunteer'){
            $this->redirect('/volunteer-managment/public/volunteers/home');

            }else{
            $_SESSION['error'] = "المستخدم غير معرف";
            $this->redirect('/volunteer-managment/public/auth/login');
            }
        } else {
            $_SESSION['error'] = "البريد الإلكتروني أو كلمة المرور غير صحيحة";
            $this->redirect('/volunteer-managment/public/auth/login');
        }
    }

    public function showRegisterForm(): void
    {
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
            $roles = $_POST['role'] ? $_POST['role'] : 'volunteer';
            if (!$name || !$email || !$password){
             $_SESSION['error'] = "جميع الحقول مطلوبة";
             header("Location: /register");
             exit;
            }

            $stmt = App::db()->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
            $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password]);

            $this->redirect('/volunteer-managment/public/auth/login');
        } else {
            $this->render('auth/register');
        }
    }

    public function logout(): void
    {
        // session_start();
        $_SESSION = [];
        session_destroy();
        $this->redirect('/volunteer-managment/public/auth/login');
    }
}
