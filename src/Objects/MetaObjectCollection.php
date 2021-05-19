<?php declare(strict_types = 1);

/**
 * MetaObjectCollection.php
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
 * Meta object collection
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class MetaObjectCollection implements IMetaObjectCollection
{

	/** @var Array<string, IMetaObject> */
	private array $stack = [];

	/**
	 * @param Objects\IStandardObject|null $metaObject
	 *
	 * @return IMetaObjectCollection<string, IMetaObject>
	 */
	public static function create(?Objects\IStandardObject $metaObject): IMetaObjectCollection
	{
		if ($metaObject === null) {
			return new self([]);
		}

		$data = [];

		foreach ($metaObject->keys() as $key) {
			$meta = $metaObject->get($key);

			if (is_string($meta) || is_numeric($meta) || is_array($meta)) {
				$data[$key] = new MetaObject($meta);
			}
		}

		return new self($data);
	}

	/**
	 * @param mixed[] $meta
	 */
	public function __construct(array $meta = [])
	{
		$this->addMany($meta);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $meta): void
	{
		foreach ($meta as $key => $item) {
			if (!$item instanceof IMetaObject || !is_string($key)) {
				throw new Exceptions\InvalidArgumentException('Expecting only meta objects with keys.');
			}

			$this->add($item, $key);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IMetaObject $meta, string $key): void
	{
		if (!$this->has($key)) {
			$this->stack[$key] = $meta;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function get(string $key): ?IMetaObject
	{
		return $this->has($key) ? $this->stack[$key] : null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(string $key): bool
	{
		return array_key_exists($key, $this->stack);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<string, IMetaObject>
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
		foreach (array_keys($this->stack) as $key) {
			yield $key => $this->getMeta($key);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMeta(string $key): IMetaObject
	{
		if (!$this->has($key)) {
			throw new Exceptions\RuntimeException(sprintf('Meta member "%s" is not present.', $key));
		}

		return $this->stack[$key];
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
