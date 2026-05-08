<?php
include 'config.php';

$id = $_GET['id'];
$row = $conn->query("SELECT * FROM places WHERE id=$id")->fetch_assoc();

if (!$row) {
    header('Location: regions.php');
    exit();
}

$landmarks = explode('،', $row['landmarks']);
$features = explode('،', $row['features']);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['city']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="details-container">

    <!-- الصورة الرئيسية -->
    <?php if ($row['main_image']): ?>
        <div class="details-hero">
            <img src="<?php echo $row['main_image']; ?>" alt="<?php echo $row['city']; ?>">
        </div>
    <?php endif; ?>

    <!-- العنوان والوصف -->
    <div class="details-content">
        <h1><?php echo $row['city']; ?></h1>
        <p class="details-desc"><?php echo $row['description']; ?></p>

        <!-- معلومات سريعة -->
        <div class="details-info-box">
            <h3>معلومات سريعة</h3>
            <ul>
                <li>📍 المنطقة: <?php echo $row['region']; ?></li>
                <li>🏷️ التصنيف: <?php echo $row['category']; ?></li>
                <?php if ($row['activities']): ?>
                    <li>🎯 الأنشطة: <?php echo $row['activities']; ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- المميزات -->
        <?php if ($row['features']): ?>
        <div class="details-features">
            <h3>المميزات</h3>
            <ul>
                <?php foreach ($features as $f): ?>
                    <li>✨ <?php echo trim($f); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- أبرز المعالم -->
        <?php if ($row['landmarks']): ?>
        <div class="details-landmarks">
            <h3>أبرز المعالم</h3>
            <ul>
                <?php foreach ($landmarks as $l): ?>
                    <li>🏛️ <?php echo trim($l); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- معرض الصور -->
        <?php if ($row['gallery_image1'] || $row['gallery_image2'] || $row['gallery_image3']): ?>
        <div class="details-gallery">
            <h3>معرض الصور</h3>
            <div class="gallery-grid">
                <?php if ($row['gallery_image1']): ?>
                    <img src="<?php echo $row['gallery_image1']; ?>" alt="صورة 1">
                <?php endif; ?>
                <?php if ($row['gallery_image2']): ?>
                    <img src="<?php echo $row['gallery_image2']; ?>" alt="صورة 2">
                <?php endif; ?>
                <?php if ($row['gallery_image3']): ?>
                    <img src="<?php echo $row['gallery_image3']; ?>" alt="صورة 3">
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <a href="regions.php" class="btn-back">← رجوع للمناطق</a>
    </div>
</div>

<footer class="footer">
    <p>© اكتشف السعودية — جامعة الملك سعود</p>
</footer>

<script src="js/main.js"></script>
</body>
</html>