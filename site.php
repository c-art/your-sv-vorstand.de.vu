<?php
  // Copyright by C-Art Webdesign'2002(c-art@web.de)

  include("inc.config.php");

  switch($type) {
   case "team":
   default:
    $text = "
      Wir sind Elke Weber, Rike Unger und Jennifer Bielohlawek. Zusammen organisieren wir die Arbeit
      der Schülervertretung in der Faschschule für Sozialwesen in Bad Kreuznach.";
    break;
   case "miss":
    $text = "
      <ul>
       <li>SV-Sitzungen leiten</li>
       <li>Schülerparty organisieren</li>
       <li>Vertrauensleherwahl</li>
       <li>Eure Probleme lösen :-)</li>
       <li>und vieles mehr....</li>
      </ul><br><br>";
    break;
   case "cont":
      include("$libarypath/class.multiadmin.php");
      //generate Formular
      $entry = new multiadmin();     //init class
      $entry->tabname=$mysql_tbcontact;      //tabname in wchi data should stored
      $entry->mode="new";            //new data = empty formular
      $entry->tabvis=0;              //0= only columns with no limits are visible;  1=restricted visible;
      $entry->rowreq=1;              //how many formulars
      $entry->connr=$connr;          //connection number to database
      $entry->getTabData();          //get alle Formular data in Arrays

      for($i = 0; $i<$entry->rowanz; $i++){ //for every anz Formulars
       for($k = 0; $k<$entry->columnanz; $k++){ //for every Column
        if ($entry->columnheadln[$k]!="" && $entry->rowcontent[$i][$k]!="" && (!$entry->columnvis[$k] || ($entry->columnvis[$k]==5 && $entry->tabvis))) {
          $toe_form.="<tr class=$class><td class=textbold>".$entry->columnheadln[$k]."</td><td valign=middle nowrap>&nbsp;".$entry->rowcontent[$i][$k]."<span class=error>".$errormsg[$i][$k]."</span></td></tr>\n";
         }
         else
          $toe_form.=$entry->rowcontent[$i][$k];
        }
      }

     $text = '
        <table cellpadding=0 cellspacing=0 border=1 bordercolor=#FF9900><tr><td align=center>
         <table border=0>
          <form action=sql.php onsubmit="return checkInput(0)">'
           ."<input type=hidden name=tabname value=\"".$entry->tabname."\">
                <input type=hidden name=connr value=\"$connr\">
                <input type=hidden name=url value=\"site.php?site=start\">
                <input type=hidden name=mode value=\"".$entry->mode."\">
                <input type=hidden name=to_alert value=\"Vielen Dank für Ihre Nachricht!\">

                <input type=hidden name=to_mail value=\"".$cfg_mailto."\">
                <input type=hidden name=mailfrom value=\"info@ev-kiga-albig.de\">
                <input type=hidden name=mailmode value=\"email\">
                <input type=hidden name=mailfields value=\"1\">
                <input type=hidden name=mailsubject value=\"Es wurde eine Frage gestellt\">
                <input type=hidden name=mailtextbefore value=\"Es wurde eine Frage gestellt von:\n\">
                <input type=hidden name=mailtextafter value=\"\">
                $toe_form".'
           <tr class=rowbglight><td colspan=2 align=center><input type=submit value=Absenden></td></tr>
          </form>
         </table></td></tr>
        </table>';

    break;
   case "guest":
    $text .= '
    <form method="post" action="insert.php">
     <table border="1" bordercolor="#FFB50E" cellpadding="3" cellspacing="0" rules="none">
      <tr>
       <td class="text" nowrap>Name:</td>
       <td align="right"><input type="text" name="name" size="44" maxlength="66"></td>
      </tr>
      <tr>
       <td class="text" nowrap>E-M@il*:</td>
       <td align="right"><input type="text" name="email" size="44" maxlength="66"></td>
      </tr>
      <tr>
       <td class="text" nowrap>Homepage*:</td>
       <td align="right"><input type="text" name="url" size="44" maxlength="66"></td>
      </tr>
      <tr>
       <td align="center" colspan="2"><textarea name="text" rows="6" cols="55"></textarea></td>
      </tr>
      <tr>
       <td align="center" colspan="2"><input type="submit" value="Eintrag bestätigen" class="txtsubmit">&nbsp;<input type="reset" value="zurücksetzen" class="txtreset"></td>
      </tr>
      <tr>
       <td align="right" colspan="2" class="text">* = Diese Eingabefelder können frei gelassen werden.</td>
      </tr>
     </table>
    </form><br>
    <table border=0 cellpadding=0 cellspacing=0 width=75%>';

      //Daten von der Datenbank holen
       $query ="SELECT * FROM $mysql_tbgb ORDER BY no DESC";
       $res = mysql_query($query, $mysql_nr[$connr]) or myerror($query, __LINE__, __FILE__, mysql_error($mysql_nr[$connr]));
      //Daten einzeln verarbeiten
       while($row = mysql_fetch_array($res)) {
        $status = true;
      // damit emailadresse und url schön dargestellt werden (ist nur spielerei)
        $temail = ($row['email'] != "") ? "<a href=\"mailto:".$row['email']."\" class=links>".$row['email']."</a>" : "";
        $turl = ($row['url'] != "") ? "<a href=\"http://".$row['url']."\" target=_blank class=links>".$row['url']."</a>" : "";
        $slash = (($row['url'] != "") && ($row['email']!="")) ? "/" : "";
      //daten ausgeben
        $text .= "
         <tr><td class=cap>".$row['name']."</td></tr>
         <tr><td class=text>$temail $slash $turl</td></tr>
         <tr><td class=text>&nbsp;".$row['text']."</td></tr>
         <tr><td class=textsmall>".strftime("%d. %B %Y | %H:%M", $row['no'])."</td></tr>
         <tr><td><hr noshade color=#FFB50E size=1></td></tr>
         ";
      }
      if (!$status) $text .= "<tr><td class=headln align=center><br><br>- noch keine Einträge vorhanden -</td></tr>";
      $text .= "</table>";

      mysql_close();

    break;
  }

?>

<html>
 <head>
  <title>SV-Vorstand 2002/2003 der Fachschule für Sozialwesen Bad Kreuznach</title>
 </head>
 <link rel=stylesheet type="text/css" href="style.css">
 <body bgcolor="1EBB00">
  <center>
   <table width="700" bgcolor="FFFFFF" cellspacing=0 cellpadding=0>
    <tr><td align=center colspan=3><img src="../img/logo.gif" border=0></td></tr>
    <tr><td align=center colspan=3><img src="../img/line.gif" border=0 width=650></td></tr>
    <tr>
     <td>
      <table>
       <tr><td><a href=site.php?type=team><img src="../img/team.gif" border=0></a></td></tr>
       <tr><td><a href=site.php?type=miss><img src="../img/mission.gif" border=0></a></td></tr>
       <tr><td><a href=site.php?type=guest><img src="../img/guest.gif" border=0></a></td></tr>
       <tr><td><a href=site.php?type=cont><img src="../img/cont.gif" border=0></a></td></tr>
       <tr><td><img src="../img/blank.gif" width=5 height=600 border=0></td></tr>
      </table>
     </td>
     <td></td>
     <td valign=top><br><br>
      <table>
       <tr>
        <td><img src="../img/blank.gif" width=20 height=600 border=0></td>
        <td class="text" valign=top>

      <?php echo $text; ?>

        </td>
        <td><img src="../img/blank.gif" width=20 height=600 border=0></td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </center>
 </body>
</html>