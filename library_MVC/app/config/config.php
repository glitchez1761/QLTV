<?php
if (!defined('BASE_URL')) {
    $scriptDirectory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    define('BASE_URL', rtrim($scriptDirectory, '/'));
}
define('APP_NAME', 'Hệ Thống Quản Lý Thư Viện');

// Hằng số tính phí & hạn mức
define('OVERDUE_FINE_PER_DAY', 2000.0);   // Phạt 2.000đ/ngày/cuốn
define('BOOK_PROCESSING_FEE', 30000.0);   // Phí xử lý tài liệu khi hỏng/mất: 30.000đ
define('CARD_FEE_ADULT', 40000.0);        // Phí thường niên và phát hành thẻ
define('CARD_RENEWAL_FEE', 20000.0);      // 20k gia hạn/năm
define('MAX_BORROW_DAYS', 30);            // Mượn tối đa 30 ngày/lần

date_default_timezone_set('Asia/Ho_Chi_Minh');