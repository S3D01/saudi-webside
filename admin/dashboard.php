<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$message = '';

// حذف سجل
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM places WHERE id=$id";
    if ($conn->query($sql)) {
        $message = 'تم حذف السجل بنجاح ✅';
    }
}

// جلب كل البيانات
$result = $conn->query("SELECT * FROM places");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">
        <a href="#">لوحة المشرف</a>
    </div>
    <ul class="nav-links">
        <li><a href="../index.php">الصفحة الرئيسية</a></li>
        <li><a href="add.php">إضافة محتوى</a></li>
        <li><a href="logout.php" class="btn-logout">تسجيل الخروج</a></li>
    </ul>
</nav>

<div class="dashboard-container">
    <h2>إدارة المحتوى</h2>
    <p>استخدم هذه الصفحة لإدارة محتوى الموقع من خلال عرض السجلات وإضافة أو تعديل أو حذف المحتوى</p>

    <?php if ($message): ?>
        <div class="success-msg"><?php echo $message; ?></div>
    <?php endif; ?>

    <a href="add.php" class="btn-add">إضافة محتوى جديد</a>

    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>المنطقة</th>
            <th>التصنيف</th>
            <th>الوصف</th>
            <th>الإجراءات</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['city']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo substr($row['description'], 0, 40) . '...'; ?></td>
            <td>
                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn-edit">تعديل</a>
                <a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>)" class="btn-delete">حذف</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<script>
function confirmDelete(id) {
    if (confirm('هل تريد حذف هذا السجل؟')) {
        window.location.href = 'dashboard.php?delete=' + id;
    }
}
</script>

<script src="../js/main.js"></script>
</body>
</html>