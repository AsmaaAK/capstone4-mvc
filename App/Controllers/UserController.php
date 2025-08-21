<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/volunteer-managment/public/auth/login');
            return;
        }

        $users = User::all();

        $this->render('users/index', [
            'title' => 'قائمة المستخدمين',
            'users' => $users
        ]);
    }
}
