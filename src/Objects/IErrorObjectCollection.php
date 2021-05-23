<?php declare(strict_types = 1);

/**
 * IErrorObjectCollection.php
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

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Error object collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @phpstan-extends IteratorAggregate<int, IErrorObject>
 */
interface IErrorObjectCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $error
	 */
	public function addMany(array $error): void;

	/**
	 * @param IErrorObject $error
	 *
	 * @return void
	 */
	public function add(IErrorObject $error): void;

	/**
	 * @param IErrorObject $error
	 *
	 * @return bool
	 */
	public function has(IErrorObject $error): bool;

	/**
	 * @return Traversable
	 *
	 * @phpstan-return Traversable<int, IErrorObject>
	 */
	public function getAll(): Traversable;

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 * @return int
	 */
	public function count(): int;

}
