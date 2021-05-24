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

use IPub\JsonAPIDocument\Exceptions\InvalidArgumentException;
use IPub\JsonAPIDocument\Objects\IStandardObject;
use JsonException;
use stdClass;

/**
 * JSON:API document
 *
 * @package        iPublikuj:JsonAPIDocument!
 * @subpackage     Objects
 *
 * @author         Adam Kadlec <adam.kadlec@ipublikuj.eu>
 */
class Document implements IDocument
{

	/** @var Objects\IStandardObject */
	private Objects\IStandardObject $data;

	/**
	 * @param string|stdClass $data
	 *
	 * @return IDocument
	 */
	public static function create($data): IDocument
	{
		if ($data instanceof stdClass) {
			return new self($data);
		}

		try {
			return new self(json_decode($data));

		} catch (JsonException $ex) {
			throw new InvalidArgumentException('Provided data are not valid string or object');
		}
	}

	public function __construct(stdClass $data)
	{
		$this->data = new Objects\StandardObject($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasResource(): bool
	{
		$data = $this->getData();

		return $data instanceof IStandardObject;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getResource(): Objects\IResourceObject
	{
		$data = $this->getData();

		if (!$data instanceof Objects\IStandardObject) {
			throw new Exceptions\RuntimeException('Data member is not an object.');
		}

		return new Objects\ResourceObject($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasResources(): bool
	{
		$data = $this->getData();

		return $data instanceof Objects\IStandardObjectCollection;
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

		return Objects\ResourceObjectCollection::create($data->getAll());
	}

	/**
	 * {@inheritDoc}
	 */
	public function getData()
	{
		if (!$this->data->has(self::KEYWORD_DATA)) {
			throw new Exceptions\RuntimeException('Data member is not present.');
		}

		$data = $this->data->get(self::KEYWORD_DATA);

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
	public function hasLinks(): bool
	{
		return $this->data->has(self::KEYWORD_LINKS);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLinks(): Objects\ILinkObjectCollection
	{
		$raw = $this->data->get(self::KEYWORD_LINKS);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Links member is not an object.');
		}

		return Objects\LinkObjectCollection::create($raw);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasMeta(): bool
	{
		return $this->data->has(self::KEYWORD_META);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMeta(): Objects\IMetaObjectCollection
	{
		$raw = $this->data->get(self::KEYWORD_META);

		if (!$raw instanceof Objects\IStandardObject && $raw !== null) {
			throw new Exceptions\RuntimeException('Meta member is not an object.');
		}

		return Objects\MetaObjectCollection::create($raw);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasIncluded(): bool
	{
		return $this->data->has(self::KEYWORD_INCLUDED);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIncluded(): Objects\IResourceObjectCollection
	{
		$raw = $this->data->get(self::KEYWORD_INCLUDED);

		if (!is_array($raw)) {
			throw new Exceptions\RuntimeException('Included member is not an array.');
		}

		return Objects\ResourceObjectCollection::create(Objects\StandardObjectCollection::create($raw)->getAll());
	}

	/**
	 * {@inheritDoc}
	 */
	public function hasErrors(): bool
	{
		return $this->data->has(self::KEYWORD_ERRORS);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getErrors(): Objects\IErrorObjectCollection
	{
		$raw = $this->data->get(self::KEYWORD_ERRORS);

		if (!is_array($raw)) {
			throw new Exceptions\RuntimeException('Errors member is not an array.');
		}

		return Objects\ErrorObjectCollection::create(Objects\StandardObjectCollection::create($raw)
			->getAll());
	}

}
