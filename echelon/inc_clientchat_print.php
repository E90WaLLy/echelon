<?php include "ctracker.php"; ?>
<?php require_once('Connections/b3connect.php'); ?>
<?php require_once('Connections/inc_config.php'); ?>
<?php
$colname_rs_clientchat = "6490";
if (isset($_GET['id'])) {
  $colname_rs_clientchat = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_b3connect, $b3connect);
$query_rs_clientchat = sprintf('SELECT  * FROM `chatlog` WHERE `client_id` = %s ORDER BY `msg_time` DESC', $colname_rs_clientchat);
$rs_clientchat = mysql_query($query_rs_clientchat, $b3connect) or die(mysql_error());
$row_rs_clientchat = mysql_fetch_assoc($rs_clientchat);
$totalRows_rs_clientchat = mysql_num_rows($rs_clientchat);
?>
<?php if ($totalRows_rs_clientchat > 0) { // Show if recordset not empty ?>
<br>
<br>
<table width="100%" border="0" cellpadding="1" cellspacing="1" class="tabelinhoud">
  <tr class="tabelinhoud">
    <td><strong>Client chat History</strong></td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
  <tr class="tabelinhoud">
    <td width="215" valign="top">
      <?php echo date('l, d/m/Y (H:i)',$row_rs_clientchat['msg_time']); ?>
    </td>
    
    <td width="200">
      <?php echo $row_rs_clientchat['client_name']; ?> says to 
      <?php
        $msgtype = trim($row_rs_clientchat['msg_type']);
        $msglength = strlen($msgtype);
        switch (substr($msgtype, -2)) {
          case 'LL':
            if ($msgtype == 'ALL')
              {
                echo 'all';
              }
            else
              {
                 echo 'all ('.substr($msgtype, 0, $msglength-4).')';
              }
          break;
          case 'AM':
            if ($msgtype == 'TEAM')
              {
                echo 'team '.$row_rs_clientchat['client_team'];
              }
            else
              {
                 echo 'team '.$row_rs_clientchat['client_team'].' ('.substr($msgtype, 0, $msglength-5).')';
              }
          break;
          case 'PM':
            if ($msgtype == 'PM')
              {
                echo '('.$row_rs_clientchat['target_id'] . ') ';
                echo htmlentities($row_rs_clientchat['target_name']) . '</a>';
              }
            else
              {
                echo '('.$row_rs_clientchat['target_id'] . ') ';
                echo htmlentities($row_rs_clientchat['target_name']) . '</a>';
                echo ' ('.substr($msgtype, 0, $msglength-3).')';
              }
          break;
        }; 
      ?>
    </td>
    <td>
      <?php echo $row_rs_clientchat['msg']; ?>
    </td>
  </tr>
  <?php } while ($row_rs_clientchat = mysql_fetch_assoc($rs_clientchat)); ?>
</table>
<?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rs_clientchat);
?>
