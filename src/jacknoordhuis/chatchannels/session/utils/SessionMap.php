<?php

/**
 * SessionMap.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\session\utils;

use jacknoordhuis\chatchannels\session\Session;

class SessionMap {

	/** @var \jacknoordhuis\chatchannels\session\Session[] */
	protected $map = [];

	/**
	 * @param \jacknoordhuis\chatchannels\session\Session $session
	 * @param string $key
	 */
	public function add(Session $session, string $key) : void {
		$this->map[$key] = $session;
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key) : bool {
		return isset($this->map[$key]);
	}

	/**
	 * @param string $key
	 *
	 * @return \jacknoordhuis\chatchannels\session\Session|null
	 */
	public function get(string $key) : ?Session {
		return $this->map[$key] ?? null;
	}

	/**
	 * @param string $key
	 */
	public function remove(string $key) : void {
		unset($this->map[$key]);
	}

	public function destroy() : void {
		$this->map = [];
	}

}