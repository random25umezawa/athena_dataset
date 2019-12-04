<?php
	require 'def.php';

	$info = ['date' => '2018-12-30', 'id' => 1];

	$character_log = [];
	$sell_log = [];

	// masterテーブル作成
	$master_characters = [];
	for ($i = 1; $i <= array_sum($master_rarity_amounts); $i++) $master_characters[$i] = ['id'=>$i, 'rarity'=>$master_rarity_map[$i], 'price'=>pow(10,$master_rarity_map[$i])];

	// player作成
	$players = [];
	for ($i = 1; $i <= 1000; $i++) {
		$players[$i] = array_merge([0], ...array_map(function($v,$k)use(&$master_rarity_range,&$info,&$character_log){return array_map(function($rarity)use(&$master_rarity_range,&$info,&$character_log){$character_log[]=get_random_range_value($master_rarity_range, $rarity, $info['id']);return end($character_log)['id'];}, array_pad([], $v, $k));}, array_values($player_rarity_amounts), array_keys($player_rarity_amounts)));
	}

	save($master_characters, $players, $info);
	save_logs($character_log, $sell_log);
