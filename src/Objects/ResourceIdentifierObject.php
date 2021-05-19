<?php declare(strict_types = 1);

/**
 * ResourceIdentifierObject.php
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

use IPub\JsonAPIDocument;
use IPub\JsonAPIDocument\Exceptions;

/**
 * Resource identifier object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceIdentifierObject implements IResourceIdentifierObject
{

	/** @var string */
	private string $type;

	/** @var string */
	private string $id;

	public function __construct(IStandardObject $data)
	{
		$type = $data->get(JsonAPIDocument\IDocument::KEYWORD_TYPE);
		$id = $data->get(JsonAPIDocument\IDocument::KEYWORD_ID);

		if (!is_string($type) || !is_string($id)) {
			throw new Exceptions\InvalidArgumentException('Data member has invalid format');
		}

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
		return in_array($this->type, is_array($typeOrTypes) ? $typeOrTypes : [$typeOrTypes], true);
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
	public function isSame(IResourceIdentifierObject $identifier): bool
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

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->toString();
	}

}
