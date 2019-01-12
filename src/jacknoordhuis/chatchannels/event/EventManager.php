<?php

/**
 * EventManager.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\event;

use jacknoordhuis\chatchannels\ChatChannels;
use jacknoordhuis\chatchannels\event\utils\HandlerList;
use pocketmine\plugin\MethodEventExecutor;

class EventManager {

	/** @var \jacknoordhuis\chatchannels\ChatChannels */
	private $plugin;

	/** @var EventHandler[] */
	private $eventHandlers = [];

	public function __construct(ChatChannels $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * @return ChatChannels
	 */
	public function getPlugin() : ChatChannels {
		return $this->plugin;
	}

	/**
	 * Register an event handler to the pocketmine event manager.
	 *
	 * @param EventHandler $handler
	 *
	 * @throws \ReflectionException
	 */
	public function registerHandler(EventHandler $handler) : void {
		$handler->handles($list = new HandlerList($handler));
		foreach($list->handlers() as $method) {
			$this->plugin->getServer()->getPluginManager()->registerEvent($method->fetchEvent(), $handler, $method->fetchPriority(), new MethodEventExecutor($method->fetchMethod()), $this->plugin, $method->fetchIgnoreCancelled());
			$this->plugin->getLogger()->debug("Registered listener for " . (new \ReflectionClass($method->fetchEvent()))->getShortName() . " for " . (new \ReflectionObject($handler))->getShortName() . "::" . $method->fetchMethod() . "()");
		}

		$this->eventHandlers[] = $handler;
		$handler->setManager($this);
	}

}