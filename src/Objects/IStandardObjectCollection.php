<?php declare(strict_types = 1);

/**
 * IStandardObjectCollection.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.2.0
 *
 * @date           18.05.21
 */

namespace IPub\JsonAPIDocument\Objects;

use Countable;
use IteratorAggregate;

/**
 * Standard objects collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @phpstan-extends IteratorAggregate<int, IStandardObject<string, mixed>>
 */
interface IStandardObjectCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $objects
	 *
	 * @return void
	 */
	public function addMany(array $objects): void;

	/**
	 * @param IStandardObject $object
	 *
	 * @return void
	 *
	 * @phpstan-param IStandardObject<string, mixed> $object
	 */
	public function add(IStandardObject $object): void;

	/**
	 * @param IStandardObject $object
	 *
	 * @return bool
	 *
	 * @phpstan-param IStandardObject<string, mixed> $object
	 */
	public function has(IStandardObject $object): bool;

	/**
	 * @return IStandardObject[]
	 *
	 * @phpstan-return Array<int, IStandardObject<string, mixed>>
	 */
	public function getAll(): array;

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

}
