<?php

/**
 * Session.php – PM-ChatChannels
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

use jacknoordhuis\chatchannels\channel\Channel;
use jacknoordhuis\chatchannels\session\holder\Holder;

abstract class Session {

	/** @var \jacknoordhuis\chatchannels\session\holder\Holder */
	protected $holder;

	/** @var \jacknoordhuis\chatchannels\channel\subscription\Subscription[] */
	protected $subscriptions = [];

	public function __construct(Holder $holder) {
		$this->holder = $holder;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\session\holder\Holder
	 */
	public function getHolder() : Holder {
		return $this->holder;
	}

	/**
	 * @return string
	 */
	public function getUniqueKey() : string {
		return $this->holder->getTypeIdentifier() . ":" . $this->holder->getIdentifier();
	}

	/**
	 * @return \jacknoordhuis\chatchannels\channel\subscription\Subscription[]
	 */
	public function subscriptions() : array {
		return $this->subscriptions;
	}

	/**
	 * @param \jacknoordhuis\chatchannels\channel\Channel $channel
	 *
	 * @return bool
	 */
	public function hasSubscription(Channel $channel) : bool {
		return isset($this->subscriptions[$channel->getName()]);
	}

	/**
	 * Attempt to subscribe to a channel.
	 *
	 * @param \jacknoordhuis\chatchannels\channel\Channel $channel
	 *
	 * @return bool
	 */
	public function subscribe(Channel $channel) : bool {
		$this->subscriptions[$channel->getName()] = $this->holder->newSubscription();

		return true;
	}

	/**
	 * @param \jacknoordhuis\chatchannels\channel\Channel $channel
	 */
	public function unsubscribe(Channel $channel) : void {
		unset($this->subscriptions[$channel->getName()]);
	}

	/**
	 * @return array
	 */
	abstract public function toArray() : array;

	/**
	 * @param array $array
	 */
	abstract public function fromArray(array $array) : void;

	/**
	 * Helper method for building a sessions unique key for lookups in the session map.
	 *
	 * @param string $holderTypeId
	 * @param string $holderId
	 *
	 * @return string
	 */
	public static function buildKey(string $holderTypeId, string $holderId) : string {
		return $holderTypeId . ":" . $holderId;
	}

}