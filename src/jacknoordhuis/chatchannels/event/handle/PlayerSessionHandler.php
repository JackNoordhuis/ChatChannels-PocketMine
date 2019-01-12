<?php

/**
 * PlayerSessionHandler.php - PM-ChatChannels
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
use jacknoordhuis\chatchannels\session\holder\PlayerSessionHolder;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class PlayerSessionHandler extends EventHandler {

	public function handles(HandlerList $list) : void {
		$list->handler("onPlayerJoin")
			->event(PlayerJoinEvent::class);
		$list->handler("onPlayerQuit")
			->event(PlayerQuitEvent::class);
	}

	public function onPlayerJoin(PlayerJoinEvent $event) {
		$holder = new PlayerSessionHolder($event->getPlayer());
		$holder->setManager($manager = $this->getManager()->getPlugin()->getSessionManager());
		$manager->getProvider()->load($holder);
	}

	public function onPlayerQuit(PlayerQuitEvent $event) {
		$manager = $this->getManager()->getPlugin()->getSessionManager();
		$session = $manager->getPlayerSessionsName()->get($event->getPlayer()->getLowerCaseName());
		if($session !== null) {
			$manager->getProvider()->save($session->getHolder(), $session->toArray());
			$manager->removeSession($session);
		}
	}

}