<?php
session_start();

// التحقق مما إذا كان المستخدم مسجل كـ مدير (Admin)
// قم بتغيير اسم المتغير 'is_admin' حسب النظام المعتمد لديك في تسجيل الدخول
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // إذا حاول شخص غريب الدخول، يتم طرده فوراً إلى صفحة تسجيل الدخول
    header("Location: login.php");
    exit();
}
?>
<?php
// 1. حماية الصفحة (تأكد من تفعيل السطور السابقة هنا)
session_start();
if (!isset($_SESSION['is_admin'])) { header("Location: login.php"); exit(); }

// 2. الاتصال بقاعدة البيانات
include('db_connect.php'); 

// 3. جلب جميع الإعلانات من الأحدث للأقدم
$query = "SELECT * FROM ads ORDER BY id DESC";
$result = mysqli_query($db_connect, $query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير وإدارة الإعلانات - خاص بالمدير</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; padding: 30px; }
        .table-container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; text-align: center; }
        th, td { padding: 12px; border: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; color: white; }
        .bg-success { background-color: #28a745; }
        .bg-secondary { background-color: #6c757d; }
        .btn-delete { background: #dc3545; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
    </style>
</head>
<body>

<div class="table-container">
    <h2>لوحة مراقبة وإحصائيات الإعلانات 📊</h2>
    <table>
        <thead>
            <tr>
                <th>المكان</th>
                <th>النوع</th>
                <th>المشاهدات (Views)</th>
                <th>النقرات (Clicks)</th>
                <th>نسبة التفاعل (CTR)</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): 
                // حساب نسبة النقر إلى الظهور (CTR) برمجياً
                $ctr = 0;
                if ($row['views_count'] > 0) {
                    $ctr = round(($row['clicks_count'] / $row['views_count']) * 100, 2);
                }
            ?>
            <tr>
                <td><?php echo ($row['ad_position'] == 'in_between') ? 'بين العقارات' : 'أسفل الصفحة'; ?></td>
                <td><?php echo ($row['ad_type'] == 'image') ? 'صورة مخصصة' : 'جوجل أدسنس'; ?></td>
                <td><strong><?php echo $row['views_count']; ?></strong></td>
                <td><strong><?php echo $row['clicks_count']; ?></strong></td>
                <td><?php echo $ctr; ?>%</td>
                <td>
                    <span class="badge <?php echo ($row['is_active'] == 1) ? 'bg-success' : 'bg-secondary'; ?>">
                        <?php echo ($row['is_active'] == 1) ? 'نشط' : 'متوقف'; ?>
                    </span>
                </td>
                <td>
                    <!-- رابط لحذف الإعلان يمرر الرقم المعرف الخاص به -->
                    <a href="delete-ad.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا الإعلان؟')">حذف</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
