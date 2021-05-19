<?php declare(strict_types = 1);

/**
 * ErrorCollection.php
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

/**
 * Resource identifier object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ErrorCollection implements IErrorCollection
{

	/** @var IError[] */
	private array $stack;

	/**
	 * @param mixed[] $errors
	 *
	 * @return IErrorCollection
	 */
	public static function create(array $errors): IErrorCollection
	{
		$errors = array_map(function ($error): IError {
			return ($error instanceof IError) ? $error : new Error($error);
		}, $errors);

		return new self($errors);
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
			if (!$identifier instanceof IError) {
				throw new Exceptions\InvalidArgumentException('Expecting only identifier objects.');
			}

			$this->add($identifier);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(IError $identifier): void
	{
		if (!$this->has($identifier)) {
			$this->stack[] = $identifier;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(IError $identifier): bool
	{
		return in_array($identifier, $this->stack, true);
	}

	/**
	 * {@inheritDoc}
	 */
	public function setAll(array $identifiers): void
	{
		$this->clear();

		$this->addMany($identifiers);
	}

	/**
	 * {@inheritDoc}
	 */
	public function clear(): void
	{
		$this->stack = [];
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return ArrayIterator<int, IError>
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

}
