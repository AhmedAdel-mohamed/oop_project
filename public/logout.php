<?php
session_start();
session_unset();   // تمسح كل البيانات في الجلسة
session_destroy(); // تنهي الجلسة تمامًا

header('Location: login.php');
exit;
