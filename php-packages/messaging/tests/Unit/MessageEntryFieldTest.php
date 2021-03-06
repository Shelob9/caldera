<?php

namespace calderawp\caldera\Messaging\Tests\Unit;

use calderawp\caldera\Messaging\Entities\MessageEntryField;
use PHPUnit\Framework\TestCase;

class MessageEntryFieldTest extends TestCase
{

	public function testToArray()
	{
		$value = 'vv';
		$slug = 'sloooogoooo';
		$messageEntryField = new MessageEntryField();
		$messageEntryField->value = $value;
		$messageEntryField->slug = $slug;
		$this->assertEquals($value, $messageEntryField->toArray()['value']);
		$this->assertEquals($slug, $messageEntryField->toArray()['slug']);
	}

	public function testFromArray(){
		$value = 'vv';
		$slug = 'sloooogoooo';

		$messageEntryField = MessageEntryField::fromArray( ['value' => $value, 'slug' => $slug]);
		$this->assertEquals($value, $messageEntryField->toArray()['value']);
		$this->assertEquals($slug, $messageEntryField->toArray()['slug']);
	}

	public function testFromArrayCamelCasing()
	{
		$array = [
			'field_id' => 'cf1',
			'entry_id'=> 11
		];
		$messageEntryField = MessageEntryField::fromArray($array);
		$this->assertEquals('cf1', $messageEntryField->fieldId );
		$this->assertEquals(11, $messageEntryField->entryId );

	}
}
