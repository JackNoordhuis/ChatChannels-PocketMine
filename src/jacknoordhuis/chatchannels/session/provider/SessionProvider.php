<?php

/**
 * SessionProvider.php - PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\session\provider;

use jacknoordhuis\chatchannels\session\holder\Holder;
use jacknoordhuis\chatchannels\session\SessionManager;

abstract class SessionProvider {

	/** @var \jacknoordhuis\chatchannels\session\SessionManager */
	private $manager;

	public function __construct(SessionManager $manager) {
		$this->manager = $manager;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\session\SessionManager
	 */
	public function getManager() : SessionManager {
		return $this->manager;
	}

	/**
	 * Load a session from the data provider.
	 *
	 * @param Holder $holder
	 * @param string $sessionName
	 */
	abstract public function load(Holder $holder, string $sessionName = "") : void;

	/**
	 * Save a session to the data provider.
	 *
	 * @param \jacknoordhuis\chatchannels\session\holder\Holder $holder
	 * @param array $data
	 * @param string $sessionName
	 */
	abstract public function save(Holder $holder, array $data, string $sessionName = "") : void;

	/**
	 * Delete a stored session from the data provider.
	 *
	 * @param Holder $holder
	 * @param string $sessionName
	 */
	abstract public function delete(Holder $holder, string $sessionName = "") : void;

}