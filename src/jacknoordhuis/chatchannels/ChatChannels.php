<?php

/**
 * ChatChannels.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels;

use jacknoordhuis\chatchannels\channel\ChannelManager;
use jacknoordhuis\chatchannels\config\SettingsConfigurationLoader;
use jacknoordhuis\chatchannels\event\EventManager;
use jacknoordhuis\chatchannels\event\handle\PlayerUuidMapHandler;
use jacknoordhuis\chatchannels\session\SessionManager;
use jacknoordhuis\chatchannels\utils\UuidMap;
use pocketmine\plugin\PluginBase;

class ChatChannels extends PluginBase {

	/** @var \jacknoordhuis\chatchannels\utils\UuidMap */
	protected $uuidMap;

	/** @var \jacknoordhuis\chatchannels\event\EventManager */
	protected $eventManager;

	/** @var \jacknoordhuis\chatchannels\session\SessionManager */
	protected $sessionManager;

	/** @var \jacknoordhuis\chatchannels\channel\ChannelManager */
	protected $channelManager;

	/** @var \jacknoordhuis\chatchannels\config\SettingsConfigurationLoader */
	private $settingsConfigurationLoader;

	const SETTINGS_CONFIG = "Settings.yml";

	public function onEnable() {
		$this->saveResource(self::SETTINGS_CONFIG);

		$this->eventManager = new EventManager($this);
		$this->eventManager->registerHandler(new PlayerUuidMapHandler($this->uuidMap = new UuidMap()));

		$this->sessionManager = new SessionManager($this);
		$this->channelManager = new ChannelManager($this);

		$this->settingsConfigurationLoader = new SettingsConfigurationLoader($this, $this->getDataFolder() . self::SETTINGS_CONFIG);
	}

	public function onDisable() {

	}

	/**
	 * @return \jacknoordhuis\chatchannels\event\EventManager
	 */
	public function getEventManager() : EventManager {
		return $this->eventManager;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\session\SessionManager
	 */
	public function getSessionManager() : SessionManager {
		return $this->sessionManager;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\channel\ChannelManager
	 */
	public function getChannelManager() : ChannelManager {
		return $this->channelManager;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\utils\UuidMap
	 */
	public function getPlayerUuidMap() : UuidMap {
		return $this->uuidMap;
	}

}