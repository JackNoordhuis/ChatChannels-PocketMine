<?php

/**
 * ISessionStorage.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\session\provider\storage;

interface ISessionStorage extends \Serializable {

	/**
	 * @param string $sessionId
	 *
	 * @return bool
	 */
	public function open(string $sessionId) : bool;

	/**
	 * @return string
	 */
	public function read() : string;

	/**
	 * @param string $sessionData
	 *
	 * @return bool
	 */
	public function write(string $sessionData) : bool;

	/**
	 * @return bool
	 */
	public function destroy() : bool;

}