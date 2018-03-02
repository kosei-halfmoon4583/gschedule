<?php
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright(C). 2008.01.22 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : wekUreg.php                                         |
   | DATA-WRITTEN   : 2008.01.22                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
/* Special Routine */
/* wcalen.php実行時に今週以外の週を表示させたままmcale.phpに戻ると、
   次回、wcalen.phpを開いたときに今週がデフォルト表示されない、
   この問題を解消するためにmcalen.phpに戻ってきたときに、wcalen.phpで
   発行したSessionをクリアする。
*/

$sCurMonday = "sCurMonday";
$thisMonday = "thisMonday";
$flag = "flag";

/*
if (session_is_registered("sCurMonday")) {
    session_unregister("sCurMonday");
}
if (session_is_registered("thisMonday")) {
    session_unregister("thisMonday");
}
if (session_is_registered("flag")) {
    session_unregister("flag");
}
*/

if (isset($sCurMonday)) {
    unset($sCurMonday);
}
if (isset($thisMonday)) {
    unset($thisMonday);
}
if (isset($flag)) {
    unset($flag);
}
?>
