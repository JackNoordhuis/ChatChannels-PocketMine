<?php

/**
 * NullSessionStorage.php – PM-ChatChannels
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

class NullSessionStorage implements ISessionStorage {

	/**
	 * {@inheritdoc}
	 */
	public function open(string $sessionId) : bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function read() : string {
		return "";
	}

	/**
	 * {@inheritdoc}
	 */
	public function write(string $sessionData) : bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function destroy() : bool {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function serialize() {
		return "";
	}

	/**
	 * @inheritDoc
	 */
	public function unserialize($serialized) {
		return;
	}


}