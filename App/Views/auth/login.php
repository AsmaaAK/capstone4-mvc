<h1 style="text-align:center; margin-bottom:20px; color:#007bff;">تسجيل الدخول</h1>

<form method="POST" action="/volunteer-managment/public/auth/login" style="display:grid; gap:15px; direction: rtl; max-width:400px; margin:auto;">

    <?php if (!empty($_SESSION['error'])): ?>
        <div style="color:red; text-align:center; margin-bottom:10px;">
            <?= $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <label style="direction: rtl; font-weight:bold;">
        البريد الإلكتروني
        <input type="email" name="email" required
            style="width:100%; direction: rtl; padding:10px; border:1px solid #ddd; border-radius:8px; margin-top:5px;">
    </label>

    <label style="direction: rtl; font-weight:bold;">
        كلمة المرور
        <input type="password" name="password" required
            style="width:100%; direction: rtl; padding:10px; border:1px solid #ddd; border-radius:8px; margin-top:5px;">
    </label>
     <div>
        <label for="role" style="direction: rtl; font-weight:bold;">الدور</label>
        <input type="radio" name="role" id="role_admin" name="admin">
        <label for="role_admin">مدير</label>
        <input type="radio" name="role" id="role_volunteer" name="volunteer">
        <label for="role_volunteer">متطوع</label>

     </div>

    <button type="submit"
        style="padding:12px; background:#007bff; color:white; border:none; border-radius:8px; cursor:pointer; font-size:16px;">
        دخول
    </button>

    <a href="/volunteer-managment/public/auth/register"
        style="text-align:center; display:block; padding:12px; background:#28a745; color:white; border-radius:8px; cursor:pointer; text-decoration:none; font-size:16px; margin-top:5px;">
        تسجيل مستخدم جديد
    </a>
</form>