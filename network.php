<?php
	function courseURL($code, array $info){
		$y = $info['year'];
		$sem = $info['sem'];
		$url = 'http://wish.wis.ntu.edu.sg/webexe/owa/AUS_SCHEDULE.';
		$url .= 'main_display1?staff_access=false&acadsem='.$y.';'.$sem;
		$url .= '&r_subj_code='.strtoupper($code).'&boption=Search&r_search_type=F';
		return $url;
	}//courseURL($code, array $info);
		
	function fetch($url){
		$url = preg_replace('/https/','http',$url);
		return preg_replace("/\n/","",strtolower(file_get_contents($url)));
	}//fetch($url);
?>
