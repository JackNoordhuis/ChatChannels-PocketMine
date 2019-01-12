<?php

/**
 * PlayerSessionHolder.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\session\holder;

use jacknoordhuis\chatchannels\channel\subscription\PlayerSubscription;
use jacknoordhuis\chatchannels\channel\subscription\Subscription;
use jacknoordhuis\chatchannels\session\SessionManager;
use pocketmine\Player;
use pocketmine\Server;

class PlayerSessionHolder implements Holder {

	/** @var \jacknoordhuis\chatchannels\session\SessionManager */
	private $manager;

	/** @var string */
	protected $name;

	/** @var string */
	protected $uuid;

	public const HOLDER_IDENTIFIER = "player";

	public function __construct(Player $player) {
		$this->name = $player->getLowerCaseName();
		$this->uuid = $player->getUniqueId()->toString();
	}

	/**
	 * @inheritdoc
	 */
	public function getManager() : SessionManager {
		return $this->manager;
	}

	/**
	 * @inheritdoc
	 */
	public function setManager(SessionManager $manager) : void {
		$this->manager = $manager;
	}

	/**
	 * @inheritdoc
	 */
	public function getTypeIdentifier() : string {
		return self::HOLDER_IDENTIFIER;
	}

	/**
	 * @inheritdoc
	 */
	public function getIdentifier() : string {
		return $this->name;
	}

	/**
	 * @return PlayerSubscription|Subscription
	 */
	public function newSubscription() : Subscription {
		return new PlayerSubscription();
	}

	/**
	 * @return \pocketmine\Player|null
	 */
	public function getPlayer() : ?Player {
		return $this->manager->getPlugin()->getPlayerUuidMap()->get($this->uuid) ?? Server::getInstance()->getPlayer($this->name);
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
	public function getUuid() : string {
		return $this->uuid;
	}

}