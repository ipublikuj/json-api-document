<?php declare(strict_types = 1);

/**
 * IResourceObjectCollection.php
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
use IPub\JsonAPIDocument\Exceptions;
use IteratorAggregate;

/**
 * Resource objects collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends IteratorAggregate<int, IResourceObject<string, IStandardObject>>
 */
interface IResourceObjectCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $resources
	 *
	 * @return void
	 */
	public function addMany(array $resources): void;

	/**
	 * @param IResourceObject $resource
	 *
	 * @return void
	 *
	 * @phpstan-param IResourceObject<string, IStandardObject> $resource
	 */
	public function add(IResourceObject $resource): void;

	/**
	 * @param IResourceObject $resource
	 *
	 * @return bool
	 *
	 * @phpstan-param IResourceObject<string, IStandardObject> $resource
	 */
	public function has(IResourceObject $resource): bool;

	/**
	 * @param IResourceIdentifier $identifier
	 *
	 * @return IResourceObject
	 *
	 * @throws Exceptions\RuntimeException if the collection does not contain a resource that matches the supplied identifier
	 *
	 * @phpstan-return IResourceObject<string, IStandardObject>
	 */
	public function get(IResourceIdentifier $identifier): IResourceObject;

	/**
	 * @return IResourceObject[]
	 *
	 * @phpstan-return Array<int, IResourceObject<string, IStandardObject>>
	 */
	public function getAll(): array;

	/**
	 * @return IResourceIdentifierCollection
	 *
	 * @phpstan-return IResourceIdentifierCollection<IResourceIdentifier>
	 */
	public function getIdentifiers(): IResourceIdentifierCollection;

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

}
