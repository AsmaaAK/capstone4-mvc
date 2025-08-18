
<?php $title = 'قائمة المستخدمين'; ?>
<h2>قائمة المستخدمين</h2>

<table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>الاسم</th>
      <th>البريد</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= (int)$u['id'] ?></td>
      <td><?= htmlspecialchars($u['name']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
