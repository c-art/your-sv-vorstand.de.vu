<?php

  /* Die Formulare müssen so heißen damit sie eingetragen werden:
         name
         email
         url
         text
  */

  include_once("inc.config.php");

  //jetzt werden die daten gespeichert:
   $query = "INSERT INTO $mysql_tbgb (name,email,url,text,no) VALUES ('$name','$email','$url','$text','".time()."')";
   $res = mysql_query($query, $mysql_nr[$connr]) or myerror($query, __LINE__, __FILE__, mysql_error($mysql_nr[$connr]));

  //damit du über einen neuen eintrag bescheid weist:
   if ($cfg_mailto!="") @mail($cfg_mailto, "Neuer Gästebuch Eintrag", "Sie haben einen neuen Gästebucheintrag von $name erhalten","FROM: mail-dem-vorstand@gmx.de");
  // alles wieder schliessen
  mysql_close();

  // ..und nächste datei laden:
  header("location: site.php?type=guest");
  //feritg!
  exit;

?>