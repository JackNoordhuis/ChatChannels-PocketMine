<?php

/**
 * ChannelsConfigurationLoader.php PM-ChatChannels
 *
 * Copyright (C) 2018 Jack Noordhuis
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

use jacknoordhuis\chatchannels\channel\Channel;
use jacknoordhuis\chatchannels\channel\ChannelManager;
use jacknoordhuis\chatchannels\config\exception\ConfigurationException;
use pocketmine\utils\TextFormat;

class ChannelsConfigurationLoader extends ConfigurationLoader {

	/** @var string */
	protected $colorSymbol = null;

	/** @var string */
	protected $defaultFormat = null;

	public function onLoad(array $data) : void {
		$this->colorSymbol = $data["color-symbol"] ?? null;

		if($this->colorSymbol === null) {
			$this->defaultFormat = $data["default-format"] ?? null;
		} else {
			$this->defaultFormat = (($colorized = TextFormat::colorize($data["default-format"] ?? "")) === "" ? null : $colorized);
		}

		$this->loadChannels($data["channels"]);
	}

	protected function loadChannels(array $channels) : void {
		$manager = $this->getPlugin()->getChannelManager();

		foreach($channels as $index => $data) {
			try {
				$manager->addChannel($this->loadChannel($manager, $data));
			} catch(ConfigurationException $e) {
				$this->getPlugin()->getLogger()->notice($e->getMessage() . " " . (isset($data["name"]) ? "Channel: " . $data["name"] : "Channel Index: " . $index));
			} catch(\ArrayOutOfBoundsException $e) {
				$this->getPlugin()->getLogger()->notice("Missing required index for " . (isset($data["name"]) ? "Channel: " . $data["name"] : "Channel Index: " . $index));
				$this->getPlugin()->getLogger()->logException($e);
			}
		}
	}

	protected function loadChannel(ChannelManager $manager, array $data) : Channel {
		$noFormat = false;
		/** @var $format string|bool|null */
		if(($format = $data["format"] ?? null) === null) {
			if($this->defaultFormat === null) {
				throw new ConfigurationException("No format specified and no default format to fallback to");
			}

			$format = $this->defaultFormat;
		} else {
			if($format === true) {
				$format = $this->defaultFormat;
			} elseif($format === false) {
				$noFormat = true;
			} else {
				$format = TextFormat::colorize($format, $this->colorSymbol);
			}
		}

		return Channel::create($manager, $data["name"], $format, $noFormat);
	}

}