<?php

/**
 * FileSessionProvider.php – PM-ChatChannels
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
use jacknoordhuis\chatchannels\session\RestorableSession;
use jacknoordhuis\chatchannels\session\SessionManager;
use jacknoordhuis\chatchannels\session\provider\storage\FileSessionStorage;

abstract class FileSessionProvider extends SessionProvider {

	/** @var string */
	protected $storageDirectory;

	public function __construct(SessionManager $manager) {
		$this->storageDirectory = $manager->getPlugin()->getDataFolder() . "sessions" . DIRECTORY_SEPARATOR;
		if(!file_exists($this->storageDirectory)) {
			mkdir($this->storageDirectory, 0777);
		}

		parent::__construct($manager);
	}

	/**
	 * @inheritDoc
	 */
	public function delete(Holder $holder, string $sessionName = "") : void {
		$storage = new FileSessionStorage($this->storageDirectory);
		if($storage->open($this->buildFilename($holder->getIdentifier(), $sessionName))) {
			$storage->destroy();
		}
	}

	/**
	 * Get the file extension used by this data provider.
	 *
	 * @return string
	 */
	abstract public function getFileExtension() : string;

	/**
	 * Build a session file name from the required parts.
	 *
	 * @param string $identifier
	 * @param string $sessionName
	 *
	 * @return string
	 */
	protected function buildFilename(string $identifier, string $sessionName) : string {
		return str_replace(" ", "_", $identifier . ($sessionName !== "" ? "_" . $sessionName : "")) . "." . $this->getFileExtension();
	}

}