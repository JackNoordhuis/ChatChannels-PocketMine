<?php

/**
 * JsonSessionProvider.php - PM-ChatChannels
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
use jacknoordhuis\chatchannels\session\provider\storage\FileSessionStorage;
use jacknoordhuis\chatchannels\session\RestorableSession;

class JsonSessionProvider extends FileSessionProvider {

	const FILE_EXTENSION_JSON = "json";

	/**
	 * @inheritDoc
	 */
	public function getFileExtension() : string {
		return self::FILE_EXTENSION_JSON;
	}

	/**
	 * @inheritDoc
	 */
	public function load(Holder $holder, string $sessionName = "") : void {
		$session = new RestorableSession($holder);
		$storage = new FileSessionStorage($this->storageDirectory);
		if($storage->open($this->buildFilename($holder->getIdentifier(), $sessionName))) {
			$session->fromArray(json_decode($storage->read(), true));
		}

		$this->getManager()->addSession($session);
	}

	/**
	 * @inheritDoc
	 */
	public function save(Holder $holder, array $data, string $sessionName = "") : void {
		$storage = new FileSessionStorage($this->storageDirectory);
		$storage->open($this->buildFilename($holder->getIdentifier(), $sessionName));
		$storage->write(json_encode($data));
	}

}