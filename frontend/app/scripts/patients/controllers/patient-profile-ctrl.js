'use strict';
angular
  .module('app')
  .controller('getOption', [
    '$scope', '$http',
    function($scope, $http) {
      console.log('test');
      $scope.update = function() {
        $http.get('/patient-edit-profile').success(function(data) {
          $scope.phones = data;
        });
      };
      $scope.addPhone = function() {
        $http.post('/patient-edit-profile', {'name': 'New Phone 1', 'data': 'Nhan Doan'}).success(function() {
          $scope.update();
        });
      };
      $scope.update();
    }
  ])
  .controller('patientProfileCtrl', [
    '$scope',
    '$document',
    '$modal',
    'Restangular',
    function($scope, $document, $modal, Restangular) {

      // var overrideBaseURL = Restangular.withConfig(function(RestangularConfigurer) {
      //   RestangularConfigurer.setBaseUrl('http://training.angular.com:3000');
      // });

      $scope.updateProfile = {};
      $scope.uploadPicture = function() {
        $modal.open({
          templateUrl: 'templates/directives/modals/upload-picture.html',
          controller: 'UploadPictureCtrl'
        });
      };

      $scope.addInsurance = function() {
        $modal.open({
          templateUrl: 'templates/directives/modals/add-insurance.html',
          controller: 'AddInsurance'
        });
      };
      $scope.doSaveProfile = function() {
        console.log($scope.updateProfile);
      };
      $scope.open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = true;
      };
      $scope.dateOptions = {
        format: 'mm/dd/yyyy',
        startingDay: 1,
        showWeeks:'false',
      };

    }
  ]);
      // var uploadPictureCtrl = [
      //   '$scope',
      //   '$modal',
      //   '$modalInstance',
      //   function($scope,$modalInstance) {
      //     $scope.closeUpload = function() {
      //       console.log('test');
      //       $modalInstance.dismiss('');
      //     };
      //     // $scope.firstName = "Nhan";
      //     // $scope.lastName = "Doan";
      //     // $scope.gender = "Male";
      //     // $scope.birthday= "10/06/1989";
      //     // $scope.mail = "ngocnhan@gmail.com";
      //     // $scope.phone= "123456789";
      //     // $scope.address = "Nui Thanh";
      //     // $scope.city = "";
      //     // $scope.state = "";
      //     // $scope.zipCode = "";
      //     // $scope.country = "";
      //     // $scope.timezone = "";
      //     // $scope.fullName = "";
      //     // $scope.contactPhone = "";
      //     // $scope.insurance = [{status: "Verified"},{insuranceName: "Bluecross"},{insuranceId: "xxxx-xxx-4324"}, {planName: "PDD 20"}];
      //     // $scope.relevantMedicalHistory = "";
      //     $scope.savePicture = function() {
      //       // console.log($scope.updateProfile);
      //     };


      //   }
      // ];
