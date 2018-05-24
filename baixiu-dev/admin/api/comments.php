<?php  

require_once('../../functions.php');

$page = empty($_GET['page']) ? 1 : intval($_GET['page']);

$length = 20;

$offset = ($page - 1) * $length;

$comments = xiu_fetch_all("select 
comments.*,
posts.title AS post_title
from comments
INNER JOIN posts ON comments.post_id = posts.id
ORDER BY comments.created DESC
LIMIT {$offset}, {$length}");

$total_all = xiu_fetch_one('select count(1) as num
from comments
INNER JOIN posts ON comments.post_id = posts.id');

$total_page = ceil((int)$total_all['num'] / $length);


$data = json_encode(array('total_page' => $total_page , 'comments' => $comments));

header('Content-Type: application/json');

echo $data;

