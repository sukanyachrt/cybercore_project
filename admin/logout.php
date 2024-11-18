<?php
session_start();
session_destroy();
header("Location: ./");
?>

<script>
    // ตรวจสอบว่า Session ถูกล็อกเอาท์หรือไม่
    if (<?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>) {
        window.location.replace('./'); // หาก Session ยังคงมีให้กลับไปหน้าหลัก
        
    }
</script>