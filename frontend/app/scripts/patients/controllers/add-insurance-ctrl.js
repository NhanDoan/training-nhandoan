'use strict';

/**
*  Module
*
* Description
*/
angular.module('app')
  .controller('AddInsurance', ['$scope', '$modalInstance', function ($scope, $modalInstance) {
      $scope.insurance = {};
      $scope.insurance.birthdate = new Date();
      $scope.closeAdd = function() {
        $modalInstance.dismiss('cancel');
      };

      $scope.opened = false;
      $scope.openDate = function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = true;
        console.log('teddddst');
      };
      $scope.dateOptions = {
        startingDay: 1,
        showWeeks:'false',
      };

    }
  ]);
