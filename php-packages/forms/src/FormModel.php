<?php


namespace calderawp\caldera\Forms;

use calderawp\caldera\Forms\Traits\PreparesFieldsFromArray;
use calderawp\CalderaContainers\Exceptions\Exception;
use calderawp\interop\Caldera;
use calderawp\caldera\Forms\Contracts\FormModelContract;
use calderawp\interop\Contracts\CalderaForms\HasFields;
use calderawp\interop\Contracts\Interoperable;
use calderawp\interop\Traits\CalderaForms\ProvidesFields;
use calderawp\interop\Traits\CalderaForms\ProvidesForm;
use calderawp\interop\Contracts\CalderaContract as CalderaContract;

class FormModel extends Caldera implements FormModelContract
{
	use ProvidesForm, ProvidesFields, PreparesFieldsFromArray;


	/**
	 * @param array $items
	 *
	 * @return FormModel
	 */
	public static function fromArray(array $items): Interoperable
	{

		$items = self::prepareFieldsFromArray($items);
		$obj = parent::fromArray($items);
		if (isset($items['fields'])&&is_object($items['fields'])) {
			$obj->setFields($items['fields']);
		}
		return $obj;
	}
}
