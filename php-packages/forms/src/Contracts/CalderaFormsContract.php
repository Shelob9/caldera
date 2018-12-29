<?php


namespace calderawp\caldera\Forms\Contracts;

use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Exception;
use \calderawp\caldera\Forms\Contracts\DataSourcesContract as DataSources;

interface CalderaFormsContract extends CalderaModule
{
	/**
	 * Find form, searching by a column
	 *
	 * @param string $by
	 * @param string|int $searchValue Optional, value to search by. Default is 'id'
	 *
	 * @return FormsCollectionContract
	 * @throws Exception
	 */
	public function findForm(string $by, $searchValue = 'id'):FormsCollectionContract;
	/**
	 * Get forms collection
	 *
	 * @return FormsCollectionContract
	 */
	public function getForms():FormsCollectionContract;
	/**
	 * @param string $by
	 * @param $searchValue
	 *
	 * @return EntryCollectionContract
	 * @throws Exception
	 */
	public function findEntryBy(string $by, $searchValue = 'id') : EntryCollectionContract;

	/**
	 * Get entries of a form
	 *
	 * @return EntryCollectionContract
	 */
	public function getEntries():EntryCollectionContract;


	/**
	 * Set primary data source
	 *
	 * @param DataSources $sources
	 *
	 * @return CalderaFormsContract
	 */
	public function setPrimaryDataSource(DataSources $sources): CalderaFormsContract;

	/**
	 * Get the current primary data source
	 *
	 * @return DataSources
	 */
	public function getPrimaryDataSource(): DataSources;
}
