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

ini_set('log_errors', 'On');
ini_set('error_log', '../error.log');

try {
    $dbh = new PDO('mysql:host='.$HOST.';dbname='.$DBNAME.';charset=utf8', $USERNAME, $PWD,
        array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
    exit('データベース接続失敗。'.$e->getMessage());
}

/*
 * DB更新
 */
try{
    //パラメータ取得
    $arrChecks = json_decode($_POST['checks']);

    //DB更新
    $sql = "UPDATE instagenic SET is_enable = :is_enable WHERE id = :id";
    $sth = $dbh->prepare($sql);

    foreach ($arrChecks as $val) {
        $sth->execute(array(
                ':is_enable' => 0,
                ':id' => $val)
        );
    }
} catch (Exception $e) {
    error_log($e->getMessage());
}

?>