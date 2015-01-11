<?php
   /*   Copyright by C-ART '2001 www.c-art-web.de (c-art@web.de)   */

 //*************** Config File ***********************
  $connr = 10;

 $ver = "&nbsp;&nbsp; v.1.0-".date("n.j", getlastmod());

 if(!isset($cfg_libarypath)) $cfg_libarypath = "../../_libary";
 if(!isset($cfg_tablepath)) $cfg_tablepath = "../../_tables";
 @include("$cfg_libarypath/inc.config.php");

 @include("$cfg_libarypath/inc.mysqlconnect.php");
 @include("$cfg_libarypath/inc.tools.php");

 $cfg_sitename = "25";
 $cfg_mailto = "mail-dem-vorstand@gmx.de";

 $mysql_tbgb = "191_16_gästebuch";
 $mysql_tbcontact = "190_16_kontakt";


?>