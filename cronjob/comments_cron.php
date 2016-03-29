<?php
// Load new comments from one table to the other

// Connect to db
$db = mysql_connect('localhost', 'ttbapp43', 'ttbIs443');
mysql_select_db('ttbproduction', $db);

// Get time of last comment recorded
$last_time = "";
$result = mysql_query("select time from comments where is_sms = 1 order by time desc limit 1");
if($row = mysql_fetch_row($result))
{
	$last_time = $row[0];
}

if(!empty($last_time))
{
	$query = "select * from business_store_comments where comment_date > '$last_time' order by comment_date asc";
}
else
{
	$query = "select * from business_store_comments order by comment_date asc";
}

$result1 = mysql_query($query);

while($row1 = mysql_fetch_array($result1))
{
	$query2 = "INSERT INTO comments (comment,code,customer_id,time,nature, is_sms) VALUES ('".addslashes($row1['comment'])."','".$row1['code']."','".$row1['customer_id']."','".$row1['comment_date']."','".$row1['counted_as']."', 1)";
	
	mysql_query($query2);
}

?>