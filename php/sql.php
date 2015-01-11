<?php
   /*   Copyright by C-ART WEBDESIGN '2001 - www.c-art-web.de - (c-art@web.de)   */

   //File requires
   // $url -> weilterleitung
   // $to_alert
   // $to_mail
   // $usehtml  -> no html stripping
   // $tabname
   // $connr
   // $where
   // $usehtml[][]  -> no html stripping at this Field
   //or by SessionVars:
   // $sess_tabname -> Tabellen Namen
   // $sess_where -> Where Query zum anzeigen bestimmter Einträge (ohne Filter)
   // $sess_whereshow -> Where Query zum anzeigen Einträge (mit Filter)
   // $sess_connr -> mySQL Connection Nummer
   // $sess_url -> weilterleitung
   //Mail messeage
   // $to_mail  [emailaddress|self] -> , if to_mail contents self, email is send email adresse in coulum email
   // $mailfrom [emailadrress|self] -> whres mail from, if not set, and email column ist available, entry ist taken
   // $mailmode [email/raw]   -> content
   // $mailfields  [true/false] -> if true, only fields with '_m_' in columnsname are send
   // $mailsubject    [String] -> Mailsubject
   // $mailtextbefore [String] -> Mailt text after entry
   // $mailtextafter  [String] -> Mailt text after entry

 include("inc.config.php");
 include("$cfg_libarypath/class.multiadmin.php");

 $tabname=($tabname) ? $tabname : $sess_tabname;
 $connr=(isset($connr)) ? $connr : $sess_connr;
 $url=  ($url!="")   ? stripslashes($url) : $sess_url;
 $where=(isset($where)) ? $where : $sess_where;
 $krit= (isset($krit))  ? $krit  : $sess_krit;
 eval('$where="'.stripslashes($where)."\";");

 $entry = new multiadmin();
 $entry->tabname=$tabname;
 $entry->connr=$connr;
 $entry->getTabStrukture();

 //datei muss form haben: z.B. inc.prev.gaestebuch.php
 @include("inc.prev.".strip_subline($tabname).".php");

 switch ($mode) {
  case "delete":
   $query ="DELETE FROM $tabname $where";
   $res = mysql_query($query,$mysql_nr[$connr]) or myerror($query,__LINE__,__FILE__,mysql_error($mysql_nr[$connr]));
   break;
  case "status":
   $query="UPDATE $tabname SET ".$entry->columnnames['status']."=$status $where";
   if (!$noinsert[$k]) $res = mysql_query($query,$mysql_nr[$connr]) or myerror($query,__LINE__,__FILE__,mysql_error($mysql_nr[$connr]));
   break;
  case "edit":
  case "new":
  case "update":
  case "preview":
   include("$cfg_libarypath/inc.sql.php");
  break;
 }

 if ($cook_id == "") {
  $cook_id = time();
  setcookie("cook_id", $cook_id, time()*2, "/");
  statistic("kiga", "Kiga".strip_subline($tabname)." Besucher", $cook_id, "visit", $connr);
  }
 else
  statistic("kiga", "Kiga".strip_subline($tabname)." Aufrufe", $cook_id, "visit", $connr);


 //datei muss form haben: z.B. inc.gaestebuch.php
 @include("inc.".strip_subline($tabname).".php");

 if ($to_alert)
   echo"
    <html>
     <body>
      <script language=\"JavaScript\">
        alert('$to_alert');
        window.location.href='$url';
      </script>
     </body>
    </html>";
  else {

   header("Location: $url");
   exit;
  }

?>