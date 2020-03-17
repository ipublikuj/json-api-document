<?php declare(strict_types = 1);

/**
 * ResourceObjectCollection.php
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

use ArrayIterator;
use IPub\JsonAPIDocument\Exceptions;

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

	/** @var IResourceObject[] */
	private $stack = [];

	/**
	 * @param array $resources
	 *
	 * @return ResourceObjectCollection
	 */
	public static function create(array $resources)
	{
		$resources = array_map(function ($resource) {
			return ($resource instanceof IResourceObject) ? $resource : new ResourceObject($resource);
		}, $resources);

		return new self($resources);
	}

	/**
	 * @param array $resources
	 */
	public function __construct(array $resources = [])
	{
		$this->addMany($resources);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->stack);
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(IResourceIdentifier $identifier): bool
	{
		/** @var IResourceObject $resource */
		foreach ($this as $resource) {
			if ($identifier->isSame($resource->getIdentifier())) {
				return true;
			}
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get(IResourceIdentifier $identifier): IResourceObject
	{
		/** @var IResourceObject $resource */
		foreach ($this as $resource) {

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
		return $this->stack;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifiers(): IResourceIdentifierCollection
	{
		$collection = new ResourceIdentifierCollection;

		/** @var IResourceObject $resource */
		foreach ($this as $resource) {
			$collection->add($resource->getIdentifier());
		}

		return $collection;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isEmpty(): bool
	{
		return $this->stack === [];
	}

	/**
	 * {@inheritDoc}
	 */
	public function count(): int
	{
		return count($this->stack);
	}

	/**
	 * @param IResourceObject $resource
	 *
	 * @return void
	 */
	public function add(IResourceObject $resource): void
	{
		if (!$this->has($resource->getIdentifier())) {
			$this->stack[] = $resource;
		}
	}

	/**
	 * @param array $resources
	 *
	 * @return void
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

}
