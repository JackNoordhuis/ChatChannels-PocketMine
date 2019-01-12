<?php

/**
 * SessionManager.php – PM-ChatChannels
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

namespace jacknoordhuis\chatchannels\session;

use jacknoordhuis\chatchannels\ChatChannels;
use jacknoordhuis\chatchannels\session\holder\PlayerSessionHolder;
use jacknoordhuis\chatchannels\session\provider\SessionProvider;
use jacknoordhuis\chatchannels\session\utils\SessionMap;

class SessionManager {

	/** @var \jacknoordhuis\chatchannels\ChatChannels */
	private $plugin;

	/** @var \jacknoordhuis\chatchannels\session\provider\SessionProvider */
	protected $provider;

	/** @var SessionMap */
	protected $sessions;

	/** @var \jacknoordhuis\chatchannels\session\utils\SessionMap */
	protected $playerSessionName;

	/** @var \jacknoordhuis\chatchannels\session\utils\SessionMap */
	protected $playerSessionUuid;

	public function __construct(ChatChannels $plugin) {
		$this->plugin = $plugin;

		$this->sessions = new SessionMap();
		$this->playerSessionName = new SessionMap();
		$this->playerSessionUuid = new SessionMap();
	}

	/**
	 * @return \jacknoordhuis\chatchannels\ChatChannels
	 */
	public function getPlugin() : ChatChannels {
		return $this->plugin;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\session\provider\SessionProvider
	 */
	public function getProvider() : SessionProvider {
		return $this->provider;
	}

	/**
	 * @param \jacknoordhuis\chatchannels\session\provider\SessionProvider $provider
	 */
	public function setProvider(SessionProvider $provider) : void {
		$this->provider = $provider;
	}

	/**
	 * Add a session to all relevant maps.
	 *
	 * @param \jacknoordhuis\chatchannels\session\Session $session
	 */
	public function addSession(Session $session) : void {
		$holder = $session->getHolder();
		if($holder instanceof PlayerSessionHolder) {
			$this->playerSessionName->add($session, $holder->getName());
			$this->playerSessionName->add($session, $holder->getUuid());
		}

		if(!$this->sessions->has($key = $session->getUniqueKey())) {
			$this->sessions->add($session, $key);
		}

		$holder->setManager($this);
	}

	/**
	 * @return \jacknoordhuis\chatchannels\session\utils\SessionMap
	 */
	public function getSessions() : SessionMap {
		return $this->sessions;
	}

	/**
	 * @param \jacknoordhuis\chatchannels\session\Session $session
	 */
	public function removeSession(Session $session) : void {
		$holder = $session->getHolder();
		if($holder instanceof PlayerSessionHolder) {
			$this->playerSessionName->remove($holder->getName());
			$this->playerSessionUuid->remove($holder->getUuid());
		}

		$this->sessions->remove($session->getUniqueKey());
	}

	/**
	 * @return \jacknoordhuis\chatchannels\session\utils\SessionMap
	 */
	public function getPlayerSessionsName() : SessionMap {
		return $this->playerSessionName;
	}

	/**
	 * @return \jacknoordhuis\chatchannels\session\utils\SessionMap
	 */
	public function getPlayerSessionsUuid() : SessionMap {
		return $this->playerSessionName;
	}

}