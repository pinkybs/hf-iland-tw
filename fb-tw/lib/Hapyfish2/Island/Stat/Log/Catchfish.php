<?php

class Hapyfish2_Island_Stat_Log_Catchfish
{
	public static function handle($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.fish.err');
			return;
		}
		
		$temp = explode("\n", $content);
		
		$allCount = 0;
		$catchInfo = array('allCount' => 0,
 						  'fishId1' => 0,
						  'fishId2' => 0,
						  'fishId3' => 0,
						  'fishId4' => 0,
						  'fishId5' => 0,
						  'fishId6' => 0,
						  'fishId7' => 0,
						  'fishId8' => 0,
						  'fishId9' => 0,
						  'fishId10' => 0,
						  'fishId11' => 0,
						  'fishId12' => 0,	
						  'fishId13' => 0,
						  'fishId14' => 0,
						  'fishId15' => 0,
						  'fishId16' => 0,
						  'fishId17' => 0,
						  'fishId18' => 0,
						  'fishId19' => 0,
						  'fishId20' => 0,
						  'fishId21' => 0,
						  'fishId22' => 0,
						  'fishId23' => 0,
						  'fishId24' => 0,
						  'fishId25' => 0,
						  'fishId26' => 0,
						  'fishId27' => 0,
						  'fishId28' => 0,
						  'fishId29' => 0,
						  'fishId30' => 0,
						  'fishId31' => 0,
						  'fishId32' => 0,
						  'fishId33' => 0,
						  'fishId34' => 0,
						  'fishId35' => 0,
						  'fishId36' => 0,
						  'fishId37' => 0,
						  'fishId38' => 0,
						  'fishId38' => 0,
						  'fishId40' => 0,
						  'fishId41' => 0,
						  'fishId42' => 0,
						  'fishId43' => 0,
						  'fishId44' => 0,
						  'fishId45' => 0,
						  'fishId46' => 0,
						  'fishId47' => 0,
						  'fishId48' => 0,
						  'fishId49' => 0,
						  'fishId50' => 0,
						  'fishId66' => 0,
						  'fishId67' => 0,
						  'fishId68' => 0,
						  'fishId69' => 0,
						  'fishId70' => 0,
						  'fishId71' => 0,
						  'fishId72' => 0,
						  'fishId73' => 0,
						  'fishId74' => 0,
						  'fishId75' => 0,
						  'fishId76' => 0,
						  'fishId77' => 0,
						  'fishId78' => 0,
						  'fishId79' => 0,
						  'fishId80' => 0,
						  'fishId81' => 0,
						  'fishId82' => 0,
						  'fishId83' => 0,
						  'fishId84' => 0,
						  'fishId85' => 0,
						  'fishId86' => 0,
						  'fishId87' => 0,
						  'fishId88' => 0,
						  'fishId89' => 0,
						  'fishId90' => 0,
						  'fishId91' => 0,
						  'fishId92' => 0,
						  'fishId93' => 0,
						  'fishId94' => 0
		);
		
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}
			
			$r = explode("\t", $line);
			
			$uid= $r[2];
			$fishId = $r[3];
			$catchInfo['fishId'.$fishId] ++;
		}
		$catchInfo['create_time'] = $day;
        $dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();
        $dalCatchisland->insert($catchInfo);
        
		return $catchInfo;
	}
	public static function handleUserNum($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.user.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$count = 0;
		$uidArr = array();
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}	
			$r = explode("\t", $line);
			$uid= $r[2];
			if(!isset($uidArr[$uid])) {
				$uidArr[$uid]=1;
				$count++;
			}
			
		}
		 $dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		 $dalCatchisland->updateUserNum($day,$count);
		 return $count;					
	}	
	public static function handleCoin($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.dcard.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$coin = 0;
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}	
			$r = explode("\t", $line);
			$uid= $r[2];
			$num = $r[3];
			$coin = $coin+$num;
		}
		 $dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		 $dalCatchisland->updateCoin($day, $coin);
		 return array($coin);					
	}
	
	public static function handleIsland($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.island.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$open_island1 = 0;
		$open_island2 = 0;
		$open_island3 = 0;
		$open_island4 = 0;
		$open_island5 = 0;
		$open_island6 = 0;
		$open_island7 = 0;
		$open_island8 = 0;
		$open_island9 = 0;
		$open_island10 = 0;
		$open_island11 = 0;
		$open_island12 = 0;
		$open_island13 = 0;
		$open_island14 = 0;
		
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}	
			$r = explode("\t", $line);
			$uid= $r[2];
			$islandId = $r[3];
			if($islandId == 2) {
				$open_island1 ++;
			}elseif($islandId == 3) {
				$open_island2 ++;
			}elseif($islandId == 4) {
				$open_island3 ++;
			}elseif($islandId == 5) {
				$open_island4 ++;
			}elseif($islandId == 6) {
				$open_island5 ++;
			}elseif($islandId == 7) {
				$open_island6 ++;
			}elseif($islandId == 8) {
				$open_island7 ++;
			}elseif($islandId == 9) {
				$open_island8 ++;
			}elseif($islandId == 10) {
				$open_island9 ++;
			}elseif($islandId == 11) {
				$open_island10 ++;
			}elseif($islandId == 12) {
				$open_island11 ++;
			}elseif($islandId == 13) {
				$open_island12 ++;
			}elseif($islandId == 14) {
				$open_island13 ++;
			}elseif($islandId == 15) {
				$open_island14 ++;
			}
		}
		 $dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		 $dalCatchisland->updateIsland($day, $open_island1, $open_island2, $open_island3, $open_island4, $open_island5, $open_island6, $open_island7, $open_island8, $open_island9, $open_island10, $open_island11, $open_island12, $open_island13, $open_island14);
		 return 1;					
	}
	public static function handleCannon($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.cannon.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$cannon1 = 0;
		$cannon2 = 0;

		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}	
			$r = explode("\t", $line);
			$uid= $r[2];
			$type = $r[3];
			if($type == 1) {
				$cannon1 ++;
			}elseif($type == 2) {
				$cannon2 ++;
			}
		}
		 $dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		 $dalCatchisland->updateCannon($day, $cannon1, $cannon2);
		 return 1;					
	}
	public static function handleCard($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.card.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$card = 0;
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}	
			$r = explode("\t", $line);
			$uid= $r[2];
			$num = intval($r[3]);
			$card = $card+$num;
		}
		 $dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		 $dalCatchisland->updateCard($day, $card);
		 return 1;					
	}

	public static function handleMatchFIsh()
	{
		$dir = '/home/admin/data/stat-data/comFish/';
		$dtYesterday = strtotime("-1 day");
		$dt = date('Ymd', $dtYesterday);
		$file = $dir.$dt.'/all-comFish-'.$dt.'.log';
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.card.err');
			return;
		}
		$temp = explode("\n", $content);
		$list = array();
		$join = array();
		$com = 0;
		$num = 0;
		$card = 0;
		$levelUp = 0;
		$P = 0;
		$j = 0;
		$s = 0;
		$fish = array();
		$dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}
			$r = explode("\t", $line);
			if(!isset($join[$r[2]])){
				$join[$r[2]] = 1;
				$num += 1;
			}else{
				$join[$r[2]] += 1;
			}
			if($r[6] == 1){
				if(!isset($list['com'][$r[2]])){
					$list['com'][$r[2]] = 1;
					$com += 1;
				}else{
					$list['com'][$r[2]] += 1;
				}
			}
			if($r[6] == 2){
				if(!isset($list['levelUp'][$r[2]])){
					$list['levelUp'][$r[2]] = 1;
					$levelUp += 1;
				}else{
					$list['levelUp'][$r[2]] += 1;
				}
			}
			if($r[8] > 0){
				if(!isset($list['card'][$r[2]])){
					$list['card'][$r[2]] = 1;
					$card += 1;
				}else{
					$list['card'][$r[2]] += 1;
				}
			}
			if(!isset($fish[$r[6]][$r[3]])){
				$fish[$r[6]][$r[3]]['total'] = 1;
				if($r[7] == 1){
					$fish[$r[6]][$r[3]]['s'] = 1;
				}
			}else{
				$fish[$r[6]][$r[3]]['total'] += 1;
				if($r[7] == 1){
					$fish[$r[6]][$r[3]]['s'] += 1;
				}
			}
			if(!isset($fish[$r[6]][$r[3]]['level'][$r[5]])){
				$fish[$r[6]][$r[3]]['level'][$r[5]] = 1;
			}else{
				$fish[$r[6]][$r[3]]['level'][$r[5]] += 1;
			}
			
			
		}
	}
	
	public static function brushCard($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.card.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$num = 0;
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}
				
			$r = explode("\t", $line);
			$num += 1;
		}
		
		$dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		$dalCatchisland->incBrushCard($day, $num);

		return 1;					
	}
	
	public static function handleBrush($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.card.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$num = 0;
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}
				
			$r = explode("\t", $line);
			$num += 1;
		}
		
		$dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		$dalCatchisland->incBrushNum($day, $num);

		return 1;					
	}

	public static function handleBrushIsland($day, $file)
	{
		$content = file_get_contents($file);
		if (empty($content)) {
			info_log('no data', 'stat.log.catch.island.err');
			return;
		}
		
		$temp = explode("\n", $content);
		$brush_island1 = 0;
		$brush_island2 = 0;
		$brush_island3 = 0;
		$brush_island4 = 0;
		$brush_island5 = 0;
		$brush_island6 = 0;
		$brush_island7 = 0;
		$brush_island8 = 0;
		$brush_island9 = 0;
		$brush_island10 = 0;
		$brush_island11 = 0;
		$brush_island12 = 0;
		$brush_island13 = 0;
		$brush_island14 = 0;
		$brush_island15 = 0;
		
		foreach ($temp as $line) {
			if (empty($line)) {
				continue;
			}
			
			$r = explode("\t", $line);
			$islandId = $r[3];
			
			if ($islandId == 1) {
				$brush_island1 += 1;
			} else if ($islandId == 2) {
				$brush_island2 += 1;
			} else if ($islandId == 3) {
				$brush_island3 += 1;
			} else if ($islandId == 4) {
				$brush_island4 += 1;
			} else if ($islandId == 5) {
				$brush_island5 += 1;
			} else if ($islandId == 6) {
				$brush_island6 += 1;
			} else if ($islandId == 7) {
				$brush_island7 += 1;
			} else if ($islandId == 8) {
				$brush_island8 += 1;
			} else if ($islandId == 9) {
				$brush_island9 += 1;
			} else if ($islandId == 10) {
				$brush_island10 += 1;
			} else if ($islandId == 11) {
				$brush_island11 += 1;
			} else if ($islandId == 12) {
				$brush_island12 += 1;
			} else if ($islandId == 13) {
				$brush_island13 += 1;
			} else if ($islandId == 14) {
				$brush_island14 += 1;
			} else if ($islandId == 15) {
				$brush_island15 += 1;
			}
		}
		
		$dalCatchisland = Hapyfish2_Island_Stat_Dal_Catchfish::getDefaultInstance();	
		$dalCatchisland->updateBrushIsland($day, $brush_island1, $brush_island2, $brush_island3, $brush_island4, $brush_island5, $brush_island6, $brush_island7, $brush_island8, $brush_island9, $brush_island10, $brush_island11, $brush_island12, $brush_island13, $brush_island14, $brush_island15);

		return 1;					
	}
	
}