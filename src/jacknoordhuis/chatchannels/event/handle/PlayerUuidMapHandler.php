<?php

/**
 * PlayerUuidMapHandler.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\event\handle;

use jacknoordhuis\chatchannels\event\EventHandler;
use jacknoordhuis\chatchannels\event\utils\HandlerList;
use jacknoordhuis\chatchannels\utils\UuidMap;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class PlayerUuidMapHandler extends EventHandler {

	public function handles(HandlerList $list) : void {
		$list->handler("handlePlayerJoin")
			->event(PlayerJoinEvent::class);
		$list->handler("handlePlayerQuit")
			->event(PlayerQuitEvent::class);
	}

	/** @var \jacknoordhuis\chatchannels\utils\UuidMap */
	private $map;

	public function __construct(UuidMap $map) {
		$this->map = $map;
	}

	public function handlePlayerJoin(PlayerJoinEvent $event) : void{
		$this->map->add($event->getPlayer());
	}

	public function handlePlayerQuit(PlayerQuitEvent $event) : void {
		$this->map->remove($event->getPlayer()->getUniqueId()->toString());
	}

}