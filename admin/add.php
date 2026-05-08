<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city = $_POST['city'];
    $region = $_POST['region'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $features = $_POST['features'];
    $activities = $_POST['activities'];
    $landmarks = $_POST['landmarks'];

    // رفع الصور
    $main_image = '';
    if (!empty($_FILES['main_image']['name'])) {
        $main_image = 'uploads/' . basename($_FILES['main_image']['name']);
        move_uploaded_file($_FILES['main_image']['tmp_name'], '../' . $main_image);
    }

    $gallery1 = '';
    if (!empty($_FILES['gallery1']['name'])) {
        $gallery1 = 'uploads/' . basename($_FILES['gallery1']['name']);
        move_uploaded_file($_FILES['gallery1']['tmp_name'], '../' . $gallery1);
    }

    $gallery2 = '';
    if (!empty($_FILES['gallery2']['name'])) {
        $gallery2 = 'uploads/' . basename($_FILES['gallery2']['name']);
        move_uploaded_file($_FILES['gallery2']['tmp_name'], '../' . $gallery2);
    }

    $gallery3 = '';
    if (!empty($_FILES['gallery3']['name'])) {
        $gallery3 = 'uploads/' . basename($_FILES['gallery3']['name']);
        move_uploaded_file($_FILES['gallery3']['tmp_name'], '../' . $gallery3);
    }

    $sql = "INSERT INTO places (city, region, category, description, features, activities, landmarks, main_image, gallery_image1, gallery_image2, gallery_image3)
            VALUES ('$city', '$region', '$category', '$description', '$features', '$activities', '$landmarks', '$main_image', '$gallery1', '$gallery2', '$gallery3')";

    if ($conn->query($sql)) {
        session_start();
        $_SESSION['success'] = 'تم إضافة المحتوى بنجاح ✅';
        header('Location: dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة محتوى</title>
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
    <h2>إضافة مكان جديد</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>*اسم المكان</label>
        <input type="text" name="city" placeholder="مثال: العلا" required>

        <label>*الصورة الرئيسية للمكان</label>
        <input type="file" name="main_image" accept="image/*" required>

        <label>*الوصف</label>
        <textarea name="description" rows="4" placeholder="اكتب وصفاً للمكان..." required></textarea>

        <label>*النوع</label>
        <select name="region">
            <option value="وسطى">وسطى</option>
            <option value="غربية">غربية</option>
            <option value="شرقية">شرقية</option>
            <option value="جنوبية">جنوبية</option>
            <option value="شمالية">شمالية</option>
        </select>

        <label>*التصنيف</label>
        <select name="category">
            <option value="ديني">ديني</option>
            <option value="سياحي">سياحي</option>
            <option value="تاريخي">تاريخي</option>
            <option value="طبيعي">طبيعي</option>
            <option value="ترفيهي">ترفيهي</option>
        </select>

        <label>*المميزات</label>
        <input type="text" name="features" placeholder="مثال: مواقع أثرية، طبيعة خلابة">

        <label>*الأنشطة</label>
        <input type="text" name="activities" placeholder="مثال: تسلق الجبال، زيارة المعالم">

        <label>*المعالم الأفضل (بينها فاصلة)</label>
        <input type="text" name="landmarks" placeholder="مثال: برج المملكة، قصر الحكم، الدرعية">

        <h3>صور المعرض</h3>

        <label>*صورة المعرض الأول</label>
        <input type="file" name="gallery1" accept="image/*" required>

        <label>صورة المعرض الثانية (اختياري)</label>
        <input type="file" name="gallery2" accept="image/*">

        <label>صورة المعرض الثالثة (اختياري)</label>
        <input type="file" name="gallery3" accept="image/*">

        <button type="submit">إضافة المكان</button>

    </form>
</div>

<script src="../js/main.js"></script>
</body>
</html>