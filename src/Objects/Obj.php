<?php declare(strict_types = 1);

/**
 * Obj.php
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

use IPub\JsonAPIDocument\Exceptions;
use stdClass;
use Traversable;

class Obj
{

	/**
	 * @param IStandardObject|object $data
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return IStandardObject|mixed
	 */
	public static function get($data, string $key, $default = null)
	{
		if ($data instanceof IStandardObject) {
			return $data->get($key, $default);
		}

		if (!property_exists($data, $key)) {
			return $default;
		}

		$value = $data->{$key};

		return is_object($value) ? static::cast($value) : $value;
	}

	/**
	 * @param IStandardObject|object|null $data
	 *
	 * @return IStandardObject
	 */
	public static function cast($data): ?IStandardObject
	{
		return ($data instanceof IStandardObject) ? $data : new StandardObject($data);
	}

	/**
	 * @param object $data
	 *
	 * @return object
	 */
	public static function replicate($data)
	{
		$copy = clone $data;

		foreach ($copy as $key => $value) {
			if (is_object($value)) {
				$copy->{$key} = static::replicate($value);
			}
		}

		return $copy;
	}

	/**
	 * @param object|array $data
	 *
	 * @return Traversable
	 */
	public static function traverse($data): Traversable
	{
		foreach ($data as $key => $value) {
			yield $key => is_object($value) ? static::cast($value) : $value;
		}
	}

	/**
	 * @param object|array $data
	 *
	 * @return mixed[]
	 */
	public static function toArray($data): array
	{
		if (!is_object($data) && !is_array($data)) {
			throw new Exceptions\InvalidArgumentException('Expecting an object or array to convert to an array.');
		}

		$arr = [];

		foreach ($data as $key => $value) {
			$arr[$key] = (is_object($value) || is_array($value)) ? static::toArray($value) : $value;
		}

		return $arr;
	}

	/**
	 * @param object|array $data
	 * @param callable $transform
	 *
	 * @return array|stdClass
	 */
	public static function transformKeys($data, callable $transform)
	{
		if (!is_object($data) && !is_array($data)) {
			throw new Exceptions\InvalidArgumentException('Expecting an object or array to transform keys.');
		}

		$copy = is_object($data) ? clone $data : $data;

		foreach ($copy as $key => $value) {
			$transformed = call_user_func($transform, $key);

			$value = (is_object($value) || is_array($value)) ? self::transformKeys($value, $transform) : $value;

			if (is_object($data)) {
				unset($data->{$key});
				$data->{$transformed} = $value;

			} else {
				unset($data[$key]);
				$data[$transformed] = $value;
			}
		}

		return $data;
	}

}
