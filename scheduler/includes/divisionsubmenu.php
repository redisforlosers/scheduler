<?php # divisionsubmenu.php

echo "<div class=\"submenuhead\"><h5><a href=\"/scheduler/$division/daily\">$ucdivision</a></h5></div>\n";
echo '<div class="sect"><div class="links"><a href="/scheduler/'.$division.'/daily">Daily</a><br/>
	<a href="/scheduler/'.$division.'/weekly">Weekly</a></div></div>';

$today = date('Y-m-d');
$years = array();
$schedules = array();

$query = "SELECT * FROM schedules, divisions WHERE div_link = '$division' AND division = div_name 
	AND schedule_end_date >= '$today' ORDER BY schedule_start_date ASC";
$result = mysqli_query($dbc, $query);
if($result){
	while ($row = mysqli_fetch_assoc($result)){
		$schedule_id = $row['schedule_id'];
		$schedule_start_date = $row['schedule_start_date'];
		$schedule_end_date = $row['schedule_end_date'];
		$specific_schedule = $row['specific_schedule'];
		
		$schedule_start_year = date('Y', strtotime($schedule_start_date));
		$schedule_end_year = date('Y', strtotime($schedule_end_date));
		$years[] = $schedule_start_year;
		$schedule_start_friendly = date('j M', strtotime($schedule_start_date));
		if ($schedule_start_year != $schedule_end_year){
			$schedule_end_friendly = date('j M Y', strtotime($schedule_end_date));
			}
		else{
			$schedule_end_friendly = date('j M', strtotime($schedule_end_date));
			}
			
		$schedules[] = array('year'=>$schedule_start_year, 'schedule_id'=>$schedule_id, 'start'=>$schedule_start_friendly, 'end'=>$schedule_end_friendly);
		}
	}

$years = array_unique($years);
sort($years);

foreach ($years as $k=>$v){
	echo '<div class="sect"><span class="dp">'.$v.' Schedules</span><br/><div class="links">';
	foreach ($schedules as $index=>$array){
		if ($array['year'] == $v){
			echo '<a href="/scheduler/'.$division.'/'.$array['schedule_id'].'">'.$array['start'].'-'.$array['end'].'</a><br/>';
			}
		}
	echo '</div></div>';
	}
?>


