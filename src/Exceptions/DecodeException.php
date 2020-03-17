<?php declare(strict_types = 1);

/**
 * DecodeException.php
 *
 * @copyright      More in license.md
 * @license        https://www.ipublikuj.eu
 * @author         Adam Kadlec https://www.ipublikuj.eu
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Exceptions
 * @since          1.0.0
 *
 * @date           17.04.20
 */

namespace IPub\JsonAPIDocument\Exceptions;

class DecodeException extends RuntimeException
{

	public function __construct()
	{
		return parent::__construct(json_last_error_msg(), json_last_error());
	}

}
