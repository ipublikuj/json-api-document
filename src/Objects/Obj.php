<?php declare(strict_types = 1);

/**
 * Obj.php
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

use IPub\JsonAPIDocument\Exceptions;
use stdClass;
use Traversable;

class Obj
{

	/**
	 * @param IStandardObject|stdClass $data
	 * @param string $key
	 * @param mixed $default
	 *
	 * @return string|int|float|bool|mixed[]|IStandardObject|null
	 *
	 * @phpstan-return string|int|float|bool|mixed[]|IStandardObject<string, string|int|float|bool|mixed[]|null>|null
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

		if ($value instanceof IStandardObject || $value instanceof stdClass) {
			return static::cast($value);

		} elseif (is_array($value)) {
			$mapped = [];

			foreach ($value as $fieldKey => $field) {
				$mapped[$fieldKey] = $field instanceof IStandardObject || $field instanceof stdClass ? static::cast($field) : $field;
			}

			return $mapped;
		}

		return $value;
	}

	/**
	 * @param IStandardObject|stdClass $data
	 *
	 * @return IStandardObject
	 *
	 * @phpstan-return IStandardObject<string, string|int|float|bool|mixed[]|null>
	 */
	public static function cast($data): IStandardObject
	{
		return $data instanceof IStandardObject ? $data : new StandardObject($data);
	}

	/**
	 * @param stdClass $data
	 *
	 * @return stdClass
	 */
	public static function replicate(stdClass $data): stdClass
	{
		$copy = clone $data;

		foreach (array_keys(get_object_vars($copy)) as $key) {
			if ($data->{$key} instanceof stdClass) {
				$copy->{$key} = static::replicate($data->{$key});
			}
		}

		return $copy;
	}

	/**
	 * @param stdClass|mixed[] $data
	 *
	 * @return Traversable
	 *
	 * @phpstan-return Traversable<string, string|int|float|bool|mixed[]|IStandardObject|null>
	 */
	public static function traverse($data): Traversable
	{
		/** @phpstan-ignore-next-line */
		if (!$data instanceof stdClass && !is_array($data)) {
			throw new Exceptions\InvalidArgumentException('Expecting an object or array to transform keys.');
		}

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				yield $key => $value instanceof stdClass ? static::cast($value) : $value;
			}

		} else {
			foreach (array_keys(get_object_vars($data)) as $key) {
				yield $key => $data->{$key} instanceof stdClass ? static::cast($data->{$key}) : $data->{$key};
			}
		}
	}

	/**
	 * @param stdClass|mixed[] $data
	 *
	 * @return mixed[]
	 *
	 * @phpstan-return Array<string, string|int|float|bool|mixed[]|null>
	 */
	public static function toArray($data): array
	{
		/** @phpstan-ignore-next-line */
		if (!$data instanceof stdClass && !is_array($data)) {
			throw new Exceptions\InvalidArgumentException('Expecting an object or array to transform keys.');
		}

		$arr = [];

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$arr[$key] = ($value instanceof stdClass || is_array($value)) ? static::toArray($value) : $value;
			}

		} else {
			foreach (array_keys(get_object_vars($data)) as $key) {
				$arr[$key] = ($data->{$key} instanceof stdClass || is_array($data->{$key})) ? static::toArray($data->{$key}) : $data->{$key};
			}
		}

		return $arr;
	}

}
