<?php declare(strict_types = 1);

/**
 * Relationships.php
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
use Traversable;

/**
 * Relationships
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class RelationshipCollection implements IRelationshipCollection
{

	/** @var Array<string, IRelationship<string, IStandardObject>> */
	private array $stack = [];

	/**
	 * @param IStandardObject $relationships
	 *
	 * @return IRelationshipCollection
	 *
	 * @phpstan-param IStandardObject<string, mixed> $relationships
	 *
	 * @phpstan-return IRelationshipCollection<string, IRelationship<string, IStandardObject>>
	 */
	public static function create(IStandardObject $relationships): IRelationshipCollection
	{
		$data = [];

		foreach ($relationships->keys() as $key) {
			$data[$key] = new Relationship($relationships->get($key));
		}

		return new self($data);
	}

	/**
	 * @param mixed[] $relationships
	 */
	public function __construct(array $relationships = [])
	{
		$this->addMany($relationships);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $relationships): void
	{
		foreach ($relationships as $key => $relationship) {
			if (!$relationship instanceof IRelationship || !is_string($key)) {
				throw new Exceptions\InvalidArgumentException('Expecting only relationship objects.');
			}

			$this->add($relationship, $key);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IRelationship $relationship, string $key): void
	{
		if (!$this->has($key)) {
			$this->stack[$key] = $relationship;
		}
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
	 * @phpstan-return ArrayIterator<string, IRelationship<string, IStandardObject>>
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator(array_map(function (IRelationship $relationship): IRelationship {
			return $relationship;
		}, $this->stack));
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAll(): Traversable
	{
		foreach (array_keys($this->stack) as $key) {
			yield $key => $this->getRelationship($key);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationship(string $key): IRelationship
	{
		if (!$this->has($key)) {
			throw new Exceptions\RuntimeException(sprintf('Relationship member "%s" is not present.', $key));
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
