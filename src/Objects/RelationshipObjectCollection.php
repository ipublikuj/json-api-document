<?php declare(strict_types = 1);

/**
 * RelationshipObjectCollection.php
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
 * Relationship object collection
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class RelationshipObjectCollection implements IRelationshipObjectCollection
{

	/**
	 * @var mixed[]

	 * @phpstan-var Array<string, IRelationshipObject>
	 */
	private array $stack = [];

	/**
	 * @param Objects\IStandardObject|null $relationshipObject
	 *
	 * @return IRelationshipObjectCollection
	 *
	 * @phpstan-return IRelationshipObjectCollection<string, IRelationshipObject>
	 */
	public static function create(?Objects\IStandardObject $relationshipObject): IRelationshipObjectCollection
	{
		if ($relationshipObject === null) {
			return new self([]);
		}

		$data = [];

		foreach ($relationshipObject->keys() as $key) {
			$relationship = $relationshipObject->get($key);

			if ($relationship instanceof Objects\IStandardObject) {
				$data[$key] = new RelationshipObject($relationship);
			}
		}

		return new self($data);
	}

	/**
	 * @param mixed[] $relationship
	 */
	public function __construct(array $relationship = [])
	{
		$this->addMany($relationship);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $relationship): void
	{
		foreach ($relationship as $key => $item) {
			if (!$item instanceof IRelationshipObject || !is_string($key)) {
				throw new Exceptions\InvalidArgumentException('Expecting only relationship objects with keys.');
			}

			$this->add($item, $key);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IRelationshipObject $relationship, string $key): void
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
	 */
	public function get(string $key): IRelationshipObject
	{
		if (!$this->has($key)) {
			throw new Exceptions\RuntimeException(sprintf('Relationship member "%s" is not present.', $key));
		}

		return $this->stack[$key];
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<string, IRelationshipObject>
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
			yield $key => $this->get($key);
		}
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
