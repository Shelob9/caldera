# Forms

This is the forms package of the [Caldera Framework](https://github.com/CalderaWP/caldera) and provides form functionality, including entry tracking. __This is not Caldera Forms__.

## 👀🌋 This Is A Module Of The [Caldera Framework](https://github.com/CalderaWP/caldera)
* 🌋 Find Caldera Forms Here:
    - [Caldera Forms on Github](http://github.com/calderawp/caldera-forms/)
    - [CalderaForms.com](http://calderaforms.com)
    
* 🌋 [Issues](https://github.com/CalderaWP/caldera/issues) and [pull requests](https://github.com/CalderaWP/caldera/pulls), should be submitted to the [main Caldera repo](https://github.com/CalderaWP/caldera/pulls).

### Install
* Add to your package:
    - `composer require calderawp/forms`
* Install for development:
    - `git clone git@github.com:CalderaWP/forms.git && composer install`


## Examples
### Form Model
* Simple Example
```
$model = FormModel::fromArray([
    'id' => 'cf1',
    'name' => 'Contact Form',
    'fields' => [],
    'settings' => []
]);
```

* Example 2
```
//Create model
$form = \calderawp\caldera\Forms\FormModel::fromArray([
	'id' => 'cf1',
	'name' => 'Contact Form'
]);

//Email field
$emailField = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => 'fld1',
	'type' => 'text',
	'slug' => 'email',
	'html5type' => 'email',
	'label' => 'Your Email'
]);

//Checkbox with two options
$checkBoxField = \calderawp\caldera\Forms\FieldModel::fromArray(
	[
		'id' => 'fld2',
		'type' => 'checkbox', //radio or select has same syntax for options
		'label' => 'I agree to privacy policy',
		'description' => 'Learn more by reading our privacy policy',
		'options' =>[
			[
				'label' => 'Yes',
				'value' => true
			],
			[
				'label' => 'No',
				'value' => false
			]
		]
	]
);

//Add fields to form
$form
	->addField($emailField)
	->addField($checkBoxField);

```

### Example With Many Fields
```php
$array = [
			'id' => 'cf1',
			'fields' => [
				'name' => [
					'id' => 'name',
					'type' => 'input',
					'label' => 'Your Name',
					'required' => true,
					'description' => 'Put your name here',
					'config' => [
						'html5type' => ''
					]
				],
				'numberOfItems' => [
					'id' => 'numberOfItems',
					'type' => 'input',
					'label' => 'Total',
					'description' => 'How many items?',
					'fieldConfig' => [
						'html5type' => 'number',
						'attributes' => [
							'min' => 0,
							'step' => 1
						]
					]
				],
				'agreeToTerms' => [
					'id' => 'agreeToTerms',
					'type' => 'select',
					'label' => 'Agree to terms',
					'description' => 'Compliance is mandatory',
					'fieldConfig' => [
						'multiple' => false,
						'options' => [
							[
								'value' => true,
								'label' => 'Yes'
							],
							[
								'value' => false,
								'label' => 'No'
							]
						]
					]
				]
			],
			'processors' => [
                [
                    'label' => 'Main Message',
                    'type' => 'testType',
                    'config' =>
                        [
                            'fromName' => 'fld1',
                            'fromEmail' => 'roy@hiroy.club',
                        ]
                ]
            ]
		];
		$model = FormModel::fromArray($array);
```

### Field Model

* Text field
```php
$field = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => 'fld1',
	'type' => 'input',
	'slug' => 'name',
	'label' => 'Your Name'
]);
```

* Email field
```php
$field = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => '',
	'type' => 'input',
    'html5type' => 'email',
	'slug' => '',
	'label' => '',
	'description' => ''
]);
```

* Number field
```php
$field = \calderawp\caldera\Forms\FieldModel::fromArray([
	'id' => '',
	'type' => 'input',
    'html5type' => 'number',
	'slug' => '',
	'label' => '',
	'description' => '',
	'attributes' => [
        'min' => 5,
        'max' => 12
    ]
]);
```


## Testing
* Run unit tests
    - `composer test:unit`
* Run integration tests
    - `composer test:integration`
* Run acceptance tests
    - `composer test:acceptance`
    
## License, Copyright, etc.
Copyright 2018+ CalderaWP LLC and licensed under the terms of the GNU GPL license. Please share with your neighbor.
