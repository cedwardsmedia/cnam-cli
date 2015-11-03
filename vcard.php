<?php
   session_start();
   header("Content-Type: text/vcard");
   header('Content-Disposition: attachment; filename="' . $_SESSION['lastname'] . '.vcf');
?>
BEGIN:VCARD
VERSION:3.0
PRODID:-//Corey Edwards//CNAM//EN
N:<?php print_r($_SESSION['lastname']); ?>;<?php print_r($_SESSION['firstname']); ?>;;<?php if ($_SESSION['gender'] == "M") {echo "Mr.";} else {echo "Ms.";}; echo ";\n";?>
FN:<?php print_r($_SESSION["firstname"]); ?> <?php print_r($_SESSION["lastname"]); ?>

PHOTO;TYPE=JPEG:http:<?php echo $_SESSION['image']; ?>

TEL;TYPE=<?php if ($_SESSION['linetype'] == "mobile") { echo "CELL"; } else { echo "HOME";}; ?>,type=VOICE;type=pref:+1<?php echo $_SESSION['phone']; ?>

ADR;type=HOME:;;;<?php echo $_SESSION['city']; ?>;<?php echo $_SESSION['state']; ?>;<?php echo $_SESSION['zip']; ?>;United States
END:VCARD
