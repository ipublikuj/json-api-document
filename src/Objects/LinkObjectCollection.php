<?php declare(strict_types = 1);

/**
 * LinkObjectCollection.php
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
 * Link object collection
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class LinkObjectCollection implements ILinkObjectCollection
{

	/**
	 * @var mixed[]
	 *
	 * @phpstan-var Array<string, ILinkObject|string>
	 */
	private array $stack = [];

	/**
	 * @param Objects\IStandardObject|null $linkObject
	 *
	 * @return ILinkObjectCollection
	 *
	 * @phpstan-return ILinkObjectCollection<string, ILinkObject|string>
	 */
	public static function create(?Objects\IStandardObject $linkObject): ILinkObjectCollection
	{
		if ($linkObject === null) {
			return new self([]);
		}

		$data = [];

		foreach ($linkObject->keys() as $key) {
			$link = $linkObject->get($key);

			if (is_string($link)) {
				$data[$key] = $link;

			} elseif ($link instanceof Objects\IStandardObject) {
				$data[$key] = new LinkObject($link);
			}
		}

		return new self($data);
	}

	/**
	 * @param mixed[] $link
	 */
	public function __construct(array $link = [])
	{
		$this->addMany($link);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $link): void
	{
		foreach ($link as $key => $item) {
			if ((!$item instanceof ILinkObject && !is_string($item)) || !is_string($key)) {
				throw new Exceptions\InvalidArgumentException('Expecting only link objects with keys.');
			}

			$this->add($item, $key);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add($link, string $key): void
	{
		if (!$this->has($key)) {
			$this->stack[$key] = $link;
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
	public function get(string $key)
	{
		if (!$this->has($key)) {
			throw new Exceptions\RuntimeException(sprintf('Link member "%s" is not present.', $key));
		}

		return $this->stack[$key];
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<string, ILinkObject|string>
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->stack);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return Traversable<string, ILinkObject|string>
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
