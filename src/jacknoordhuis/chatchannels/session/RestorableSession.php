<?php

/**
 * RestorableSession.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\session;

use jacknoordhuis\chatchannels\channel\subscription\Subscription;
use jacknoordhuis\chatchannels\session\exception\SessionRestorationException;

class RestorableSession extends Session {

	/** @var string */
	protected $name;

	/**
	 * @return string
	 */
	public function getName() : string {
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function toArray() : array {
		return [
			"name" => $this->name,
			"subscriptions" => array_map(function(Subscription $subscription) {
				return $subscription->channel()->getName();
			}, $this->subscriptions),
		];
	}

	/**
	 * @param array $array
	 */
	public function fromArray(array $array) : void {
		$this->name = $array["name"];

		foreach($array["subscriptions"] as $channelName) {
			if(($channel = $this->holder->getManager()->getPlugin()->getChannelManager()->getChannel($channelName)) === null) {
				throw new SessionRestorationException("Cannot restore session due to missing channel: " . $channelName . ", id: " . $this->holder->getIdentifier());
			}

			$this->subscribe($channel);
		}
	}

}