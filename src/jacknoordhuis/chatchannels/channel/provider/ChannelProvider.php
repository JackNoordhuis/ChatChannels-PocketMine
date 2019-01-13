<?php

/**
 * ChannelProvider.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\channel\provider;

use jacknoordhuis\chatchannels\channel\ChannelManager;

abstract class ChannelProvider {

	/** @var \jacknoordhuis\chatchannels\channel\ChannelManager */
	private $manager;

	/**
	 * @return \jacknoordhuis\chatchannels\channel\ChannelManager
	 */
	public function getManager() : ChannelManager {
		return $this->manager;
	}

	/**
	 * @param \jacknoordhuis\chatchannels\channel\ChannelManager $manager
	 */
	public function setManager(ChannelManager $manager) : void {
		$this->manager = $manager;
	}

	/**
	 * Load all the channels from the data provider.
	 */
	abstract public function load() : void;

}