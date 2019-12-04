<?php
	require 'def.php';

	list($master_characters, $players, $info) = load();

	$character_log = [];
	$sell_log = [];

	for ($i = 0; $i < 100000; $i++) {
		$player_id = rand(1, count($players));
		$sells = ['player_id' => $player_id, 'sell_character_ids' => []];
		foreach (array_keys($master_rarity_amounts) as $rarity) {
			$player_character_index = get_random_range_value($player_rarity_range, $rarity, $dummy)['master_character_id'];
			$sells['sell_character_ids'][] = $players[$player_id][$player_character_index];
			$new_character = get_random_range_value($master_rarity_range, $rarity, $info['id']);
			$players[$player_id][$player_character_index] = $new_character['id'];
			$character_log[] = $new_character;
		}
		$sell_log[] = $sells;
	}

	save($master_characters, $players, $info);
	save_logs($character_log, $sell_log);
