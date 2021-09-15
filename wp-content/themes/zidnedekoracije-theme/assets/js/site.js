'use strict';

$ = require('jquery');

const Navigation = require('./core/navigation');
const example = require('./site/example');

jQuery( function(){

  /**
   * Initialize site navigation
   */
  Navigation.init();

  /**
   * Initialize sample module
   */
  example.init();

});