<?php declare(strict_types = 1);

/**
 * ResourceIdentifierCollection.php
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
use IPub\JsonAPIDocument;
use IPub\JsonAPIDocument\Exceptions;
use IPub\JsonAPIDocument\Objects;

/**
 * Resource identifier object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceIdentifierCollection implements IResourceIdentifierCollection
{

	/** @var IResourceIdentifierObject[] */
	private array $stack;

	/**
	 * @param mixed[] $input
	 *
	 * @return IResourceIdentifierCollection<int, IResourceIdentifierObject>
	 */
	public static function create(array $input): IResourceIdentifierCollection
	{
		$collection = new self();

		foreach ($input as $value) {
			if (
				$value instanceof Objects\IStandardObject
				&& $value->has(JsonAPIDocument\IDocument::KEYWORD_TYPE)
				&& $value->has(JsonAPIDocument\IDocument::KEYWORD_ID)
				&& is_string($value->get(JsonAPIDocument\IDocument::KEYWORD_TYPE))
				&& is_string($value->get(JsonAPIDocument\IDocument::KEYWORD_ID))
			) {
				$collection->add(new ResourceIdentifierObject($value));
			}
		}

		return $collection;
	}

	/**
	 * @param mixed[] $identifiers
	 */
	public function __construct(array $identifiers = [])
	{
		$this->stack = [];

		$this->addMany($identifiers);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $identifiers): void
	{
		foreach ($identifiers as $identifier) {
			if (!$identifier instanceof IResourceIdentifierObject) {
				throw new Exceptions\InvalidArgumentException('Expecting only resource identifier objects.');
			}

			$this->add($identifier);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IResourceIdentifierObject $identifier): void
	{
		if (!$this->has($identifier)) {
			$this->stack[] = $identifier;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(IResourceIdentifierObject $identifier): bool
	{
		return in_array($identifier, $this->stack, true);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<int, IResourceIdentifierObject>
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->getAll());
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
	public function count(): int
	{
		return count($this->stack);
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
	public function isOnly($typeOrTypes): bool
	{
		foreach ($this->stack as $identifier) {
			if (!$identifier->isType($typeOrTypes)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function map(?array $typeMap = null)
	{
		$ret = [];

		foreach ($this->stack as $identifier) {
			$key = is_array($typeMap) ? $identifier->mapType($typeMap) : $identifier->getType();

			if (!isset($ret[$key])) {
				$ret[$key] = [];
			}

			$ret[$key][] = $identifier->getId();
		}

		return $ret;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIds(): array
	{
		$ids = [];

		foreach ($this->stack as $identifier) {
			$ids[] = $identifier->getId();
		}

		return $ids;
	}

}
