<?php declare(strict_types = 1);

/**
 * ResourceObjectCollection.php
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

use ArrayIterator;
use IPub\JsonAPIDocument\Exceptions;
use IPub\JsonAPIDocument\Objects;
use Traversable;

/**
 * Resource object collection
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceObjectCollection implements IResourceObjectCollection
{

	/**
	 * @var mixed[]
	 *
	 * @phpstan-var Array<int, IResourceObject>
	 */
	private array $stack = [];

	/**
	 * @param mixed[] $resourceArray
	 *
	 * @return IResourceObjectCollection
	 *
	 * @phpstan-return IResourceObjectCollection<int, IResourceObject>
	 */
	public static function create(array $resourceArray): IResourceObjectCollection
	{
		$data = [];

		foreach ($resourceArray as $resource) {
			if ($resource instanceof Objects\IStandardObject) {
				$data[] = new ResourceObject($resource);
			}
		}

		return new self($data);
	}

	/**
	 * @param mixed[] $resource
	 */
	public function __construct(array $resource = [])
	{
		$this->addMany($resource);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $resource): void
	{
		foreach ($resource as $key => $item) {
			if (!$item instanceof IResourceObject) {
				throw new Exceptions\InvalidArgumentException('Expecting only resource objects with keys.');
			}

			$this->add($item);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IResourceObject $resource): void
	{
		if (!$this->has($resource)) {
			$this->stack[] = $resource;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(IResourceObject $resource): bool
	{
		return in_array($resource, $this->stack, true);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<int, IResourceObject>
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->stack);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAll(): Traversable
	{
		return $this->getIterator();
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

}
