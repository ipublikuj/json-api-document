<?php declare(strict_types = 1);

/**
 * IResourceIdentifierCollection.php
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

/**
 * Resource identifiers collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends IteratorAggregate<int, IResourceIdentifier>
 */
interface IResourceIdentifierCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $identifiers
	 *
	 * @return void
	 */
	public function addMany(array $identifiers): void;

	/**
	 * @param IResourceIdentifier $identifier
	 *
	 * @return void
	 */
	public function add(IResourceIdentifier $identifier): void;

	/**
	 * Does the collection contain the supplied identifier?
	 *
	 * @param IResourceIdentifier $identifier
	 *
	 * @return bool
	 */
	public function has(IResourceIdentifier $identifier): bool;

	/**
	 * @param mixed[] $identifiers
	 *
	 * @return void
	 */
	public function setAll(array $identifiers): void;

	/**
	 * @return void
	 */
	public function clear(): void;

	/**
	 * Get the collection as an array
	 *
	 * @return IResourceIdentifier[]
	 */
	public function getAll(): array;

	/**
	 * Is the collection empty?
	 *
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 * Does every identifier in the collection match the supplied type/any of the supplied types?
	 *
	 * @param string|string[] $typeOrTypes
	 *
	 * @return bool
	 */
	public function isOnly($typeOrTypes): bool;

	/**
	 * Map the collection to an array of type keys and id values
	 *
	 * For example, this JSON structure:
	 *
	 * ```
	 * [
	 *  {"type": "foo", "id": "1"},
	 *  {"type": "foo", "id": "2"},
	 *  {"type": "bar", "id": "99"}
	 * ]
	 * ```
	 *
	 * Will map to:
	 *
	 * ```
	 * [
	 *  "foo" => ["1", "2"],
	 *  "bar" => ["99"]
	 * ]
	 * ```
	 *
	 * If the method call is provided with the an array `['foo' => 'FooModel', 'bar' => 'FoobarModel']`, then the
	 * returned mapped array will be:
	 *
	 * ```
	 * [
	 *  "FooModel" => ["1", "2"],
	 *  "FoobarModel" => ["99"]
	 * ]
	 * ```
	 *
	 * @param string[]|null $typeMap if an array, map the identifier types to the supplied types.
	 *
	 * @return mixed
	 */
	public function map(?array $typeMap = null);

	/**
	 * Get an array of the ids of each identifier in the collection
	 *
	 * @return string[]
	 */
	public function getIds(): array;

}
