<?php

/**
 * YamlChannelProvider.php – PM-ChatChannels
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

use function yaml_parse;

class YamlChannelProvider extends FileChannelProvider {

	public const FILE_EXTENSION = "yml";

	/**
	 * @inheritDoc
	 */
	protected function decode(string $encoded) : array {
		return yaml_parse($encoded);
	}

}