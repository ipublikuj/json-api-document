<?php
/**
 * IRelationships.php
 *
 * @copyright      More in license.md
 * @license        https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIObject!
 * @subpackage     Objects
 * @since          1.0.0
 *
 * @date           05.05.18
 */

declare(strict_types = 1);

namespace IPub\JsonAPIObject\Objects;

use CloudCreativity\Utils\Object\StandardObjectInterface;

use IPub\JsonAPIObject\Exceptions;

/**
 * Relationships collection interface
 *
 * @package        iPublikuj:JsonAPIObject!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
interface IRelationships extends StandardObjectInterface
{
	/**
	 * Get a traversable object of keys to relationship objects
	 *
	 * This iterator will return all keys with values cast to `IRelationship` objects
	 *
	 * @return \Traversable
	 */
	public function getAll() : \Traversable;

	/**
	 * @param string $key
	 *
	 * @return IRelationship
	 *
	 * @throws Exceptions\RuntimeException if the key is not present, or is not an object
	 */
	public function getRelationship(string $key) : IRelationship;
}
