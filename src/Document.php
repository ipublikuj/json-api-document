<?php declare(strict_types = 1);

/**
 * Document.php
 *
 * @license        More in license.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     common
 * @since          1.0.0
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument;

use IPub\JsonAPIDocument\Exceptions;
use IPub\JsonAPIDocument\Objects;
use Neomerx\JsonApi\Contracts\Schema\DocumentInterface;
use Neomerx\JsonApi\Schema\ErrorCollection;

/**
 * JSON:API document
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class Document extends Objects\StandardObject implements IDocument
{

	use Objects\TMetaMember;

	/**
	 * {@inheritDoc}
	 */
	public function getData()
	{
		if (!$this->has(DocumentInterface::KEYWORD_DATA)) {
			throw new Exceptions\RuntimeException('Data member is not present.');
		}

		$data = $this->get(DocumentInterface::KEYWORD_DATA);

		if (is_array($data) || is_null($data)) {
			return $data;
		}

		if (!$data instanceof Objects\IStandardObject) {
			throw new Exceptions\RuntimeException('Data member is not an object or null.');
		}

		return $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getResource(): Objects\IResourceObject
	{
		$data = $this->{DocumentInterface::KEYWORD_DATA};

		if (!is_object($data)) {
			throw new Exceptions\RuntimeException('Data member is not an object.');
		}

		return new Objects\ResourceObject($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getResources(): Objects\IResourceObjectCollection
	{
		$data = $this->get(DocumentInterface::KEYWORD_DATA);

		if (!is_array($data)) {
			throw new Exceptions\RuntimeException('Data member is not an array.');
		}

		return Objects\ResourceObjectCollection::create($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRelationship(): Objects\IRelationship
	{
		return new Objects\Relationship($this->proxy);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIncluded(): ?Objects\IResourceObjectCollection
	{
		if (!$this->has(DocumentInterface::KEYWORD_INCLUDED)) {
			return null;
		}

		$data = $this->{DocumentInterface::KEYWORD_INCLUDED};

		if (!is_array($data)) {
			throw new Exceptions\RuntimeException('Included member is not an array.');
		}

		return Objects\ResourceObjectCollection::create($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getErrors(): ?ErrorCollection
	{
		if (!$this->has(DocumentInterface::KEYWORD_ERRORS)) {
			return null;
		}

		$data = $this->{DocumentInterface::KEYWORD_ERRORS};

		if (!is_array($data)) {
			throw new Exceptions\RuntimeException('Errors member is not an array.');
		}

		$errors = new ErrorCollection;

		foreach ($data as $item) {
			$errors->add(new Objects\Error($item));
		}

		return $errors;
	}

}
