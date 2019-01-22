import * as React from 'react';
import renderer from 'react-test-renderer';
import { mount } from 'enzyme';

import { AutoCompleteField } from './AutoCompleteField';
import {SelectField} from "../../..";

describe('AutoCompleteField', () => {
	let onChange;
	beforeEach(() => {
		onChange = jest.fn();
	});
	it('should match snapshot', () => {
		const component = renderer.create(
			<AutoCompleteField
				label={'Select A Hat'}
				onChange={onChange}
				description={'selection of hats'}
				fieldId={'auto-complete-hats'}
				required={true}
				multiple={true}
				options={[
					{ value: 1, label: 'One' },
					{ value: 2, label: 'Two' }
				]}
			/>
		);
		expect(component.toJSON()).toMatchSnapshot();

	});

	it('Fires on change event', () => {
		const component = mount(
			<AutoCompleteField
				label={'Select A Hat'}
				onChange={onChange}
				description={'selection of hats'}
				fieldId={'selection-hats'}
				required={true}
				multiple={true}
				options={[
					{ value: 1, label: 'One' },
					{ value: 2, label: 'Two' }
				]}
			/>
		);

		const event = { target: { value: 2 } };
		component.find('input').simulate('change', event);
		expect(onChange.mock.calls.length).toBe(1);
		expect(onChange.mock.calls[0][0]).toBe(2);
	});

});