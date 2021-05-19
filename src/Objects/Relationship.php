<?php declare(strict_types = 1);

/**
 * Relationship.php
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
 * Relationship
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class Relationship extends StandardObject implements IRelationship
{

	use TMetaMember;

	/**
	 * {@inheritDoc}
	 */
	public function getData()
	{
		if ($this->isHasMany()) {
			return $this->getIdentifiers();

		} elseif ($this->isHasOne()) {
			return $this->hasIdentifier() ? $this->getIdentifier() : null;
		}

		throw new Exceptions\RuntimeException('No data member or data member is not a valid relationship.');
	}

	/**
	 * {@inheritDoc}
	 */
	public function isHasMany(): bool
	{
		return is_array($this->get(JsonAPIDocument\IDocument::KEYWORD_DATA));
	}

	/**
	 * {@inheritDoc}
	 */
	public function isHasOne(): bool
	{
		if (!$this->has(JsonAPIDocument\IDocument::KEYWORD_DATA)) {
			return false;
		}

		$data = $this->get(JsonAPIDocument\IDocument::KEYWORD_DATA);

		return $data === null || is_object($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifiers(): IResourceIdentifierCollection
	{
		if (!$this->isHasMany()) {
			throw new Exceptions\RuntimeException('No data member of data member is not a valid has-many relationship.');
		}

		return ResourceIdentifierCollection::create($this->get(JsonAPIDocument\IDocument::KEYWORD_DATA));
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasIdentifier(): bool
	{
		$data = $this->get(JsonAPIDocument\IDocument::KEYWORD_DATA);

		return $data instanceof IStandardObject
			&& $data->has(JsonAPIDocument\IDocument::KEYWORD_TYPE)
			&& $data->has(JsonAPIDocument\IDocument::KEYWORD_ID);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentifier(): ?IResourceIdentifier
	{
		if (!$this->isHasOne()) {
			throw new Exceptions\RuntimeException('No data member or data member is not a valid has-one relationship.');
		}

		$data = $this->get(JsonAPIDocument\IDocument::KEYWORD_DATA);

		if (!$this->hasIdentifier()) {
			throw new Exceptions\RuntimeException('No resource identifier - relationship is empty.');
		}

		return ResourceIdentifier::create(
			$data->get(JsonAPIDocument\IDocument::KEYWORD_TYPE),
			$data->get(JsonAPIDocument\IDocument::KEYWORD_ID)
		);
	}

}
