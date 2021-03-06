<?php


namespace calderawp\caldera\Forms\Processing;

use calderawp\caldera\Forms\FormArrayLike;
use calderawp\interop\Contracts\Rest\RestRequestContract as Request;
use calderawp\interop\Contracts\FieldsArrayLike as FormFields;

use calderawp\interop\Contracts\ProcessorContract;

class Processor implements ProcessorContract
{

	/**
	 * The name of the second stage of processing - the "pre-process" process.
	 *
	 * Also known as "validation processing"
	 *
	 * Runs after fields are validated.
	 */
	const PRE_PROCESS = 'preProcessStage1';

	/**
	 * The name of the second stage of processing - the "main" process.
	 *
	 * Also known as "process"
	 *
	 * Runs after pre-processing, after saving entry data
	 */
	const MAIN_PROCESS = 'mainProcessStage1';

	/**
	 * The name of the third stage of processing - the "post-process" process.
	 *
	 * Also known as "post-process"
	 *
	 * Runs after after entry data is saved in the database
	 */
	const POST_PROCESS = 'postProcessStage1';

	/**
	 * Process callbacks of this processor
	 *
	 * @var callable[]
	 */
	protected $callbacks;

	/**
	 * Settings for this instance of the processor
	 *
	 * @var ProcessorConfig
	 */
	protected $processorConfig;

	/**
	 * Meta data for processors
	 *
	 * @var ProcessorMeta
	 */
	protected $processorMeta;

	/** @var FormArrayLike */
	protected $form;
	public function __construct(ProcessorMeta $processorMeta, ProcessorConfig $processorConfig, ? FormArrayLike $form = null, array $callbacks = [])
	{
		$this->processorConfig = $processorConfig;
		$this->callbacks = $callbacks;
		$this->processorMeta = $processorMeta;
		$this->form = $form;
	}

	/**
	 * @return callable[]
	 */
	public function getCallbacks(): array
	{
		return $this->callbacks;
	}

	/**
	 * @param callable[] $callbacks
	 *
	 * @return Processor
	 */
	public function setCallbacks(array $callbacks): Processor
	{
		$this->callbacks = $callbacks;
		return $this;
	}




	/**
	 * Create an object from an array.
	 *
	 * @param array $item MUST include type. May include label and id and processor config (saved settings).
	 *
	 * @return ProcessorContract
	 */
	public static function fromArray(array $item = []): ProcessorContract
	{
		$type = $item[ 'type' ];// do not add add a safety check for type here? - Josh?
		$label = ! empty($item['label']) ? $item[ 'label' ] : '';
		$processorMeta = new ProcessorMeta([
			'label' => $label,
			'type' => $type
		]);

		if (! empty($item['id'])) {
			$processorMeta->setId($item['id']);
		}
		$processorConfig = new ProcessorConfig(! empty($item['config']) ?  $item['config'] : []);
		return new static(
			$processorMeta,
			$processorConfig
		);
	}

	/**
	 * @return string
	 */
	public function getId() : string
	{
		return $this->processorMeta->getId();
	}

	public function getLabel() : string
	{
		return ! empty($_label = $this->processorMeta->getLabel())
		   ? $_label
		   : $this->getProcessorType();
	}

	public function getProcessorType(): string
	{
		return $this->processorMeta->getType();
	}

	/**
	 * @inheritDoc
	 */
	public function getForm(): FormArrayLike
	{
		return $this->form;
	}

	/** @inheritdoc */
	public function checkConditionals(): bool
	{
		return true;
	}

	/** @inheritdoc */
	public function preProcess(FormFields $formFields, Request $request): FormFields
	{
		return $this->dispatch($formFields, $request, self::PRE_PROCESS);
	}

	/** @inheritdoc */
	public function mainProcess(FormFields $formFields, Request $request): FormFields
	{
		return $this->dispatch($formFields, $request, self::MAIN_PROCESS);
	}

	/** @inheritdoc */
	public function postProcess(FormFields $formFields, Request $request): FormFields
	{
		return $this->dispatch($formFields, $request, self::POST_PROCESS);
	}

	/**
	 * @inheritDoc
	 */
	public function getProcessorConfig(): ProcessorConfig
	{
		return $this->processorConfig;
	}

	/**
	 * @inheritDoc
	 */
	public function toArray() : array
	{
		return [
			'id' => $this->getId(),
			'label' => $this->getLabel(),
			'type' => $this->getProcessorType(),
			'config' => $this->getProcessorConfig()->toArray()
		];
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}


	/**
	 * Find process dispatcher
	 *
	 * @param string $identifier
	 *
	 * @return array|mixed
	 */
	protected function findCallback(string $identifier)
	{
		$callback = $this->callbacks[$identifier];
		if (is_object($callback)) {
			return [$callback, 'process' ];
		}
		return $callback;
	}

	/**
	 * Dispatch process stages
	 *
	 * @param FormFields $formFields
	 * @param Request $request
	 * @param $identifier
	 *
	 * @return FormFields|mixed
	 */
	protected function dispatch(FormFields $formFields, Request $request, $identifier) : FormFields
	{
		if (array_key_exists($identifier, $this->callbacks)) {
			return call_user_func($this->findCallback($identifier), $formFields, $request);
		}

		return $formFields;
	}
}
