<?php declare(strict_types = 1);

/**
 * ResourceIdentifier.php
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
use Neomerx\JsonApi\Contracts\Schema\DocumentInterface;

/**
 * Resource identifier object
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class ResourceIdentifier extends StandardObject implements IResourceIdentifier
{

	use TIdentifiable;
	use TMetaMember;

	/**
	 * @param string $type
	 * @param string $id
	 *
	 * @return ResourceIdentifier
	 */
	public static function create(string $type, string $id): IResourceIdentifier
	{
		$identifier = new self();

		$identifier->set(DocumentInterface::KEYWORD_TYPE, $type)
			->set(DocumentInterface::KEYWORD_ID, $id);

		return $identifier;
	}

	/**
	 * {@inheritDoc}
	 */
	public function isType($typeOrTypes): bool
	{
		return in_array($this->get(DocumentInterface::KEYWORD_TYPE), (array) $typeOrTypes, true);
	}

	/**
	 * {@inheritDoc}
	 */
	public function mapType(array $map)
	{
		$type = $this->getType();

		if (array_key_exists($type, $map)) {
			return $map[$type];
		}

		throw new Exceptions\RuntimeException(sprintf('Type "%s" is not in the supplied map.', $type));
	}

	/**
	 * {@inheritDoc}
	 */
	public function isComplete(): bool
	{
		return $this->hasType() && $this->hasId();
	}

	/**
	 * {@inheritDoc}
	 */
	public function isSame(IResourceIdentifier $identifier): bool
	{
		return $this->getType() === $identifier->getType() &&
			$this->getId() === $identifier->getId();
	}

	/**
	 * {@inheritDoc}
	 */
	public function toString(): string
	{
		return sprintf('%s:%s', $this->getType(), $this->getId());
	}

}
