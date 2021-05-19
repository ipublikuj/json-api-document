<?php declare(strict_types = 1);

/**
 * InvalidArgumentException.php
 *
 * @copyright      More in LICENSE.md
 * @license        https://www.ipublikuj.eu
 * @author         Adam Kadlec https://www.ipublikuj.eu
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Exceptions
 * @since          0.0.1
 *
 * @date           12.05.17
 */

namespace IPub\JsonAPIDocument\Exceptions;

use InvalidArgumentException as PHPInvalidArgumentException;

class InvalidArgumentException extends PHPInvalidArgumentException implements IException
{

}
