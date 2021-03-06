<?php


namespace calderawp\caldera\Messaging\Models;

use calderawp\caldera\Messaging\Contracts\ModelContract;
use calderawp\caldera\Messaging\Entities\Contracts\RecipientContract as Recipient;
use calderawp\caldera\Messaging\Entities\Contracts\RecipientsContracts as Recipients;
use calderawp\caldera\Messaging\Entities\EntryData;
use calderawp\caldera\Messaging\Message\Attributes;

class Message extends Model
{

	/** @var @int */
	protected $id;
	/** @var \DateTime */
	protected $createdAt;
	/** @var \DateTime */
	protected $updatedAt;
	/** @var @int */
	protected $account;
	/** @var Layout */
	protected $layout;
	/** @var @string */
	protected $content;
	/** @var @bool */
	protected $pdf;
	/** @var Layout */
	protected $pdfLayout;
	/** @var Recipients */
	protected $to;
	/** @var Recipient */
	protected $reply;
	/** @var Recipients */
	protected $cc;
	/** @var Recipients */
	protected $bcc;
	/** @var string */
	protected $subject;
	/** @var bool */
	protected $spammed;
	/** @var EntryData */
	protected $entryData;
	/** @var array */
	protected $attachments;

	/**
	 * @var Attributes
	 */
	protected $attributes;



	/**
	 * Message has cc
	 *
	 * @return bool
	 */
	public function hasCc(): bool
	{
		return !empty($this->cc) && !$this->cc->empty();
	}

	/**
	 * Message has bcc
	 *
	 * @return bool
	 */
	public function hasBcc(): bool
	{
		return !empty($this->bcc) && !$this->bcc->empty();
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public function getSchema(): array
	{
		return (new Attributes())->toArray();
	}


	public static function fromArray(array $items): ModelContract
	{
		$create = function ($key, $items) {
			if (isset($items[ $key ]) && is_array($items[ $key ])) {
				$items[ $key ] = Layout::fromArray($items[ $key ]);
			}
			return $items;
		};
		$items = $create('layout', $items);
		$items = $create('pdfLayout', $items);
		return parent::fromArray($items);
	}

	public function addRecipient(string $type, string $email, string $name = null): Message
	{

		$array = [
			'email' => $email,
		];
		if ($name) {
			$array[ 'name' ] = $name;
		}
		$recipient = \calderawp\caldera\Messaging\Entities\Recipient::fromArray($array);
		switch ($type) {
			case 'to':
				$recipients = $this->getTo();
				$recipients->addRecipient($recipient);
				$this->setTo($recipients);
				break;
			case 'reply':
				$this->setReply($recipient);
				break;
			case 'cc':
				$this->setCc($this->getCc()->addRecipient($recipient));
				break;
			case 'bcc':
				$this->setBcc($this->getBcc()->addRecipient($recipient));
				break;
			default:
				return $this;

		}

		return $this;
	}

	/**
	 * @param mixed $id
	 *
	 * @return Message
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 *
	 * @return Message
	 */
	public function setCreatedAt(\DateTime $createdAt): Message
	{
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt(): \DateTime
	{
		return $this->updatedAt;
	}

	/**
	 * @param \DateTime $updatedAt
	 *
	 * @return Message
	 */
	public function setUpdatedAt(\DateTime $updatedAt): Message
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getAccount(): int
	{
		return $this->account;
	}

	/**
	 * @param int $account
	 *
	 * @return Message
	 */
	public function setAccount(int $account): Message
	{
		$this->account = $account;
		return $this;
	}

	/**
	 * @return Layout
	 */
	public function getLayout(): Layout
	{
		return $this->layout;
	}

	/**
	 * @param mixed $layout
	 *
	 * @return Message
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return is_string($this->content) ? $this->content : '';
	}

	/**
	 * @param mixed $content
	 *
	 * @return Message
	 */
	public function setContent(string $content = ''): Message
	{
		$this->content = $content;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getPdf(): bool
	{
		return !is_null($this->pdf) ? (bool)$this->pdf : false;
	}

	/**
	 * @param bool $pdf
	 *
	 * @return Message
	 */
	public function setPdf(bool $pdf): Message
	{
		$this->pdf = $pdf;
		return $this;
	}

	/**
	 * @return Layout
	 */
	public function getPdfLayout(): Layout
	{
		return $this->pdfLayout;
	}

	/**
	 * @param Layout $pdfLayout
	 *
	 * @return Message
	 */
	public function setPdfLayout(Layout $pdfLayout)
	{
		$this->pdfLayout = $pdfLayout;
		return $this;
	}

	/**
	 * @return Recipients
	 */
	public function getTo(): Recipients
	{
		return isset($this->to) ? $this->to : new \calderawp\caldera\Messaging\Entities\Recipients();
	}

	/**
	 * @param Recipients $to
	 *
	 * @return Message
	 */
	public function setTo(Recipients $to): Message
	{
		$this->to = $to;
		return $this;
	}

	/**
	 * @return Recipient
	 */
	public function getReply(): Recipient
	{
		return isset($this->reply) ? $this->reply : new \calderawp\caldera\Messaging\Entities\Recipient('');
	}

	/**
	 * @param Recipient $reply
	 *
	 * @return Message
	 */
	public function setReply(Recipient $reply): Message
	{
		$this->reply = $reply;
		return $this;
	}

	/**
	 * @return Recipients
	 */
	public function getCc(): Recipients
	{
		return ($this->cc) ? $this->cc : new \calderawp\caldera\Messaging\Entities\Recipients();
	}

	/**
	 * @param Recipients $cc
	 *
	 * @return Message
	 */
	public function setCc(Recipients $cc): Message
	{
		$this->cc = $cc;
		return $this;
	}

	/**
	 * @return Recipients
	 */
	public function getBcc(): Recipients
	{
		return ($this->bcc) ? $this->bcc : new \calderawp\caldera\Messaging\Entities\Recipients();
	}

	/**
	 * @param Recipients $bcc
	 *
	 * @return Message
	 */
	public function setBcc(Recipients $bcc): Message
	{
		$this->bcc = $bcc;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubject(): string
	{
		return is_string($this->subject) ? $this->subject : '';
	}

	/**
	 * @param string $subject
	 *
	 * @return Message
	 */
	public function setSubject(string $subject): Message
	{
		$this->subject = $subject;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSpammed(): bool
	{
		return !is_null($this->spammed) ? (bool)$this->spammed : false;
	}

	/**
	 * @param bool $spammed
	 *
	 * @return Message
	 */
	public function setSpammed(bool $spammed): Message
	{
		$this->spammed = $spammed;
		return $this;
	}

	/**
	 * @return EntryData
	 */
	public function getEntryData(): EntryData
	{
		return $this->entryData;
	}

	/**
	 * @param EntryData $entryData
	 *
	 * @return Message
	 */
	public function setEntryData(EntryData $entryData): Message
	{
		$this->entryData = $entryData;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getAttachments(): array
	{
		return $this->attachments;
	}

	/**
	 * @param array $attachments
	 *
	 * @return Message
	 */
	public function setAttachments(array $attachments): Message
	{
		$this->attachments = $attachments;
		return $this;
	}


}

