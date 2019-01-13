<?php

/**
 * SettingsConfigurationLoader.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\config;

use jacknoordhuis\chatchannels\config\exception\ConfigurationException;
use jacknoordhuis\chatchannels\event\handle\PlayerSessionHandler;
use jacknoordhuis\chatchannels\session\provider\JsonSessionProvider;
use jacknoordhuis\chatchannels\session\provider\NullSessionProvider;
use jacknoordhuis\chatchannels\session\provider\YamlSessionProvider;

class SettingsConfigurationLoader extends ConfigurationLoader {

	protected function onLoad(array $data) : void {
		$general = $data["general"];

		$this->getPlugin()->getChannelManager()->setDefaultChannel(strtolower($general["default-channel"] ?? ""));

		$this->loadSessionDriver($general["session-driver"]);
	}

	protected function loadSessionDriver(array $driver) : void  {
		$this->loadSessionProvider(strtolower($driver["provider"] ?? "null"));
		$this->getPlugin()->getEventManager()->registerHandler(new PlayerSessionHandler());
	}

	protected function loadSessionProvider(string $provider) : void {
		$manager = $this->getPlugin()->getSessionManager();
		switch($provider) {
			case "yaml":
				$manager->setProvider(new YamlSessionProvider($manager));
				$this->getPlugin()->getLogger()->debug("Using yaml session data provider.");
				break;
			case "json":
				$manager->setProvider(new JsonSessionProvider($manager));
				$this->getPlugin()->getLogger()->debug("Using json session data provider.");
				break;
			case "null":
				$manager->setProvider(new NullSessionProvider($manager));
				$this->getPlugin()->getLogger()->debug("Using null session data provider.");
				break;
			default:
				throw new ConfigurationException("Unknown provider specified for session driver: " . $provider);
			}
	}

}