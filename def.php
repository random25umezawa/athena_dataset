<?php
	ini_set('memory_limit', -1);

	// レア度ごとのmasterの個数
	$master_rarity_amounts = [5=>1, 4=>2, 3=>3, 2=>4, 1=>15];
	// [id => rarity]
	$master_rarity_map = array_merge([0],...array_map(function($v,$k){return array_pad([], $v, $k);}, array_values($master_rarity_amounts), array_keys($master_rarity_amounts)));
	// [rarity => [min_index, max_index]]
	$master_rarity_range = array_merge([[0,0]], array_reverse(array_reduce($master_rarity_amounts, function($carry,$item){return array_merge($carry, [[end($carry)[1]+1, end($carry)[1]+$item]]);}, [[0,0]])));

	// レア度ごとのplayerの所持数
	$player_rarity_amounts = [5=>10,4=>30,3=>60,2=>100,1=>800];
	// [index => master_character_id]
	$player_rarity_map = array_map(function($v,$k){return array_pad([], $v, $k);}, array_values($player_rarity_amounts), array_keys($player_rarity_amounts));
	// [rarity => [min_index, max_index]]
	$player_rarity_range = array_merge([[0,0]], array_reverse(array_reduce($player_rarity_amounts, function($carry,$item){return array_merge($carry, [[end($carry)[1]+1, end($carry)[1]+$item]]);}, [[0,0]])));

	function get_random_range_value(&$rarity_range, $rarity, &$id)
	{
		return ['id' => $id++, 'master_character_id' => rand($rarity_range[$rarity][0], $rarity_range[$rarity][1])];
	}

	$variables = ['master_characters', 'players', 'info'];

	function save($master_characters, $players, $info)
	{
		global $variables;
		$info['date'] = date('Y-m-d', strtotime("{$info['date']} +1 day"));
		foreach (array_column(array_map(null, $variables, [$master_characters, $players, $info]), 1, 0) as $name => $value) file_put_contents($name.'.json', json_encode($value));
	}

	function load()
	{
		global $variables;
		return array_map(function($name){return json_decode(file_get_contents($name.'.json'), true);}, $variables);
	}

	function save_log($name, &$log)
	{
		file_put_contents($name.".json", implode("\n",array_map(function($a){return json_encode($a);}, $log)));
	}

	function save_logs(&$character_log, &$sell_log)
	{
		save_log('character_log', $character_log);
		save_log('sell_log', $sell_log);
	}
