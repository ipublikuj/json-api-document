<?php declare(strict_types = 1);

/**
 * ResourceObjectCollection.php
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

use ArrayIterator;
use IPub\JsonAPIDocument\Exceptions;
use SplObjectStorage;

/**
 * Resource objects collection
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceObjectCollection implements IResourceObjectCollection
{

	/** @var SplObjectStorage<IResourceObject, null> */
	private SplObjectStorage $stack;

	/**
	 * @param mixed[] $resources
	 *
	 * @return IResourceObjectCollection
	 *
	 * @phpstan-return IResourceObjectCollection<int, IResourceObject<string, IStandardObject>>
	 */
	public static function create(array $resources): IResourceObjectCollection
	{
		$resources = array_map(function ($resource): IResourceObject {
			return ($resource instanceof IResourceObject) ? $resource : new ResourceObject($resource);
		}, $resources);

		return new self($resources);
	}

	/**
	 * @param mixed[] $resources
	 */
	public function __construct(array $resources = [])
	{
		$this->stack = new SplObjectStorage();

		$this->addMany($resources);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $resources): void
	{
		foreach ($resources as $resource) {
			if (!$resource instanceof IResourceObject) {
				throw new Exceptions\InvalidArgumentException('Expecting only resource objects.');
			}

			$this->add($resource);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IResourceObject $resource): void
	{
		if (!$this->has($resource)) {
			$this->stack->attach($resource);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(IResourceObject $resource): bool
	{
		return $this->stack->contains($resource);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<int, IResourceObject<string, IStandardObject>>
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->getAll());
	}

	/**
	 * {@inheritDoc}
	 */
	public function get(IResourceIdentifier $identifier): IResourceObject
	{
		foreach ($this->getAll() as $resource) {
			if ($identifier->isSame($resource->getIdentifier())) {
				return $resource;
			}
		}

		throw new Exceptions\RuntimeException('No matching resource in collection: ' . $identifier->toString());
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAll(): array
	{
		return iterator_to_array($this->stack);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifiers(): IResourceIdentifierCollection
	{
		$collection = new ResourceIdentifierCollection();

		foreach ($this->getAll() as $resource) {
			$collection->add($resource->getIdentifier());
		}

		return $collection;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isEmpty(): bool
	{
		return $this->stack->count() === 0;
	}

	/**
	 * {@inheritDoc}
	 */
	public function count(): int
	{
		return $this->stack->count();
	}

}
