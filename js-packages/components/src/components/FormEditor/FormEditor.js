import React, {Component, Fragment, createElement} from 'react';
import PropTypes from 'prop-types';
import {Processors, processorsCollectionPropType} from './Processors';
import {TabPanel} from '@wordpress/components';
import {Row, Column} from '@calderawp/factory';
import {processorsCollection} from "./processors.fixtures";
import {fieldAreaFactory} from '@calderawp/factory';
import {processorTypesPropType} from './propTypes';

const MainSection = ({title, className, children}) => (
	<div
		className={className}
	>
		<h2>{title}</h2>
		{children}
	</div>
);


export class FormEditor extends Component {
	state = {
		activeTab: 'processors',
		newProcessorType: 'mailer', //the next processor to be created will use this type
	};

	onSetTab = activeTab => {
		this.setState({activeTab});
	};

	updateProcessors = processors => {
		const {updateForm, form} = this.props;
		updateForm({
			...form,
			processors
		});
	};

	getFormProcessors = () => {
		const {form} = this.props;
		return form.processors ? form.processors : [];
	};

	getFormFields = () => {
		const {form} = this.props;
		return form.fields ? form.fields : [];
	};

	tabs = [
		{
			name: 'editor',
			title: 'Layout',
			className: 'caldera-forms-editor-layout-tab-btn',
			classNameForComponent: 'caldera-forms-editor-layout'
		},
		{
			name: 'processors',
			title: 'Processors',
			className: 'caldera-forms-editor-processors-tab-btn',
			classNameForComponent: 'caldera-forms-editor-processors'

		},
		{
			name: 'Mailer',
			title: 'mailer',
			className: 'caldera-forms-editor-mailer-tab-btn',
			classNameForComponent: 'caldera-forms-editor-mailer'
		},
		{
			name: 'settings',
			title: 'Settings',
			className: 'caldera-forms-editor-settings-tab-btn',
			classNameForComponent: 'caldera-forms-editor-settings'

		},
	];


	setNewProcessorType = (newProcessorType) => this.setState({newProcessorType});

	render() {
		const {form, processorTypes, updateForm} = this.props;
		return (
			<div>
				<Row>
					<Column>
						<p>{form.name}</p>
					</Column>
				</Row>
				<TabPanel
					className="caldera-processor"
					activeClass="active-tab"
					onSelect={this.onSetTab}
					initialTabName={'processors'}
					tabs={this.tabs}
				>
					{tab => {
						const {name, classNameForComponent, title} = tab;
						if ('processors' === name) {
							return (
								<MainSection
									className={classNameForComponent}
									title={title}
								>
									<Processors
										processorTypes={processorTypes}
										processors={this.getFormProcessors()}
										form={form}
										formFields={this.getFormFields()}
										updateProcessors={this.updateProcessors}
									/>
								</MainSection>
							);
						}
						if ('settings' === name) {
							const nameField = {
								fieldType: 'text',
								value: form.name,
								label: 'Form Name',
								fieldId: 'formName',
								required: true,
							};
							return (
								<MainSection
									className={classNameForComponent}
									title={title}
								>
									{fieldAreaFactory(
										nameField,
										(name) => {
											updateForm({
												...form,
												name
											})
										}
									)}
								</MainSection>
							)
						}
						return (
							<MainSection
								className={classNameForComponent}
								title={title}
							>
								{tab.title}
							</MainSection>
						);
					}}
				</TabPanel>
			</div>
		);
	}
}


FormEditor.propTypes = {
	processorsTypes: processorTypesPropType,
	updateForm: PropTypes.func,
	form: PropTypes.shape({
		id: PropTypes.string,
		name: PropTypes.string,
		fields: PropTypes.array,
		conditionals: PropTypes.array,
		settings: PropTypes.array,
		processors: processorsCollectionPropType,
	}),
};

