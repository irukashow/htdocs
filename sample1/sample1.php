<html>
<head><title>PHP TEST</title></head>
<body>

<?php

require_once 'DB.php';

$dsn = 'mysqli://root:@localhost/sample';

$db = DB::connect($dsn);
if (PEAR::isError($db)) {
    die($db->getMessage());
}

print('接続に成功しました');

$db->disconnect();

?>

</body>
</html>