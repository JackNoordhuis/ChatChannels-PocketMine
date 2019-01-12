<?php

/**
 * Channel.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\channel;

class Channel {

	/**
	 * Helper method to create a new channel instance.
	 *
	 * @param \jacknoordhuis\chatchannels\channel\ChannelManager $manager
	 * @param string $name
	 * @param string $format
	 * @param bool $noFormat
	 *
	 * @return \jacknoordhuis\chatchannels\channel\Channel
	 */
	public static function create(ChannelManager $manager, string $name, string $format, bool $noFormat = false) : Channel {
		$channel = new Channel($manager);
		$channel->name = $name;
		$channel->setFormat($format);
		$channel->noFormat = $noFormat;

		return $channel;
	}

	/** @var \jacknoordhuis\chatchannels\channel\ChannelManager */
	private $manager;

	/** @var \jacknoordhuis\chatchannels\channel\subscription\Subscription[] */
	protected $subscribers = [];

	/** @var string */
	protected $name = "";

	/** @var string */
	protected $format;

	/** @var bool */
	protected $noFormat = true;

	public function __construct(ChannelManager $manager) {
		$this->manager = $manager;
	}

	/**
	 * @return string
	 */
	public function getName() : string {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getFormat() : string {
		return $this->format;
	}

	/**
	 * @param string $format
	 */
	public function setFormat(string $format) : void {
		$this->format = $format;
	}

	/**
	 * @return bool
	 */
	public function hasNoFormat() : bool {
		return $this->noFormat;
	}

}