<?php declare(strict_types = 1);

/**
 * RuntimeException.php
 *
 * @copyright      More in LICENSE.md
 * @license        https://www.ipublikuj.eu
 * @author         Adam Kadlec https://www.ipublikuj.eu
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Exceptions
 * @since          0.0.1
 *
 * @date           06.05.18
 */

namespace IPub\JsonAPIDocument\Exceptions;

use RuntimeException as PHPRuntimeException;

class RuntimeException extends PHPRuntimeException implements IException
{

}
