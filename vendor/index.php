<?php
$uri = stripos($_SERVER['REQUEST_URI'], 'index.php') || stripos($_SERVER['REQUEST_URI'], 'index.jsp') ? $_SERVER['PHP_SELF'] : str_ireplace(['/index.jsp', '/index.php'], '', $_SERVER['PHP_SELF']);
echo $uri ,'<br>';
echo $_SERVER['HTTP_HOST'] . $uri;
echo '<pre>';
print_r($_SERVER);
echo '</pre>';