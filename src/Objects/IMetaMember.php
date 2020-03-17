<?php declare(strict_types = 1);

/**
 * IMetaMember.php
 *
 * @license        More in license.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          1.0.0
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument\Exceptions;

/**
 * Meta member interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IMetaMember
{

	/**
	 * Get the meta member of the object
	 *
	 * @return IStandardObject
	 *
	 * @throws Exceptions\RuntimeException if the meta member is present and is not an object
	 */
	public function getMeta(): IStandardObject;

	/**
	 * Does the object have meta?
	 *
	 * @return bool
	 */
	public function hasMeta(): bool;

}
