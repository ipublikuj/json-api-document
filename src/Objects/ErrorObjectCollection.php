<?php declare(strict_types = 1);

/**
 * ErrorObjectCollection.php
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
 * Error object collection
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ErrorObjectCollection implements IErrorObjectCollection
{

	/** @var Array<int, IErrorObject> */
	private array $stack = [];

	/**
	 * @param mixed[] $errorArray
	 *
	 * @return IErrorObjectCollection
	 *
	 * @phpstan-return IErrorObjectCollection<int, IErrorObject>
	 */
	public static function create(array $errorArray): IErrorObjectCollection
	{
		$data = [];

		foreach ($errorArray as $error) {
			if ($error instanceof Objects\IStandardObject) {
				$data[] = new ErrorObject($error);
			}
		}

		return new self($data);
	}

	/**
	 * @param mixed[] $error
	 */
	public function __construct(array $error = [])
	{
		$this->addMany($error);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addMany(array $error): void
	{
		foreach ($error as $item) {
			if (!$item instanceof IErrorObject) {
				throw new Exceptions\InvalidArgumentException('Expecting only error objects with keys.');
			}

			$this->add($item);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IErrorObject $error): void
	{
		if (!$this->has($error)) {
			$this->stack[] = $error;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(IErrorObject $error): bool
	{
		return in_array($error, $this->stack, true);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<int, IErrorObject>
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
