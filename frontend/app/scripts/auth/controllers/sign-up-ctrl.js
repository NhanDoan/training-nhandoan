'use strict';

angular
	.module('frontEndApp')
	.controller('auth.signUpCtrl',[
		'$scope',
		'$modal',
		'$cookieStore',
		function ($scope, $modal, $cookieStore) {

///////////////////////////////////////////////////////////////////////////////////////
	var _isSignUp = false,
			modalSignUp = function() {
				$modal.open({
					templateUrl: 'views/directives/modals/sign-up.html',
					windowClass: 'login-register',
					controller: signUpModalInstanceCtrl
				});
			};

	$scope.open = function (isShow) {
		_isSignUp = isShow;
		modalSignUp();
	};

	var signUpModalInstanceCtrl = [
			'$scope',
			'$timeout',
			'restAngular',
			'$modalInstance',
		 	function ($scope, $timeout, restAngular, $modalInstance) {

		 		$scope.userLogin = {};
		 		$scope.userSignUp = {};
				$scope.isSignUp = _isSignUp;

				$scope.toggleForm = function (isShow) {
					$timeout(function() {
						$scope.isSignUp = isShow;
					}, 100);
				};

				$scope.doLogin = function () {
					var restLogin = restAngular.one('users/login');

					restLogin.post($scope.userLogin)
						.then(function (results) {
							// success
							$modalInstance.dismiss();
							$cookieStore.put('eTherapiToken', $scope.userLogin);

						});
				};

				$scope.onChooseTypeOfuser = function (type) {
					$scope.userSignUp.user_type = type;
				};

				$scope.doSignUp = function () {
					var signUpPromise = restAngular.one('users/sign_up').post($scope.userSignUp);

					signUpPromise.then(function (data) {
						

					});
				}
			}
		];

///////////////////////////////////////////////////////////////////////////////////////
		}
	])