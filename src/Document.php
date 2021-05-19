<?php declare(strict_types = 1);

/**
 * Document.php
 *
 * @license        More in LICENSE.md
 * @copyright      https://www.ipublikuj.eu
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     common
 * @since          0.0.1
 *
 * @date           05.05.18
 */

namespace IPub\JsonAPIDocument;

use stdClass;

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

	/**
	 * {@inheritDoc}
	 */
	public function getData()
	{
		if (!$this->has(self::KEYWORD_DATA)) {
			throw new Exceptions\RuntimeException('Data member is not present.');
		}

		$data = $this->get(self::KEYWORD_DATA);

		if (is_array($data)) {
			return Objects\StandardObjectCollection::create($data);
		}

		if (!$data instanceof Objects\IStandardObject && $data !== null) {
			throw new Exceptions\RuntimeException('Data member is not an object or null.');
		}

		return $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getResource(): ?Objects\IResourceObject
	{
		$data = $this->getData();

		if ($data === null) {
			return null;
		}

		if (!$data instanceof Objects\IStandardObject) {
			throw new Exceptions\RuntimeException('Data member is not an object.');
		}

		return new Objects\ResourceObject($data->toStdClass());
	}

	/**
	 * {@inheritDoc}
	 */
	public function getResources(): Objects\IResourceObjectCollection
	{
		$data = $this->getData();

		if (!$data instanceof Objects\IStandardObjectCollection) {
			throw new Exceptions\RuntimeException('Data member is not an array.');
		}

		return Objects\ResourceObjectCollection::create(array_map(function (Objects\IStandardObject $resource): stdClass {
			return $resource->toStdClass();
		}, $data->getAll()));
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLinks(): ?Objects\IStandardObject
	{
		if (!$this->has(self::KEYWORD_LINKS)) {
			return null;
		}

		$data = $this->get(self::KEYWORD_LINKS);

		if (!$data instanceof Objects\IStandardObject && $data !== null) {
			throw new Exceptions\RuntimeException('Links member is not an object or null.');
		}

		return $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMeta(): ?Objects\IStandardObject
	{
		if (!$this->has(self::KEYWORD_META)) {
			return null;
		}

		$data = $this->get(self::KEYWORD_META);

		if (!$data instanceof Objects\IStandardObject && $data !== null) {
			throw new Exceptions\RuntimeException('Meta member is not an object or null.');
		}

		return $data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIncluded(): ?Objects\IResourceObjectCollection
	{
		if (!$this->has(self::KEYWORD_INCLUDED)) {
			return null;
		}

		$data = $this->get(self::KEYWORD_INCLUDED);

		if (!is_array($data)) {
			throw new Exceptions\RuntimeException('Included member is not an array.');
		}

		return Objects\ResourceObjectCollection::create($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getErrors(): ?Objects\IErrorCollection
	{
		if (!$this->has(self::KEYWORD_ERRORS)) {
			return null;
		}

		$data = $this->get(self::KEYWORD_ERRORS);

		if (!is_array($data)) {
			throw new Exceptions\RuntimeException('Errors member is not an array.');
		}

		return Objects\ErrorCollection::create($data);
	}

}
