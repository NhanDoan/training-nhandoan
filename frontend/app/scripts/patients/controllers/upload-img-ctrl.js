'use strict';
  /**
  *  Module
  *
  * Description
  */
angular
  .module('app')
  .controller('UploadPictureCtrl', ['$scope', '$modalInstance', function ($scope, $modalInstance) {
    $scope.closeUpload = function() {
      console.log('test');
      $modalInstance.dismiss('cancel');
    };
    $scope.savePicture = function () {
      $modalInstance.dismiss();
    };
  }
]);
