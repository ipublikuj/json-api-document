<?php declare(strict_types = 1);

/**
 * IRelationshipObjectCollection.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.2.0
 *
 * @date           19.05.21
 */

namespace IPub\JsonAPIDocument\Objects;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Relationship object collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends IteratorAggregate<string, IRelationshipObject>
 */
interface IRelationshipObjectCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $relationship
	 */
	public function addMany(array $relationship): void;

	/**
	 * @param IRelationshipObject $relationship
	 * @param string $key
	 *
	 * @return void
	 */
	public function add(IRelationshipObject $relationship, string $key): void;

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * @param string $key
	 *
	 * @return IRelationshipObject
	 */
	public function get(string $key): IRelationshipObject;

	/**
	 * @return Traversable<string, IRelationshipObject>
	 */
	public function getAll(): Traversable;

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 * @return int
	 */
	public function count(): int;

}
