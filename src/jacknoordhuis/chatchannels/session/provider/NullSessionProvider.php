<?php

/**
 * NullSessionProvider.php – PM-ChatChannels
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
use jacknoordhuis\chatchannels\session\TemporarySession;

class NullSessionProvider extends SessionProvider {

	/**
	 * @inheritDoc
	 */
	public function load(Holder $holder, string $sessionName = "") : void {
		$this->getManager()->addSession(new TemporarySession($holder));
	}

	/**
	 * @inheritDoc
	 */
	public function save(Holder $holder, array $data, string $sessionName = "") : void {
		return;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(Holder $holder, string $sessionName = "") : void {
		return;
	}

}