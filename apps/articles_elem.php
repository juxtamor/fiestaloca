<?php
// while ($article = mysqli_fetch_assoc($res))
// {
// 	require('views/articles_elem.phtml');
// }
$count = 0;
while ($count<count($list))
{
	$article=$list[$count];
	require('views/articles_elem.phtml');
	$count++;
}
?>