<?php
/**
 * InvalidArgumentException.php
 *
 * @copyright      More in license.md
 * @license        https://www.ipublikuj.eu
 * @author         Adam Kadlec https://www.ipublikuj.eu
 * @package        iPublikuj:JsonAPIObject!
 * @subpackage     Exceptions
 * @since          1.0.0
 *
 * @date           12.05.17
 */

declare(strict_types = 1);

namespace IPub\JsonAPIObject\Exceptions;

class InvalidArgumentException extends \Nette\InvalidArgumentException implements IException
{
}
