<?php

/**
 * Holder.php ChatChannels
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

namespace jacknoordhuis\chatchannels\session\holder;

use jacknoordhuis\chatchannels\channel\subscription\Subscription;
use jacknoordhuis\chatchannels\session\SessionManager;

interface Holder {

	/**
	 * @return \jacknoordhuis\chatchannels\session\SessionManager
	 */
	public function getManager() : SessionManager;

	/**
	 * @param \jacknoordhuis\chatchannels\session\SessionManager $manager
	 */
	public function setManager(SessionManager $manager) : void;

	/**
	 * @return string
	 */
	public function getTypeIdentifier() : string;

	/**
	 * @return string
	 */
	public function getIdentifier() : string;

	/**
	 * @return \jacknoordhuis\chatchannels\channel\subscription\Subscription
	 */
	public function newSubscription() : Subscription;

}