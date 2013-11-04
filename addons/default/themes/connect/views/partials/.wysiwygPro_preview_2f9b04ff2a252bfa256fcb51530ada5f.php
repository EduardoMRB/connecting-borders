<?php
if ($_GET['randomId'] != "upujYiiDm5mtLKKr6bin4zhBssqub0fbRCyKhydLUjQHLZS1JxslaL0fSeOpGmBn") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
