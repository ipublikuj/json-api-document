<?php declare(strict_types = 1);

/**
 * StandardObject.php
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

use IteratorAggregate;
use OutOfBoundsException;
use stdClass;
use Traversable;

class StandardObject implements IteratorAggregate, IStandardObject
{

	/** @var stdClass */
	protected $proxy;

	public function __construct(?stdClass $proxy = null)
	{
		$this->proxy = $proxy ?? new stdClass();
	}

	/**
	 * {@inheritDoc}
	 */
	public function get(string $key, $default = null)
	{
		return Obj::get($this->proxy, $key, $default);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getProperties(...$keys): array
	{
		$values = [];

		foreach ($this->normalizeKeys($keys) as $key) {
			$values[$key] = $this->has($key) ? $this->proxy->{$key} : null;
		}

		return $values;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMany(...$keys): array
	{
		$ret = [];

		foreach ($this->normalizeKeys($keys) as $key) {
			if ($this->has($key)) {
				$ret[$key] = $this->proxy->{$key};
			}
		}

		return $ret;
	}

	/**
	 * {@inheritDoc}
	 */
	public function set(string $key, $value): IStandardObject
	{
		$this->proxy->{$key} = $value;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setProperties(array $values): IStandardObject
	{
		foreach ($values as $key => $value) {
			$this->set($key, $value);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(string $key, $value): IStandardObject
	{
		if (!$this->has($key)) {
			$this->set($key, $value);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function addProperties(array $values): IStandardObject
	{
		foreach ($values as $key => $value) {
			$this->add($key, $value);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(...$keys): bool
	{
		foreach ($this->normalizeKeys($keys) as $key) {
			if (!property_exists($this->proxy, $key)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasAny(...$keys): bool
	{
		foreach ($this->normalizeKeys($keys) as $key) {
			if ($this->has($key)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function remove(...$keys): IStandardObject
	{
		foreach ($this->normalizeKeys($keys) as $key) {
			unset($this->proxy->{$key});
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function reduce(...$keys): IStandardObject
	{
		$keys = $this->normalizeKeys($keys);

		foreach ($this->keys() as $key) {
			if (!in_array($key, $keys, true)) {
				$this->remove($key);
			}
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function copy(): IStandardObject
	{
		return clone $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function keys(): array
	{
		return array_keys(get_object_vars($this->proxy));
	}

	/**
	 * {@inheritDoc}
	 */
	public function rename(string $currentKey, string $newKey): IStandardObject
	{
		if ($this->has($currentKey)) {
			$this->set($newKey, $this->proxy->{$currentKey})->remove($currentKey);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function renameKeys(array $mapping): IStandardObject
	{
		foreach ($mapping as $currentKey => $newKey) {
			$this->rename($currentKey, $newKey);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function transform(callable $transform, ...$keys): IStandardObject
	{
		foreach ($this->normalizeKeys($keys) as $key) {
			if (!$this->has($key)) {
				continue;
			}

			$value = call_user_func($transform, $this->proxy->{$key});
			$this->set($key, $value);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function transformKeys(callable $transform): IStandardObject
	{
		Obj::transformKeys($this->proxy, $transform);

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function toArray(): array
	{
		return Obj::toArray($this->proxy);
	}

	/**
	 * {@inheritDoc}
	 */
	public function toStdClass(): stdClass
	{
		return Obj::replicate($this->proxy);
	}

	/**
	 * {@inheritDoc}
	 */
	public function jsonSerialize()
	{
		return $this->proxy;
	}

	/**
	 * @param mixed[] $keys
	 *
	 * @return string[]
	 */
	protected function normalizeKeys(array $keys): array
	{
		return ($keys !== [] && is_array($keys[0])) ? (array) $keys[0] : $keys;
	}

	/**
	 * @return void
	 */
	public function __clone()
	{
		$this->proxy = Obj::replicate($this->proxy);
	}

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		if (!$this->has($key)) {
			throw new OutOfBoundsException(sprintf('Key "%s" does not exist.', $key));
		}

		return $this->proxy->{$key};
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return void
	 */
	public function __set($key, $value): void
	{
		$this->set($key, $value);
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function __isset($key)
	{
		return $this->has($key);
	}

	/**
	 * @param string $key
	 */
	public function __unset($key)
	{
		$this->remove($key);
	}

	/**
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return Obj::traverse($this->proxy);
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->toArray());
	}

}
