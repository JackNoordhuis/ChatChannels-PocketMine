<?php

/**
 * FileChannelProvider.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\channel\provider;

use jacknoordhuis\chatchannels\channel\provider\storage\FileChannelStorage;
use jacknoordhuis\chatchannels\config\ChannelsConfigurationLoader;
use jacknoordhuis\chatchannels\config\exception\ConfigurationException;

abstract class FileChannelProvider extends ChannelProvider {

	/** @var string */
	protected $storageDirectory;

	public const FILE_NAME = "Channels";

	public const FILE_EXTENSION = "unknown";

	/**
	 * Get the file extension used by this data provider.
	 *
	 * @return string
	 */
	public function getFileExtension() : string {
		return static::FILE_EXTENSION;
	}

	/**
	 * @inheritDoc
	 */
	public function load() : void {
		$storage = new FileChannelStorage($this->getManager()->getPlugin()->getDataFolder());
		$this->getManager()->getPlugin()->saveResource($file = $this->buildFilename());
		if($storage->open($file)) {
			new ChannelsConfigurationLoader($this->getManager(), $this->decode($storage->read()));
		} else {
			throw new ConfigurationException("Missing channels configuration file: " . $file);
		}
	}

	/**
	 * Decode the serialized channel data.
	 *
	 * @param string $encoded
	 *
	 * @return array
	 */
	abstract protected function decode(string $encoded) : array;

	/**
	 * Build a channels configuration file name from the required parts.
	 *
	 * @return string
	 */
	protected function buildFilename() : string {
		return self::FILE_NAME . "." . $this->getFileExtension();
	}

}