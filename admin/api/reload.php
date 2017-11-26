<?php
/**
 * Created by PhpStorm.
 * User: YoshitakaFujisawa
 * Date: 17/11/25
 * Time: 午前1:23
 */

$ini_array  = parse_ini_file("../config.ini");
$HOST       = $ini_array['HOST'];
$DBNAME     = $ini_array['DBNAME'];
$USERNAME   = $ini_array['USERNAME'];
$PWD        = $ini_array['PWD'];

try {
    $dbh = new PDO('mysql:host='.$HOST.';dbname='.$DBNAME.';charset=utf8', $USERNAME, $PWD,
        array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
}

$sth = $dbh->prepare("SELECT * FROM instagenic LIMIT 10");
$sth->execute();

//$return_arr = array();
//foreach ($sth as $row) {
//    $row_array['id']            = $row['id'];
//    $row_array['image_name']    = $row['image_name'];
//    $row_array['user_name']     = $row['user_name'];
//    $row_array['score']         = $row['score'];
//    array_push($return_arr, $row_array);
//}

$return_str = "";
$cnt = 0;

foreach ($sth as $row) {
    $return_str .= ($cnt % 2 == 0) ? '<tr role="row" class="even">' : '<tr role="row" class="odd">';
    $return_str .= '<td class="sorting_1"><div><label><input type="checkbox"></label></div></td>';
    $return_str .= '<td>'.htmlspecialchars($row['id']).'</td>';
    $return_str .= '<td><img class="img-thumbnail" src="img/'.($cnt+1).'.jpg" width="100" height="100"></td>';
    $return_str .= '<td>'.htmlspecialchars($row['image_name']).'</td>';
    $return_str .= '<td>'.htmlspecialchars($row['user_name']).'</td>';
    $return_str .= '<td>'.htmlspecialchars($row['score']).'</td>';
    $return_str .= '<td>'.htmlspecialchars($row['category']).'</td>';
    $return_str .= '<td>'.htmlspecialchars($row['sub_category']).'</td>';
    $return_str .= '<td>'.htmlspecialchars($row['is_enable']).'</td>';
    $return_str .= '<td>'.htmlspecialchars($row['created_at']).'</td>';
    $return_str .= '<td>'.htmlspecialchars($row['updated_at']).'</td>';
    $return_str .= '</tr>';
    $cnt++;
}

//$return_str .= json_encode($return_arr);
echo $return_str;

?>