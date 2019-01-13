<?php

/**
 * FileChannelStorage.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\channel\provider\storage;

class FileChannelStorage implements IChannelStorage {

	/** @var string */
	protected $path;

	/** @var string */
	protected $file;

	/** @var string */
	protected $filename;

	public function __construct(string $path) {
		$this->path = $path;
	}

	/**
	 * @inheritDoc
	 */
	public function open(string $filename) : bool {
		$this->filename = $filename;
		$this->file = $this->path . $this->filename;
		if(file_exists($this->file)) {
			if(is_readable($this->file) and is_writable($this->file)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function read() : string {
		return file_get_contents($this->file);
	}

	/**
	 * @inheritDoc
	 */
	public function serialize() {
		return igbinary_serialize($this);
	}

	/**
	 * @inheritDoc
	 */
	public function unserialize($serialized) {
		return igbinary_unserialize($this);
	}

}