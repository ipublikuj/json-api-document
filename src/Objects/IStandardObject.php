<?php declare(strict_types = 1);

/**
 * IStandardObject.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.0.1
 *
 * @date           17.03.20
 */

namespace IPub\JsonAPIDocument\Objects;

use Countable;
use JsonSerializable;
use stdClass;
use Traversable;

/**
 * Standard object interface
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 *
 * @extends Traversable<string, mixed>
 */
interface IStandardObject extends Traversable, Countable, JsonSerializable
{

	/**
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return string|int|float|mixed[]|IStandardObject<string, string|int|float|mixed[]|null>|null
	 */
	public function get(string $key, $default = null);

	/**
	 * @param string|string[] ...$keys
	 *
	 * @return Array<string|int|float|mixed[]|IStandardObject<string, string|int|float|mixed[]|null>>
	 */
	public function getMany(...$keys): array;

	/**
	 * @param string $key
	 * @param string|int|float|mixed[]|IStandardObject<string, string|int|float|mixed[]|null>|null $value
	 *
	 * @return IStandardObject<string, string|int|float|mixed[]|null>
	 */
	public function set(string $key, $value): IStandardObject;

	/**
	 * @param Array<string, string|int|float|mixed[]|IStandardObject<string, string|int|float|mixed[]|null>> $values
	 *
	 * @return IStandardObject<string, string|int|float|mixed[]|null>
	 */
	public function setMany(array $values): IStandardObject;

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * @param string[] ...$keys
	 *
	 * @return bool
	 */
	public function hasAny(...$keys): bool;

	/**
	 * @return string[]
	 */
	public function keys(): array;

	/**
	 * @return IStandardObject<string, string|int|float|mixed[]|null>
	 */
	public function copy(): IStandardObject;

	/**
	 * @param string[] ...$key
	 *
	 * @return IStandardObject<string, string|int|float|mixed[]|null>
	 */
	public function remove(...$key): IStandardObject;

	/**
	 * @return stdClass
	 */
	public function toStdClass(): stdClass;

	/**
	 * @return mixed[]
	 */
	public function toArray(): array;

}
