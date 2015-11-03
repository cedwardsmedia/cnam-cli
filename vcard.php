<?php
   session_start();
   header("Content-Type: text/vcard; charset=utf-8");
   header('Content-Disposition: attachment; filename="' . $_SESSION['lastname'] . '.vcf');

   // Check php.ini for timezone. If it's not set, default to UTC

   $timezone = ini_get('date.timezone');
   if (!$timezone) {
   date_default_timezone_set("UTC");
   };
?>
BEGIN:VCARD
VERSION:3.0
PRODID:-//Corey Edwards//CNAM//EN
N:<?php print_r($_SESSION['lastname']); ?>;<?php print_r($_SESSION['firstname']); ?>;;<?php if ($_SESSION['gender'] == "M") {echo "Mr.";} else {echo "Ms.";}; echo ";\n";?>
FN:<?php print_r($_SESSION["firstname"]); ?> <?php print_r($_SESSION["lastname"]); ?>

<?php if ($_SESSION['image']) { ?>
PHOTO;TYPE=JPEG:http:<?php echo $_SESSION['image'];
}; ?>

TEL;TYPE=<?php if ($_SESSION['linetype'] == "mobile") { echo "CELL"; } else { echo "HOME";}; ?>,type=VOICE;type=pref:+1<?php echo $_SESSION['phone']; ?>

ADR;type=HOME:;;;<?php echo $_SESSION['city']; ?>;<?php echo $_SESSION['state']; ?>;<?php echo $_SESSION['zip']; ?>;United States
REV:<?php echo date('Y-m-d') . "T" . date('H:i:s'); ?>

END:VCARD
