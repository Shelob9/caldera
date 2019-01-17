import * as React from 'react';
import renderer from 'react-test-renderer';
import { mount } from 'enzyme';

import { Processor } from './Processor';

import {
	checkboxFieldset,
	selectField,
	checkboxField,
	numberField,
	textField,
	emailField,
	radioField
} from '@calderawp/factory';

describe('Processor', () => {
	let onClose;
	let onChange;
	let onBlur;

	beforeEach(() => {
		onClose = jest.fn();
		onChange = jest.fn();
		onBlur = jest.fn();
	});

	it('Matches snapshot', () => {
		const component = renderer.create(
			<Processor
				fields={[checkboxFieldset, selectField, checkboxField]}
				initialValues={{}}
				onClose={onClose}
				onChange={onChange}
				onBlur={onBlur}
				instanceId={'test-1'}
			/>
		);
		expect(component.toJSON()).toMatchSnapshot();
	});

	it('Can switch to conditionals', () => {
		const component = mount(
			<Processor
				fields={[checkboxFieldset, selectField, checkboxField]}
				initialValues={{}}
				onClose={onClose}
				onChange={onChange}
				onBlur={onBlur}
				initialActiveTab={'conditionals'}
				instanceId={'test-1'}
			/>
		);
		component.instance().onSetTab('conditionals');
		expect(component.state('activeTab')).toBe('conditionals');
	});

	it('Can show conditionals', () => {
		const component = mount(
			<Processor
				fields={[checkboxFieldset, selectField, checkboxField]}
				initialValues={{}}
				onClose={onClose}
				onChange={onChange}
				onBlur={onBlur}
				initialActiveTab={'conditionals'}
				instanceId={'test-1'}
			/>
		);
		expect( component.find( '.caldera-processor-conditionals').length).toBe(0);
		component.setState({activeTab:'conditionals'});
		expect(component.state('activeTab')).toBe('conditionals');
	});
});
