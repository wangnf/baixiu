<?php 

$a = [1,2,3,1,1];
$b = ['a'=>'1','b'=>'2','c'=>'3','a'=>'1'];

array_push($a, 4);
// array_unique($a);
array_unique($b);

array_pop($a);

var_dump($a);
echo '<br>';
var_dump($b);
echo '<br>';
echo count($a);
echo '<br>';
echo in_array(2, $a);

echo '<br>';
echo array_search(1, $a);