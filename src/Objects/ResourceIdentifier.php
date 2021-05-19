<?php declare(strict_types = 1);

/**
 * ResourceIdentifier.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 * @since          0.0.1
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument\Objects;

use IPub\JsonAPIDocument\Exceptions;

/**
 * Resource identifier object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceIdentifier implements IResourceIdentifier
{

	/** @var string */
	private string $type;

	/** @var string */
	private string $id;

	/**
	 * @param string $type
	 * @param string $id
	 *
	 * @return ResourceIdentifier
	 */
	public static function create(string $type, string $id): IResourceIdentifier
	{
		return new self($type, $id);
	}

	public function __construct(
		string $type,
		string $id
	) {
		$this->type = $type;
		$this->id = $id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isType($typeOrTypes): bool
	{
		return in_array($this->type, (array) $typeOrTypes, true);
	}

	/**
	 * {@inheritDoc}
	 */
	public function mapType(array $types): string
	{
		if (array_key_exists($this->type, $types)) {
			return $types[$this->type];
		}

		throw new Exceptions\RuntimeException(sprintf('Type "%s" is not in the supplied map.', $this->type));
	}

	/**
	 * {@inheritDoc}
	 */
	public function isSame(IResourceIdentifier $identifier): bool
	{
		return $this->type === $identifier->getType() &&
			$this->id === $identifier->getId();
	}

	/**
	 * {@inheritDoc}
	 */
	public function toString(): string
	{
		return sprintf('%s:%s', $this->type, $this->id);
	}

}
