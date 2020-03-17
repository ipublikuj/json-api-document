<?php declare(strict_types = 1);

/**
 * Relationships.php
 *
 * @license        More in license.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          1.0.0
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument\Exceptions;

/**
 * Relationships
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class Relationships extends StandardObject implements IRelationships
{

	/**
	 * {@inheritDoc}
	 */
	public function getAll(): \Traversable
	{
		foreach ($this->keys() as $key) {
			yield $key => $this->getRelationship($key);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationship(string $key): IRelationship
	{
		if (!$this->has($key)) {
			throw new Exceptions\RuntimeException(sprintf('Relationship member "%s" is not present.', $key));
		}

		$value = $this->{$key};

		if (!is_object($value)) {
			throw new Exceptions\RuntimeException(sprintf('Relationship member "%s" is not an object.', $key));
		}

		return new Relationship($value);
	}

}
