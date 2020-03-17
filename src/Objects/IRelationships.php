<?php declare(strict_types = 1);

/**
 * IRelationships.php
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
use Traversable;

/**
 * Relationships collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IRelationships extends IStandardObject
{

	/**
	 * Get a traversable object of keys to relationship objects
	 *
	 * This iterator will return all keys with values cast to `IRelationship` objects
	 *
	 * @return Traversable
	 */
	public function getAll(): Traversable;

	/**
	 * @param string $key
	 *
	 * @return IRelationship
	 *
	 * @throws Exceptions\RuntimeException if the key is not present, or is not an object
	 */
	public function getRelationship(string $key): IRelationship;

}
