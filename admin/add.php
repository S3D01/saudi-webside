<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

function uploadImage($fileKey, $uploadDir) {
    if (empty($_FILES[$fileKey]['name'])) return '';

    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $fileType = mime_content_type($_FILES[$fileKey]['tmp_name']);

    if (!in_array($fileType, $allowed)) return '';

    $ext = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
    $newName = uniqid('img_', true) . '.' . $ext;
    $destination = $uploadDir . $newName;

    if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $destination)) {
        return 'uploads/' . $newName;
    }

    return '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $city        = $_POST['city'];
    $region      = $_POST['region'];
    $category    = $_POST['category'];
    $description = $_POST['description'];
    $features    = $_POST['features'];
    $activities  = $_POST['activities'];
    $landmarks   = $_POST['landmarks'];

    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $main_image = uploadImage('main_image', $uploadDir);
    $gallery1   = uploadImage('gallery1', $uploadDir);
    $gallery2   = uploadImage('gallery2', $uploadDir);
    $gallery3   = uploadImage('gallery3', $uploadDir);

    $stmt = $conn->prepare("INSERT INTO places 
        (city, region, category, description, features, activities, landmarks, main_image, gallery_image1, gallery_image2, gallery_image3)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssss",
        $city, $region, $category, $description,
        $features, $activities, $landmarks,
        $main_image, $gallery1, $gallery2, $gallery3
    );

    if ($stmt->execute()) {
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