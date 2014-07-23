'use strict';

/**
 * @ngdoc overview
 * @name wwwApp
 * @description
 * # wwwApp
 *
 * Main module of the application.
 */
angular
  .module('wwwApp', ['ngRoute']).config([
    '$routeProvider',
    function($routeProvider) {
      $routeProvider
          .when('/myroute', {
          templateUrl: 'views/myroute.html',
          controller: 'MyrouteCtrl'
        });
    }]);

