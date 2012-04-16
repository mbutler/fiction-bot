<?php

function randomChance($percent) {
	$chance = mt_rand(1, 100);
	if ($chance <= $percent) {
		return TRUE;
	} else if ($chance > $percent) {
		return FALSE;
	}
}

?>