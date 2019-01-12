<?php

/**
 * ChannelManager.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\channel;

use jacknoordhuis\chatchannels\ChatChannels;

class ChannelManager {

	/** @var \jacknoordhuis\chatchannels\ChatChannels */
	private $plugin;

	/** @var \jacknoordhuis\chatchannels\channel\Channel[] */
	protected $channels = [];

	/** @var string|null */
	protected $defaultChannel = "";

	public function __construct(ChatChannels $plugin) {
		$this->plugin = $plugin;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\ChatChannels
	 */
	public function getPlugin() : ChatChannels {
		return $this->plugin;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\channel\Channel[]
	 */
	public function getChannels() : array {
		return $this->channels;
	}

	/**
	 * @param string $name
	 *
	 * @return \jacknoordhuis\chatchannels\channel\Channel|null
	 */
	public function getChannel(string $name) : ?Channel {
		return $this->channels[$name] ?? null;
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function hasChannel(string $name) : bool {
		return isset($this->channels[strtolower($name)]);
	}

	/**
	 * @param \jacknoordhuis\chatchannels\channel\Channel $channel
	 */
	public function addChannel(Channel $channel) : void {
		if($this->hasChannel($name = strtolower($channel->getName()))) {
			throw new \RuntimeException("Tried to register a channel with the same name as an existing channel. Name: " . $name);
		}

		$this->channels[$name] = $channel;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\channel\Channel|null
	 */
	public function getDefaultChannel() : ?Channel {
		return $this->channels[$this->defaultChannel] ?? null;
	}

	/**
	 * @param string $name
	 */
	public function setDefaultChannel(string $name) : void {
		$this->defaultChannel = $name;
	}

}