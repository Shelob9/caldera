'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.HorizontalForm = undefined;

var _HorizontalForm$propT;

var _react = require('react');

var _react2 = _interopRequireDefault(_react);

var _propTypes = require('prop-types');

var _propTypes2 = _interopRequireDefault(_propTypes);

var _forms = require('@calderawp/forms');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * Displays a form, one field per row
 *
 * @param fields
 * @param initialValues
 * @param onClose
 * @param onChange
 * @param instanceId
 * @return {*}
 * @constructor
 */
var HorizontalForm = exports.HorizontalForm = function HorizontalForm(_ref) {
	var fields = _ref.fields,
	    initialValues = _ref.initialValues,
	    onClose = _ref.onClose,
	    onChange = _ref.onChange,
	    instanceId = _ref.instanceId,
	    conditionals = _ref.conditionals;

	console.log(fields);
	var rows = [];
	var i = 0;
	fields.forEach(function (field) {
		rows.push({
			rowId: instanceId + '-' + i,
			columns: [{
				columnId: 'c-' + instanceId + '-' + i,
				fields: [field],
				width: '1'
			}]
		});
		i++;
	});
	var form = {
		id: 'horizontal-form-' + instanceId,
		fields: fields,
		rows: rows,
		conditionals: conditionals
	};

	return _react2.default.createElement(
		_react.Fragment,
		null,
		_react2.default.createElement(_forms.CalderaForm, {
			form: form,
			initialValues: initialValues,
			onSubmit: onClose,
			onChange: onChange
		})
	);
};

HorizontalForm.propTypes = (_HorizontalForm$propT = {
	fields: _propTypes2.default.array,
	initialValues: _propTypes2.default.object,
	onSubmit: _propTypes2.default.func,
	onChange: _propTypes2.default.func,
	onBlur: _propTypes2.default.func,
	onClose: _propTypes2.default.func
}, _defineProperty(_HorizontalForm$propT, 'initialValues', _propTypes2.default.object), _defineProperty(_HorizontalForm$propT, 'conditionals', _propTypes2.default.array), _HorizontalForm$propT);

HorizontalForm.defaultProps = {
	fields: [],
	initialValues: {},
	conditionals: []
};