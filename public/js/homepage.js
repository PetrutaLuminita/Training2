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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/homepage.js":
/*!**********************************!*\
  !*** ./resources/js/homepage.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var $products_table = $('#products-table');
  showProductsPage();

  function addToCart(productId) {
    $.ajax({
      type: 'GET',
      url: '/add_to_cart/' + productId
    }).done(function (response) {
      console.log(response);
    });
  }

  function removeFromCart(productId) {
    $.ajax({
      type: 'GET',
      url: '/remove_from_cart/' + productId
    }).done(function (response) {
      console.log(response);
    });
  }

  function showProductsPage() {
    $.ajax({
      type: 'GET',
      url: '/get_products'
    }).done(function (products) {
      var page = 'index';
      show(products, page);
    });
  }

  function showCartPage() {
    $.ajax({
      type: 'GET',
      url: '/cart'
    }).done(function (products) {
      var page = 'cart';
      show(products, page);
    });
  }

  function show(products, page) {
    $products_table.empty();
    $('#change-page').remove();

    if (products.length === 0) {
      $products_table.append("\n                <div>There are no products</div>\n            ");
    }

    products.forEach(function (product) {
      if (product.image === '') {
        product.image = '/img/missing-image.png';
      }

      var $table_row = $('<tr>').append("\n                <td class=\"align-middle\">\n                    <img src=\"".concat(product.image, "\" alt=\"-\">\n                </td>\n                        \n                <td class=\"align-middle\">\n                    <h5 class=\"font-weight-bold mb-2\">").concat(product.title, "</h5>\n\n                    <div class=\"font-weight-normal mb-2\">").concat(product.description, "</div>\n\n                    <div class=\"font-italic\">").concat(product.price, "</div>\n                </td>\n            "));
      var $btn = $('<buttton class="btn btn-primary">').html(page === 'index' ? 'Add to cart' : 'Remove from cart').on('click', function () {
        page === 'index' ? addToCart(product.id) : removeFromCart(product.id);
        $table_row.remove();
      });
      $table_row.append($('<td class="text-center align-middle to-center">').append($btn));
      $products_table.append($table_row);
    });
    setChangeBtn(page);
  }

  function setChangeBtn(page) {
    $products_table.after($('<button id="change-page" class="btn btn-primary">').html(page === 'index' ? "Go to cart" : 'Show products'));
    $('#change-page').on('click', function () {
      if (page === 'index') {
        showCartPage();
      } else {
        showProductsPage();
      }
    });
  }
});

/***/ }),

/***/ 1:
/*!****************************************!*\
  !*** multi ./resources/js/homepage.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! E:\WEB_WORK\code\Training2\resources\js\homepage.js */"./resources/js/homepage.js");


/***/ })

/******/ });