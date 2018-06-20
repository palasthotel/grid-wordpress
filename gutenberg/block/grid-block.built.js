/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Gutenpride
 * A gutenberg block that displays a powered by Gutenberg message
 */

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;
var TermTreeSelect = wp.blocks.TermTreeSelect;


var label = __('This post proudly created in');

// https://github.com/WordPress/gutenberg/blob/master/editor/components/block-list/index.js#L21
// https://github.com/WordPress/gutenberg/blob/master/docs/block-api.md
// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
// https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks/

var Grid = function () {
	function Grid() {
		_classCallCheck(this, Grid);

		this._clicked = 0;
	}

	_createClass(Grid, [{
		key: 'render',
		value: function render() {
			return wp.element.createElement(
				'div',
				null,
				'This will be a GRID',
				wp.element.createElement(
					'a',
					{ onClick: this.clicked.bind(this) },
					'Click me! I was clicked ',
					this._clicked,
					' times'
				)
			);
		}
	}, {
		key: 'clicked',
		value: function clicked() {
			this._clicked++;
		}
	}]);

	return Grid;
}();

var grid = null;

registerBlockType('palasthotel/the-grid', {
	title: 'Grid',
	icon: 'grid-view',
	category: 'layout',
	// only one grid per post allowed
	useOnce: true,
	// do not edit render html of grid in editor
	html: false,
	edit: function edit(props) {

		if (grid == null) grid = new Grid();

		return grid.render();
	},
	save: function save(props) {
		return wp.element.createElement(
			'div',
			null,
			'This will be a GRID save'
		);
	}
});

registerBlockType('palasthotel/the-grid__posts', {
	title: 'Posts',
	icon: 'grid-view',
	category: 'grid-view',
	// do not edit render html of grid in editor
	html: false,
	edit: function edit(props) {

		return wp.element.createElement(
			'p',
			null,
			'Grid box with posts'
		);
	},
	save: function save(props) {
		return wp.element.createElement(
			'div',
			null,
			'Grid box with posts'
		);
	}
});

/***/ })
/******/ ]);