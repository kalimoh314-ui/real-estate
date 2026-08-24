<?php
// الاتصال بقاعدة البيانات
include('db_connect.php'); 

if (isset($_GET['id'])) {
    $ad_id = intval($_GET['id']);

    // 1. جلب رابط المعلن الأصلي
    $query = "SELECT target_link FROM ads WHERE id = $ad_id LIMIT 1";
    $result = mysqli_query($db_connect, $query);
    $ad = mysqli_fetch_assoc($result);

    if ($ad) {
        // 2. تحديث عداد النقرات (+1)
        mysqli_query($db_connect, "UPDATE ads SET clicks_count = clicks_count + 1 WHERE id = $ad_id");

        // 3. تحويل الزائر فوراً وبشكل آمن إلى موقع المعلن
        header("Location: " . $ad['target_link']);
        exit();
    }
}

// في حال وجود خطأ في الرابط يتم تحويله للرئيسية
header("Location: index.php");
exit();
?>
