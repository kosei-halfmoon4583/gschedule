<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _._________                                 |
   +----------------------------------------------------------------------+
   | Script-ID      : schdEntry.php                                       |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");    
    require_once("footer.php"); //footer(outer file.)
    $header_title = "[ 予定内容登録 ]";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; CHARSET=UTF-8">
<title>[ 予定内容登録 ]</title>

    <link rel="stylesheet" type="text/css" href="./resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />

    <script type="text/javascript" src="./adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="./js/ext-all.js"></script>
    <script type="text/javascript" src="./js/ext-lang-ja.js"></script>
    <script type="text/javascript" src="./js/schdTitle.js"></script>
    <script type="text/javascript" src="./js/SearchField.js"></script>

</HEAD>
<BODY>
<?php require_once("header.php"); ?>
<div id="content">
<!-- <div id="header"> -->
<div id="menu">
<TABLE border="0">
<TBODY style="font-size:10pt">
    <TR><TD>&nbsp;</TD></TR>
    <TR><TD>
        <A href="http://www.extjs.co.jp/" target="_blank">
        <IMG src="./resources/images/extjs_powered.png" width="99" height="35" border="0"></A><BR>
        <A href="http://www.extjs.co.jp/" target="_blank">&nbsp;&nbsp;<U>ExtJS.</U></A>
    </TD></TR>
    <TR><TD>&nbsp;</TD></TR>
    <TR><TD>
        <A href="http://www-jp.mysql.com/" target="_blank">
        <IMG src="./resources/images/mysql_logo2.png" width="125" height="42" border="1"></A><BR>
        <A href="http://www-jp.mysql.com/" target="_blank">&nbsp;<U>MySQL -comunity-</U></A>
    </TD></TR>
    <TR><TD>&nbsp;</TD></TR>
    <TR><TD>
        <A href="http://www.webexone.com/JP/" target="_blank">
        <IMG src="./resources/images/WebExOne_Logo.gif" width="119" height="39" border="1"></A><BR>
        <A href="http://www.webexone.com/JP/" target="_blank">&nbsp;<U>WebEx One.</U></A>
    </TD></TR>
    <TR><TD>&nbsp;</TD></TR>
    <TR><TD>
        <A href="http://www.dreamfactory.com/" target="_blank">
        <IMG src="./resources/images/DF_logo_mini.gif" width="80" height="60" border="1"></A><BR>
        <A href="http://www.dreamfactory.com/" target="_blank">&nbsp;<U>Dreamfactory.</U></A>
    </TD></TR>
    <TR><TD>&nbsp;</TD></TR>
    <TR><TD>
        <A href="http://www.greentree.jp/" target="_blank">
        <IMG src="./resources/images/footer_greentree.gif" width="88" height="31" border="1"></A><BR>
        <A href="http://www.greentree.jp/" target="_blank">&nbsp;<U>GreenTree Inc.</U></A>
    </TD></TR>
</TBODY>
</TABLE>
</div>

<div id="main3">

<form method=get action="http://www.google.co.jp/search" target="_blank">
<table><tr><td>
<a href="http://www.google.co.jp/" target="_blank">
<img src="http://www.google.com/logos/Logo_40wht.gif" 
border="0" alt="Google" align="absmiddle"></a>
<input type=text name=q size=31 maxlength=255 value="">
<input type=hidden name=ie value=UTF-8>
<input type=hidden name=oe value=UTF-8>
<input type=hidden name=hl value="ja">
<input type=submit name=btnG value="Google 検索">
</td></tr></table>
</form>

<?php
  /*=================================================================================*
   * $year,$month,$dayURLがパラメータとして渡ってこない場合の処理                    *
   * userEntry.phpは、mcalen.phpのリンクからしか呼び出されることはない               *
   * 従って、userEntry.phpの戻り先は必ずmcalen.phpとする、mcalen.phpに               *
   * 戻ってきたときはカレント年月が表示される                                        *
   *=================================================================================*/
    if (!isset($year)) {
        $today = getdate();
        $year = $today["year"];
        $month = $today["mon"];
    }
    print("<div id='backbutton' style='position:absolute; top:540px; left:184px; font-size:12px'> \n");
    print("<A href='mcalen.php?year=$year&month=$month'><img src='./resources/images/btn_home1_5.gif' height='15' width='40'></A> \n");
    print("</div> \n");
?>
</div>
</div>
</BODY>
</HTML>
