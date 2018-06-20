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
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var React = wp.element;
var Component = React.Component;

/**
 * Gutenpride
 * A gutenberg block that displays a powered by Gutenberg message
 */

var __ = wp.i18n.__;
var registerBlockType = wp.blocks.registerBlockType;


var Grid = [];
window.Grid = Grid;
setInterval(function () {
    // TODO: please find a more efficient way
    Grid.forEach(function (container) {
        return container.updateIndex();
    });
}, 300);

// https://github.com/WordPress/gutenberg/blob/master/editor/components/block-list/index.js#L21
// https://github.com/WordPress/gutenberg/blob/master/docs/block-api.md
// https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
// https://wordpress.org/gutenberg/handbook/blocks/creating-dynamic-blocks/

var GutenbergGridContainer = function (_Component) {
    _inherits(GutenbergGridContainer, _Component);

    function GutenbergGridContainer(props) {
        _classCallCheck(this, GutenbergGridContainer);

        var _this = _possibleConstructorReturn(this, (GutenbergGridContainer.__proto__ || Object.getPrototypeOf(GutenbergGridContainer)).apply(this, arguments));

        _this.state = {
            index: 0
        };
        return _this;
    }

    _createClass(GutenbergGridContainer, [{
        key: "componentDidMount",
        value: function componentDidMount() {
            Grid.push(this);
        }
    }, {
        key: "componentWillUnmount",
        value: function componentWillUnmount() {
            Grid = Grid.filter(function (container) {
                return container.el !== null;
            });
        }
    }, {
        key: "getIndex",
        value: function getIndex() {
            var _this2 = this;

            var myIndex = undefined;
            var containers = document.querySelectorAll(".grid-container");
            containers.forEach(function (container, index) {
                if (container.isSameNode(_this2.el)) {
                    myIndex = index;
                }
            });
            return myIndex;
        }
    }, {
        key: "updateIndex",
        value: function updateIndex() {
            this.setState({ index: this.getIndex() });
        }
    }, {
        key: "render",
        value: function render() {
            var _this3 = this;

            var index = this.state.index;

            return React.createElement(
                "div",
                { ref: function ref(el) {
                        return _this3.el = el;
                    }, className: "grid-container" },
                index,
                " This will be a GRID Container type ",
                this.props.type
            );
        }
    }]);

    return GutenbergGridContainer;
}(Component);

var container_icon = function container_icon(columns, type) {
    var grid_slots = type.split('-');
    var slot_gap = 2;
    var width = 60 - (parseInt(columns) - 1) * slot_gap;
    var rects = [];
    var x = 0;
    for (var i = 0; i < columns; i++) {
        var slot_width = 0;
        slot_width = grid_slots[i].replace(/d/g, '/');
        var numbers = slot_width.split('/');
        slot_width = parseInt(numbers[0]) / parseInt(numbers[1]) * width;
        rects.push(React.createElement("rect", { x: x, fill: "silver", width: slot_width, height: "100%" }));
        x = x + slot_width + slot_gap;
    }
    return React.createElement(
        "svg",
        { xmlns: "http://www.w3.org/2000/svg", style: { width: "100%" } },
        rects
    );
};

GridGutenberg.containertypes.forEach(function (containertype) {
    var icon_type = containertype.type.replace("c-", "");
    var name = icon_type.replace(/d/g, '/');
    registerBlockType('palasthotel/the-grid-container-' + containertype.type, {
        title: 'Grid Container ' + name,
        icon: container_icon(containertype.numslots, icon_type),
        category: 'layout',
        // do not edit render html of grid in editor
        html: false,
        edit: function edit(props) {
            return React.createElement(GutenbergGridContainer, { type: containertype.type });
        },
        save: function save(props) {
            return React.createElement(
                "div",
                null,
                "This will be a GRID Container save // TODO maybe render in php like dynamic block"
            );
        }
    });
});

/***/ })
/******/ ]);
//# sourceMappingURL=grid-block.built.map