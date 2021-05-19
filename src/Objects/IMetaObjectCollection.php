<?php declare(strict_types = 1);

/**
 * IMetaObjectCollection.php
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
 * Meta object collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends IteratorAggregate<string, IMetaObject>
 */
interface IMetaObjectCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $meta
	 */
	public function addMany(array $meta): void;

	/**
	 * @param IMetaObject $meta
	 * @param string $key
	 *
	 * @return void
	 */
	public function add(IMetaObject $meta, string $key): void;

	/**
	 * @param string $key
	 *
	 * @return IMetaObject|null
	 */
	public function get(string $key): ?IMetaObject;

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * @return Traversable<string, IMetaObject>
	 */
	public function getAll(): Traversable;

	/**
	 * @param string $key
	 *
	 * @return IMetaObject
	 */
	public function getMeta(string $key): IMetaObject;

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 * @return int
	 */
	public function count(): int;

}
