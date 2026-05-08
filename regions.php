<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>معرض المناطق</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="regions-container">
    <h2>معرض المناطق</h2>
    <p>ابحث أو صنّف النتائج ثم اضغط على أي منطقة للانتقال إلى صفحة التفاصيل</p>

    <!-- شريط البحث والفلتر -->
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="ابحث عن منطقة أو مدينة...">
        <select id="filterSelect">
            <option value="الكل">كل الأنواع</option>
            <option value="وسطى">وسطى</option>
            <option value="غربية">غربية</option>
            <option value="شرقية">شرقية</option>
            <option value="جنوبية">جنوبية</option>
            <option value="شمالية">شمالية</option>
        </select>
        <span id="countDisplay"></span>
    </div>

    <!-- الكروت -->
    <div class="regions-grid" id="regionsGrid">
        <?php
        $result = $conn->query("SELECT * FROM places");
        while ($row = $result->fetch_assoc()):
        ?>
        <a href="details.php?id=<?php echo $row['id']; ?>" 
           class="region-card" 
           data-region="<?php echo $row['region']; ?>"
           data-city="<?php echo $row['city']; ?>">

            <?php if ($row['main_image']): ?>
                <img src="<?php echo $row['main_image']; ?>" alt="<?php echo $row['city']; ?>">
            <?php else: ?>
                <div class="no-image">🏙️</div>
            <?php endif; ?>

            <div class="region-info">
    <h3><?php echo $row['city']; ?></h3>
    <p><?php echo mb_substr($row['description'], 0, 80, 'UTF-8') . '...'; ?></p>
    <span class="btn-details">عرض التفاصيل ←</span>
</div>
        </a>
        <?php endwhile; ?>
    </div>
</div>

<footer class="footer">
    <p>© اكتشف السعودية — جامعة الملك سعود</p>
</footer>

<script>
const searchInput = document.getElementById('searchInput');
const filterSelect = document.getElementById('filterSelect');
const cards = document.querySelectorAll('.region-card');
const countDisplay = document.getElementById('countDisplay');

function filterCards() {
    const search = searchInput.value.toLowerCase();
    const filter = filterSelect.value;
    let count = 0;

    cards.forEach(card => {
        const city = card.dataset.city.toLowerCase();
        const region = card.dataset.region;

        const matchSearch = city.includes(search);
        const matchFilter = filter === 'الكل' || region === filter;

        if (matchSearch && matchFilter) {
            card.style.display = 'block';
            count++;
        } else {
            card.style.display = 'none';
        }
    });

    countDisplay.textContent = 'عدد النتائج: ' + count;
}

searchInput.addEventListener('input', filterCards);
filterSelect.addEventListener('change', filterCards);

// عرض العدد أول مرة
filterCards();
</script>

<script src="js/main.js"></script>
</body>
</html>