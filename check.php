<?php
	error_reporting(0);
	$GLOBALS['curl_cmd'] = trim(file_get_contents("curl_cmd.txt"));
	$GLOBALS['vis'] = array();
	if (strpos($GLOBALS['curl_cmd'],"page=0&limit=50") === false) {
		echo "请检查curl指令是否正确。";
		exit(0);
	}
	function get_page($page) {
		$page = shell_exec(str_replace("page=0&limit=50",sprintf("page=%d&limit=50",$page),$GLOBALS['curl_cmd'])." -s");
		$res = json_decode($page,true);
		$i = 0;
		foreach ($res as $each) {
			if ($i == 1) return $each['commonRankings'];
			$i ++;
		}
		//echo count($res);
		/*
		foreach ($res['commonRankings'] as $each) {
			var_dump($each);
		}
		*/
	}
	function check_all($team_key='*') {
		$i = 0;
		while (true) {
			$board = get_page($i);
			if (empty($board)) break;
			//if (count($board) == 0) break;
			foreach ($board as $each) {
				$team = $each['user']['user']['nickname'];
				if ($team_key == '*' || !(mb_strpos($team,$team_key) === false)) {
					foreach ($each['problemScores'] as $problem => $probleminfo) {
						if (intval($probleminfo['score']) == 0) continue;
						if (!$GLOBALS['vis'][sprintf("%s %s\n",$team,$problem)]) {
							echo sprintf("%s %s\n",$team,$problem);
						}
						$GLOBALS['vis'][sprintf("%s %s\n",$team,$problem)] = true;
						
					}
				}
			}
			$i ++;
			sleep(1);
		}
	}
	while (true) {
		check_all("_重大_");
		sleep(10);
	}
	
?>
