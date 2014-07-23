'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:MyrouteCtrl
 * @description
 * # MyrouteCtrl
 * Controller of the wwwApp
 */
angular.module('wwwApp')
  .controller('MyrouteCtrl', function ($scope, $http) {

    $http.jsonp('http://awsratecloud.mortech-inc.com/servlet/MarketplaceServlet?loanAmount=200000&stateAbbr=CApropertyValue=200000&licenseKey=k98fLwDVYaaNRy%2F5IN0fciIaEgce4YwK7q8aU%2FWKfH4%3D&marketplaceId=10000&showVA=1&lender=17nbkc01&lender=17kans01&lender=17nasb01&lender=37gpnm01&lender=05harb01&callback=JSON_CALLBACK').success(function(data) {
      console.log(data);
      $scope.phones = data;
    });
  });
