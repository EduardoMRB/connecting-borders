<?php
if ($_GET['randomId'] != "c75HnCCmGKf4kztP5a1LyxKQMgElUKxB3Sd5IYjWDeUUDnRhQ4JX_e5tMcI9EqmZ") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
