<?php declare(strict_types = 1);

/**
 * StandardObject.php
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

use IteratorAggregate;
use OutOfBoundsException;
use stdClass;
use Traversable;

/**
 * @phpstan-implements IteratorAggregate<mixed, mixed|IStandardObject>
 */
class StandardObject implements IteratorAggregate, IStandardObject
{

	/** @var stdClass */
	protected stdClass $proxy;

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
	public function getMany(...$keys): array
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
	public function set(string $key, $value): IStandardObject
	{
		$this->proxy->{$key} = $value;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setMany(array $values): IStandardObject
	{
		foreach ($values as $key => $value) {
			$this->set($key, $value);
		}

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function has(string $key): bool
	{
		foreach ($this->normalizeKeys([$key]) as $normalizedKey) {
			if (!property_exists($this->proxy, $normalizedKey)) {
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
	public function keys(): array
	{
		return array_keys(get_object_vars($this->proxy));
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
	public function toStdClass(): stdClass
	{
		return Obj::replicate($this->proxy);
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
	public function jsonSerialize(): stdClass
	{
		return $this->proxy;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @phpstan-return Traversable<string, mixed>
	 */
	public function getIterator(): Traversable
	{
		return Obj::traverse($this->proxy);
	}

	/**
	 * {@inheritDoc}
	 */
	public function count(): int
	{
		return count($this->toArray());
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
	public function __get(string $key)
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
	public function __set(string $key, $value): void
	{
		$this->set($key, $value);
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function __isset(string $key): bool
	{
		return $this->has($key);
	}

	/**
	 * @param string $key
	 */
	public function __unset(string $key)
	{
		$this->remove($key);
	}

	/**
	 * @param mixed[] $keys
	 *
	 * @return string[]
	 */
	protected function normalizeKeys(array $keys): array
	{
		return ($keys !== [] && is_array($keys[0])) ? $keys[0] : $keys;
	}

}
