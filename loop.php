 <?php 
$counter = 0; // تعريف العداد قبل الحلقة

foreach ($properties as $property) {
    // 1. كود عرض كارت العقار الخاص بك هنا
    echo "<div class='property-card'>" . $property['name'] . "</div>";
    
    $counter++; // زيادة العداد بعد عرض كل عقار

    // 2. شرط عرض الإعلان (مثال: يظهر بعد العقار الثالث والسادس وهكذا)
    if ($counter % 3 == 0) {
        echo "<div class='in-feed-ad'>";
        // ضع هنا كود الإعلان الخاص بك (جوجل أدسنس أو صورة برابط)
        echo "<img src='path/to/sponsor-banner.jpg' alt='إعلان مميز'>";
        echo "</div>";
    }
}
?>
<?php
// 1. الاستعلام من قاعدة البيانات عن إعلان أسفل الصفحة النشط
$query = "SELECT * FROM ads WHERE ad_position = 'footer' AND is_active = 1 LIMIT 1";
$result = mysqli_query($db_connect, $query);
$ad = mysqli_fetch_assoc($result);

// 2. التحقق من وجود إعلان وعرضه بناءً على نوعه
if ($ad) {
    echo "<div class='bottom-page-ad'>";
    
    if ($ad['ad_type'] == 'image') {
        // إذا كان إعلان مباشر (صورة ورابط)
        echo "<a href='" . $ad['target_link'] . "' target='_blank'>";
        echo "<img src='" . $ad['image_url'] . "' alt='إعلان'>";
        echo "</a>";
    } elseif ($ad['ad_type'] == 'code') {
        // إذا كان كود شبكة إعلانية كجوجل أدسنس
        echo $ad['embed_code'];
    }
    
    echo "</div>";
}
?>
<?php
// 1. الاستعلام من قاعدة البيانات عن إعلان أسفل الصفحة النشط
$query = "SELECT * FROM ads WHERE ad_position = 'footer' AND is_active = 1 LIMIT 1";
$result = mysqli_query($db_connect, $query);
$ad = mysqli_fetch_assoc($result);

// 2. التحقق من وجود إعلان وعرضه بناءً على نوعه
if ($ad) {
    echo "<div class='bottom-page-ad'>";
    
    if ($ad['ad_type'] == 'image') {
        // إذا كان إعلان مباشر (صورة ورابط)
        echo "<a href='" . $ad['target_link'] . "' target='_blank'>";
        echo "<img src='" . $ad['image_url'] . "' alt='إعلان'>";
        echo "</a>";
    } elseif ($ad['ad_type'] == 'code') {
        // إذا كان كود شبكة إعلانية كجوجل أدسنس
        echo $ad['embed_code'];
    }
    
    echo "</div>";
}
?>
<?php
// جلب الإعلان النشط
$query = "SELECT * FROM ads WHERE ad_position = 'footer' AND is_active = 1 LIMIT 1";
$result = mysqli_query($db_connect, $query);
$ad = mysqli_fetch_assoc($result);

if ($ad) {
    // تحديث عداد المشاهدات فوراً في قاعدة البيانات (+1)
    $ad_id = $ad['id'];
    mysqli_query($db_connect, "UPDATE ads SET views_count = views_count + 1 WHERE id = $ad_id");

    // عرض الإعلان للمستخدم
    echo "<div class='bottom-page-ad'>";
    if ($ad['ad_type'] == 'image') {
        // نغير الرابط ليوجه إلى ملف وسيط لـ احتساب النقرة أولاً (سنتطرق له في الخطوة التالية)
        echo "<a href='click.php?id=" . $ad_id . "' target='_blank'>";
        echo "<img src='" . $ad['image_url'] . "' alt='إعلان'>";
        echo "</a>";
    } elseif ($ad['ad_type'] == 'code') {
        echo $ad['embed_code']; // إعلانات أدسنس تحسب المشاهدات والنقرات تلقائياً في حسابك لديهم
    }
    echo "</div>";
}
?>
