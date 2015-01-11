<?php
 // Copyright by C-Art Webdesign'2001 (c-art@web.de)
 // Made for Project Erbes (www.weingut-erbes.de)
 // varrequires:

 $ver="1.0-".date("n.j", getlastmod());

 $connr=10;

 $cfg_libarypath = "../_libary";
 include("php/inc.config.php");

 if (!isset($cook_id_sv)) {
  setcookie("cook_id_sv", time(),time()*2,"/");
  statistic($cfg_sitename, "visits", $cook_id_sv, "visit", $connr);
 }
 else statistic($cfg_sitename, "views", $cook_id_sv, "visit", $connr);

  header("Location: http://sv.c-art-web.de/php/site.php");

 ?>