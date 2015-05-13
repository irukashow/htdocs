<?php

require_once 'DB.php';

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>サンプル</title>
</head>
<body>
<?php

$dbh = DB::connect('mysql://root:@127.0.0.1/sample');
if (DB::isError($dbh)) {
  exit($dbh->getMessage());
}

$dbh->query('SET NAMES utf8');
if (DB::isError($dbh)) {
  exit($dbh->getMessage());
}

$sth = $dbh->query('SELECT * FROM m_stuff');
if (DB::isError($sth)) {
  exit($sth->getMessage());
}

while ($data = $sth->fetchRow(DB_FETCHMODE_ASSOC)) {
  echo '<p>' . $data['id'] . ':' . $data['name_sei'] . "</p>\n";
}

$dbh->disconnect();

?>
</body>
</html>