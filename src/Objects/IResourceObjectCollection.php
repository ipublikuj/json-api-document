<?php declare(strict_types = 1);

/**
 * IResourceObjectCollection.php
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
 * Resource object collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @phpstan-extends IteratorAggregate<int, IResourceObject>
 */
interface IResourceObjectCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $resource
	 */
	public function addMany(array $resource): void;

	/**
	 * @param IResourceObject $resource
	 *
	 * @return void
	 */
	public function add(IResourceObject $resource): void;

	/**
	 * @param IResourceObject $resource
	 *
	 * @return bool
	 */
	public function has(IResourceObject $resource): bool;

	/**
	 * @return Traversable
	 *
	 * @phpstan-return Traversable<int, IResourceObject>
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
