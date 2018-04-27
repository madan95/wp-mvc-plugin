'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Ajax_action = function Ajax_action(selector) {
  _classCallCheck(this, Ajax_action);

  this.$selector = selector;
  console.log('yess working');
  console.log(this.$selector);
};

exports.default = Ajax_action;