<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$row = $conn->query("SELECT * FROM places WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city = $_POST['city'];
    $region = $_POST['region'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $features = $_POST['features'];
    $activities = $_POST['activities'];
    $landmarks = $_POST['landmarks'];

    $main_image = $row['main_image'];
    if (!empty($_FILES['main_image']['name'])) {
        $main_image = 'uploads/' . basename($_FILES['main_image']['name']);
        move_uploaded_file($_FILES['main_image']['tmp_name'], '../' . $main_image);
    }

    $gallery1 = $row['gallery_image1'];
    if (!empty($_FILES['gallery1']['name'])) {
        $gallery1 = 'uploads/' . basename($_FILES['gallery1']['name']);
        move_uploaded_file($_FILES['gallery1']['tmp_name'], '../' . $gallery1);
    }

    $gallery2 = $row['gallery_image2'];
    if (!empty($_FILES['gallery2']['name'])) {
        $gallery2 = 'uploads/' . basename($_FILES['gallery2']['name']);
        move_uploaded_file($_FILES['gallery2']['tmp_name'], '../' . $gallery2);
    }

    $gallery3 = $row['gallery_image3'];
    if (!empty($_FILES['gallery3']['name'])) {
        $gallery3 = 'uploads/' . basename($_FILES['gallery3']['name']);
        move_uploaded_file($_FILES['gallery3']['tmp_name'], '../' . $gallery3);
    }

    $sql = "UPDATE places SET 
            city='$city', region='$region', category='$category',
            description='$description', features='$features',
            activities='$activities', landmarks='$landmarks',
            main_image='$main_image', gallery_image1='$gallery1',
            gallery_image2='$gallery2', gallery_image3='$gallery3'
            WHERE id=$id";

    if ($conn->query($sql)) {
        $_SESSION['success'] = 'تم تحديث المحتوى بنجاح ✅';
        header('Location: dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل محتوى</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">
        <a href="#">لوحة المشرف</a>
    </div>
    <ul class="nav-links">
        <li><a href="dashboard.php">لوحة التحكم</a></li>
        <li><a href="../index.php">الصفحة الرئيسية</a></li>
        <li><a href="logout.php" class="btn-logout">تسجيل الخروج</a></li>
    </ul>
</nav>

<div class="form-container">
    <h2>تحديث مكان — <?php echo $row['city']; ?></h2>

    <div class="update-layout">
        <div class="update-form">
            <form method="POST" enctype="multipart/form-data">

                <label>اسم المكان</label>
                <input type="text" name="city" value="<?php echo $row['city']; ?>" required>

                <label>تحديث الصورة الرئيسية (اختياري)</label>
                <input type="file" name="main_image" accept="image/*">

                <label>الوصف</label>
                <textarea name="description" rows="4" required><?php echo $row['description']; ?></textarea>

                <label>النوع</label>
                <select name="region">
                    <option value="وسطى" <?php if($row['region']=='وسطى') echo 'selected'; ?>>وسطى</option>
                    <option value="غربية" <?php if($row['region']=='غربية') echo 'selected'; ?>>غربية</option>
                    <option value="شرقية" <?php if($row['region']=='شرقية') echo 'selected'; ?>>شرقية</option>
                    <option value="جنوبية" <?php if($row['region']=='جنوبية') echo 'selected'; ?>>جنوبية</option>
                    <option value="شمالية" <?php if($row['region']=='شمالية') echo 'selected'; ?>>شمالية</option>
                </select>

                <label>التصنيف</label>
                <select name="category">
                    <option value="ديني" <?php if($row['category']=='ديني') echo 'selected'; ?>>ديني</option>
                    <option value="سياحي" <?php if($row['category']=='سياحي') echo 'selected'; ?>>سياحي</option>
                    <option value="تاريخي" <?php if($row['category']=='تاريخي') echo 'selected'; ?>>تاريخي</option>
                    <option value="طبيعي" <?php if($row['category']=='طبيعي') echo 'selected'; ?>>طبيعي</option>
                    <option value="ترفيهي" <?php if($row['category']=='ترفيهي') echo 'selected'; ?>>ترفيهي</option>
                </select>

                <label>المميزات</label>
                <input type="text" name="features" value="<?php echo $row['features']; ?>">

                <label>الأنشطة</label>
                <input type="text" name="activities" value="<?php echo $row['activities']; ?>">

                <label>المعالم الأفضل</label>
                <input type="text" name="landmarks" value="<?php echo $row['landmarks']; ?>">

                <h3>تحديث صور المعرض (اختياري)</h3>
                <label>صورة المعرض الأول</label>
                <input type="file" name="gallery1" accept="image/*">

                <label>صورة المعرض الثانية</label>
                <input type="file" name="gallery2" accept="image/*">

                <label>صورة المعرض الثالثة</label>
                <input type="file" name="gallery3" accept="image/*">

                <button type="submit">حفظ التعديلات</button>

            </form>
        </div>

        <div class="update-preview">
            <h3>الصورة الرئيسية الحالية</h3>
            <?php if ($row['main_image']): ?>
                <img src="../<?php echo $row['main_image']; ?>" alt="صورة رئيسية">
            <?php else: ?>
                <p>لا توجد صورة</p>
            <?php endif; ?>

            <h3>صور المعرض الحالية</h3>
            <?php if ($row['gallery_image1']): ?>
                <img src="../<?php echo $row['gallery_image1']; ?>" alt="صورة 1">
            <?php endif; ?>
            <?php if ($row['gallery_image2']): ?>
                <img src="../<?php echo $row['gallery_image2']; ?>" alt="صورة 2">
            <?php endif; ?>
            <?php if ($row['gallery_image3']): ?>
                <img src="../<?php echo $row['gallery_image3']; ?>" alt="صورة 3">
            <?php endif; ?>
        </div>
    </div>

</div>

<script src="../js/main.js"></script>
</body>
</html>