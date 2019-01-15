'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.HorizontalForm = undefined;

var _react = require('react');

var _react2 = _interopRequireDefault(_react);

var _propTypes = require('prop-types');

var _propTypes2 = _interopRequireDefault(_propTypes);

var _forms = require('@calderawp/forms');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var HorizontalForm = exports.HorizontalForm = function HorizontalForm(_ref) {
	var fields = _ref.fields,
	    initialValues = _ref.initialValues,
	    onClose = _ref.onClose,
	    onChange = _ref.onChange,
	    onBlur = _ref.onBlur,
	    instanceId = _ref.instanceId;

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
	return _react2.default.createElement(
		_react.Fragment,
		null,
		_react2.default.createElement(_forms.CalderaForm, {
			formRows: rows,
			initialValues: initialValues,
			onSubmit: onClose,
			onChange: onChange,
			onBlur: onBlur
		})
	);
};

HorizontalForm.propTypes = _defineProperty({
	fields: _propTypes2.default.array,
	initialValues: _propTypes2.default.object,
	onSubmit: _propTypes2.default.func,
	onChange: _propTypes2.default.func,
	onBlur: _propTypes2.default.func,
	onClose: _propTypes2.default.func
}, 'initialValues', _propTypes2.default.object);

var _noop = function _noop() {};
HorizontalForm.defaultProps = {
	fields: {},
	onSubmit: _noop,
	onChange: _noop,
	onBlur: _noop,
	initialValues: {}
};