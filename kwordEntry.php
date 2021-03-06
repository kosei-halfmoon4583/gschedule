<?php
session_start();
  /*======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : kwordEntry.php                                      |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
    require_once("sschk.php");    
    require_once("footer.php"); //footer(outer file.)
    $header_title = "[ キーワード登録 ]";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; CHARSET=UTF-8">
<title>[ キーワード登録 ]</title>

    <link rel="stylesheet" type="text/css" href="./resources/css/ext-all.css" />
    <link rel="stylesheet" type="text/css" href="./resources/css/gs.css" />

    <script type="text/javascript" src="./adapter/ext/ext-base.js"></script>
    <script type="text/javascript" src="./js/ext-all.js"></script>
    <script type="text/javascript" src="./js/ext-lang-ja.js"></script>
    <script type="text/javascript" src="./js/kwd.js"></script>
    <script type="text/javascript" src="./js/SearchField.js"></script>

</HEAD>
<BODY>
<?php require_once("header-sub.php"); ?>
<div id="content">
<!-- <div id="header"> -->
<div id="menu-ad">
<?php // require_once("menuBanner.php"); ?>
</div>

<!-- [Google Search Window]
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
-->

<?php
  /*=================================================================================*
   * $year,$month,$dayURLがパラメータとして渡ってこない場合の処理                    *
   * kwordEntry.phpは、mcalen.phpのリンクからしか呼び出されることはない               *
   * 従って、userEntry.phpの戻り先は必ずmcalen.phpとする、mcalen.phpに               *
   * 戻ってきたときはカレント年月が表示される                                        *
   *=================================================================================*/
    if (!isset($year)) {
        $today = getdate();
        $year = $today["year"];
        $month = $today["mon"];
    }
    print("<div id='backbutton' style='position:absolute; top:540px; left:390px; font-size:12px'> \n");
    print("<A href='mcalen.php?year=$year&month=$month'><img src='./resources/images/btn_home1_5.gif' height='15' width='40'></A> \n");
    print("</div> \n");
?>
</div>
</BODY>
</HTML>
