'use strict';
angular
  .module('app')
  .controller('patientProfileCtrl', [
    '$scope',
    '$document',
    '$modal',
    'Restangular',
    function($scope, $document, $modal, Restangular) {

      var overrideBaseURL = Restangular.withConfig(function(RestangularConfigurer) {
        RestangularConfigurer.setBaseUrl('http://training.angular.com:3000');
      });

      $scope.uploadPicture = function() {
        $modal.open({
          templateUrl: 'templates/directives/modals/upload-picture.html',
          controller: uploadPictureCtrl
        });
      };
      $scope.updateProfile = {};
      $scope.doSaveProfile = function() {
      };
      var uploadPictureCtrl = [
        '$scope',
        function($scope) {

          // $scope.firstName = "Nhan";
          // $scope.lastName = "Doan";
          // $scope.gender = "Male";
          // $scope.birthday= "10/06/1989";
          // $scope.mail = "ngocnhan@gmail.com";
          // $scope.phone= "123456789";
          // $scope.address = "Nui Thanh";
          // $scope.city = "";
          // $scope.state = "";
          // $scope.zipCode = "";
          // $scope.country = "";
          // $scope.timezone = "";
          // $scope.fullName = "";
          // $scope.contactPhone = "";
          // $scope.insurance = [{status: "Verified"},{insuranceName: "Bluecross"},{insuranceId: "xxxx-xxx-4324"}, {planName: "PDD 20"}];
          $scope.relevantMedicalHistory = "";
          $scope.savePicture = function() {
            // console.log($scope.updateProfile);
          };


        }
      ];
    }


  ]);
