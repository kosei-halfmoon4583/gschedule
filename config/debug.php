function getList() {
    $val = "";
    $query = "SELECT userid, passwd, jpname, email, notify, admin FROM accounttb ORDER by userid";
    $result = mysql_query($query);
    $nbrows = mysql_num_rows($result);

    // Here we check if we have a query parameter :
    if (isset($_POST['query'])) {
        $query .= 
            " WHERE (userid LIKE '%".addslashes($_POST['query'])."%' OR jpname LIKE '%".addslashes($_POST['query'])."%')";
    }

    $start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
    $end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
    $limit = $query." LIMIT ".$start.",".$end;
    $result = mysql_query($limit);

    if($nbrows > 0) {
        while($rec = mysql_fetch_assoc($result)){
            $val = $rec['jpname'];
            $val = mb_convert_encoding($val, "UTF-8", "EUC-jp");
            $rec['jpname'] = $val;
            $arr[] = $rec;
        }
        $jsonresult = JEncode($arr);
        echo '({"total":"'.$nbrows.'","results":'.$jsonresult.'})';
    } else {
        echo '({"total":"0", "results":""})';
    }
}
