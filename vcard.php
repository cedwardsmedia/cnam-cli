<?php
   session_start();
   header("Content-Type: text/vcard");
   header('Content-Disposition: attachment; filename="' . $_SESSION['lastname'] . '.vcf');
?>
BEGIN:VCARD
VERSION:3.0
PRODID:-//Corey Edwards//CNAM//EN
END:VCARD
