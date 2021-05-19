<?php declare(strict_types = 1);

/**
 * IErrorCollection.php
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

/**
 * Resource identifiers collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends IteratorAggregate<int, IError>
 */
interface IErrorCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $identifiers
	 *
	 * @return void
	 */
	public function addMany(array $identifiers): void;

	/**
	 * @param IError $identifier
	 *
	 * @return void
	 */
	public function add(IError $identifier): void;

	/**
	 * Does the collection contain the supplied identifier?
	 *
	 * @param IError $identifier
	 *
	 * @return bool
	 */
	public function has(IError $identifier): bool;

	/**
	 * @param mixed[] $identifiers
	 *
	 * @return void
	 */
	public function setAll(array $identifiers): void;

	/**
	 * @return void
	 */
	public function clear(): void;

	/**
	 * Get the collection as an array
	 *
	 * @return IError[]
	 */
	public function getAll(): array;

	/**
	 * Is the collection empty?
	 *
	 * @return bool
	 */
	public function isEmpty(): bool;

}
