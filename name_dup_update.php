<?php #name_dup_update.php
require_once ('/home/teulberg/lpl-repository.com/mysql_connect_sched2.php'); //Connect to the db.

$query="SELECT first_name, emp_id, count(*) as c FROM employees WHERE active='Active' GROUP BY first_name having c=1";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	$emp_id = $row['emp_id'];
	$query2 = "UPDATE employees SET name_dup='N' WHERE emp_id='$emp_id'";
	$result2 = mysql_query($query2);
	}

?>