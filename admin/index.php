<?php
/**
 * Created by PhpStorm.
 * User: YoshitakaFujisawa
 * Date: 17/11/12
 * Time: 午後7:04
 */
$ini_array  = parse_ini_file("config.ini");
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>

    <link rel="stylesheet" href="css/ranking.css"/>
    <script>
        $(document).ready(function() {
            $('#ranking').DataTable();
        } );
    </script>
</head>
<body>
<h1> Fuyu Fes 2017 </h1>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li><a href="#">インスタ映え</a></li>
            <li><a href="#">ナイスカップル</a></li>
        </ul>
    </div>
</nav>

<div class="page-header">
    <h3>集計ランキング(インスタ映え)</h3>
</div>

<!--
0 checkbox to enable
1 id (varchar)
2 user_name (varchar)
3 image_name (varchar)
4 score (double)
5 category (varchar)
6 sub_category (varchar)
7 is_enable (int)
8 created_at (DATETIME)
9 updated_at (DATETIME)
10 Image
-->
<div class="row">
    <div class="col-md-10">
        <table id="ranking" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>チェック</th>
                <th>画像</th>
                <th>#</th>
                <th>画像名</th>
                <th>ユーザー名</th>
                <th>スコア</th>
                <th>カテゴリー</th>
                <th>サブカテゴリー</th>
                <th>isEnable</th>
                <th>登録日時</th>
                <th>更新日時</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $cnt = 0;
                foreach ($sth as $row) {
                    echo '<tr>';
                    echo '<td><div><label><input type="checkbox"></label></div></td>';
                    echo '<td><img class="img-thumbnail" src="img/'.($cnt+1).'.jpg" width="100" height="100"></td>';
                    echo '<td>'.htmlspecialchars($row['id']).'</td>';
                    echo '<td>'.htmlspecialchars($row['image_name']).'</td>';
                    echo '<td>'.htmlspecialchars($row['user_name']).'</td>';
                    echo '<td>'.htmlspecialchars($row['score']).'</td>';
                    echo '<td>'.htmlspecialchars($row['category']).'</td>';
                    echo '<td>'.htmlspecialchars($row['sub_category']).'</td>';
                    echo '<td>'.htmlspecialchars($row['is_enable']).'</td>';
                    echo '<td>'.htmlspecialchars($row['created_at']).'</td>';
                    echo '<td>'.htmlspecialchars($row['updated_at']).'</td>';
                    echo '</tr>';
                    $cnt++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div id="btn_action">
    <p>
        <button type="button" class="btn btn-default">Reload</button>
        <button type="button" class="btn btn-danger">Disable</button>
    </p>
</div>

</body>
</html>