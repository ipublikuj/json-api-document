<?php declare(strict_types = 1);

/**
 * IRelationshipCollection.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.0.1
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument\Objects;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Relationships collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends IteratorAggregate<string, IRelationship<string, IStandardObject>>
 */
interface IRelationshipCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $relationships
	 */
	public function addMany(array $relationships): void;

	/**
	 * @param IRelationship $relationship
	 * @param string $key
	 *
	 * @return void
	 *
	 * @phpstan-param IRelationship<string, IStandardObject> $relationship
	 */
	public function add(IRelationship $relationship, string $key): void;

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * Get a traversable object of keys to relationship objects
	 *
	 * This iterator will return all keys with values cast to `IRelationship` objects
	 *
	 * @return Traversable<string, IRelationship<string, IStandardObject>>
	 */
	public function getAll(): Traversable;

	/**
	 * @param string $key
	 *
	 * @return IRelationship
	 *
	 * @phpstan-return IRelationship<string, IStandardObject>
	 */
	public function getRelationship(string $key): IRelationship;

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

}
