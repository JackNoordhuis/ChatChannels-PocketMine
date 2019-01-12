<?php

/**
 * UuidMap.php – PM-ChatChannels
 *
 * Copyright (C) 2019 Jack Noordhuis
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Jack
 *
 */

declare(strict_types=1);

namespace jacknoordhuis\chatchannels\utils;

use pocketmine\Player;

class UuidMap {

	/** @var \pocketmine\Player[] */
	protected $map = [];

	/**
	 * @param \pocketmine\Player $player
	 */
	public function add(Player $player) : void {
		$this->map[$player->getUniqueId()->toString()] = $player;
	}

	/**
	 * @param string $uuid
	 *
	 * @return \pocketmine\Player|null
	 */
	public function get(string $uuid) : ?Player {
		return $this->map[$uuid] ?? null;
	}

	/**
	 * @param string $uuid
	 */
	public function remove(string $uuid) : void {
		unset($this->map[$uuid]);
	}

	public function destroy() : void {
		$this->map = [];
	}

}