'use strict';

/**
 * @ngdoc function
 * @name wwwApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the wwwApp
 */
var myModule = angular.module('wwwApp', []);

myModule.value('clientId', 'a12345654321x');

myModule.constant('planetName', 'Greasy Giant');

myModule.controller('FilterController', ['filterFilter', function (filterFilter) {
  this.array = [
    {name: 'Tobias'},
    {name: 'Jeff'},
    {name: 'Brian'},
    {name: 'Igor'},
    {name: 'James'},
    {name: 'Brad'}
  ];
  this.filteredArray = filterFilter(this.array, 'a');
}]);
myModule.controller('MainCtrl', function ($scope) {
  $scope.awesomeThings = [
    'HTML5 Boilerplate',
    'AngularJS',
    'Karma',
  ];
});

myModule.controller('SimpleFormController', ['$scope', function ($scope) {
    $scope.master = {};
    $scope.save = function (user) {
      $scope.master = angular.copy(user);

    };

    $scope.reset = function () {
      $scope.user = angular.copy($scope.master);
    };
    $scope.reset();
  }]);

// spectial purpost object
myModule.directive('myPlanet', [ 'planetName', function (planetName) {
  return {
    restrict: 'E',
    link: function ($scope, $element) {
      $element.text('Planet: '+ planetName);
    }
  };
}]);
myModule.controller('DemoController', ['clientId', 'planetName', function DemoController(clientId, planetName) {
  this.clientId = clientId;
  this.planetName = planetName;
}]);
