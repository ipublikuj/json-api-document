<?php declare(strict_types = 1);

/**
 * ILinkObjectCollection.php
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
 * Link object collection interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends IteratorAggregate<string, ILinkObject|string>
 */
interface ILinkObjectCollection extends IteratorAggregate, Countable
{

	/**
	 * @param mixed[] $link
	 */
	public function addMany(array $link): void;

	/**
	 * @param ILinkObject|string $link
	 * @param string $key
	 *
	 * @return void
	 */
	public function add($link, string $key): void;

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * @param string $key
	 *
	 * @return string|ILinkObject|null
	 */
	public function get(string $key);

	/**
	 * @return Traversable<string, ILinkObject|string>
	 */
	public function getAll(): Traversable;

	/**
	 * @param string $key
	 *
	 * @return ILinkObject|string
	 */
	public function getLink(string $key);

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 * @return int
	 */
	public function count(): int;

}
