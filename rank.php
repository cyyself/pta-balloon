<?php
	error_reporting(0);
	$GLOBALS['curl_cmd'] = trim(file_get_contents("curl_cmd.txt"));
	$GLOBALS['vis'] = array();
	if (strpos($GLOBALS['curl_cmd'],"page=0&limit=50") === false) {
		echo "请检查curl指令是否正确。排行榜应设置到第一页。";
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
	}
	function get_medal($rank,$team) {//for CCPC
		$team = min($team,240);
		if ($rank <= $team * 0.1) return "Au";
		else if ($rank <= $team * 0.3) return "Ag";
		else if ($rank <= $team * 0.6) return "Cu";
		else return "Fe";
	}
	function get_rank($team_key='*') {
		$list = explode("\n",trim(file_get_contents("正式队伍.txt")));
		$mp = array();
		foreach ($list as $each) $mp[trim($each)] = true;
		$i = 0;
		$rank = 0;
		while (true) {
			$board = get_page($i);
			if (empty($board)) break;
			//if (count($board) == 0) break;
			foreach ($board as $each) {
				$team = $each['user']['user']['nickname'];
				if ($mp[$team]) $rank ++;
				if ($team_key == '*' || !(strpos($team,$team_key) === false)) {
					echo "\07";
					echo "\n";
					echo sprintf("%s %d %s\n",$team,$rank,get_medal($rank,count($list)));
				}
			}
			$i ++;
			sleep(1);
		}
	}
	get_rank("_重大_");
?>
