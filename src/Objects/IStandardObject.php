<?php declare(strict_types = 1);

/**
 * IStandardObject.php
 *
 * @license        More in license.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          1.0.0
 *
 * @date           17.03.20
 */

namespace IPub\JsonAPIDocument\Objects;

use Countable;
use JsonSerializable;
use stdClass;
use Traversable;

interface IStandardObject extends Traversable, Countable, JsonSerializable
{

	/**
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return IStandardObject|mixed
	 */
	public function get(string $key, $default = null);

	/**
	 * @param string|string[] ...$keys
	 *
	 * @return mixed[]
	 */
	public function getProperties(...$keys): array;

	/**
	 * @param string|string[] ...$keys
	 *
	 * @return mixed[]
	 */
	public function getMany(...$keys): array;

	/**
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return self
	 */
	public function set(string $key, $value): IStandardObject;

	/**
	 * @param mixed[] $values
	 *
	 * @return IStandardObject
	 */
	public function setProperties(array $values): IStandardObject;

	/**
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return IStandardObject
	 */
	public function add(string $key, $value): IStandardObject;

	/**
	 * @param mixed[] $values
	 *
	 * @return IStandardObject
	 */
	public function addProperties(array $values): IStandardObject;

	/**
	 * @param string[] ...$keys
	 *
	 * @return bool
	 */
	public function has(...$keys): bool;

	/**
	 * @param string[] ...$keys
	 *
	 * @return bool
	 */
	public function hasAny(...$keys): bool;

	/**
	 * @param string[] ...$key
	 *
	 * @return IStandardObject
	 */
	public function remove(...$key): IStandardObject;

	/**
	 * @param string[] ...$keys
	 *
	 * @return IStandardObject
	 */
	public function reduce(...$keys): IStandardObject;

	/**
	 * @return IStandardObject
	 */
	public function copy(): IStandardObject;

	/**
	 * @return string[]
	 */
	public function keys(): array;

	/**
	 * @param string $currentKey
	 * @param string $newKey
	 *
	 * @return IStandardObject
	 */
	public function rename(string $currentKey, string $newKey): IStandardObject;

	/**
	 * @param mixed[] $mapping
	 *
	 * @return IStandardObject
	 */
	public function renameKeys(array $mapping): IStandardObject;

	/**
	 * @param callable $transform
	 * @param string[] $keys
	 *
	 * @return IStandardObject
	 */
	public function transform(callable $transform, ...$keys): IStandardObject;

	/**
	 * @param callable $transform
	 *
	 * @return IStandardObject
	 */
	public function transformKeys(callable $transform): IStandardObject;

	/**
	 * @return mixed[]
	 */
	public function toArray(): array;

	/**
	 * @return stdClass
	 */
	public function toStdClass(): stdClass;

}
