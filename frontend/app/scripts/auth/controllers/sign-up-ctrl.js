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
		 	function ($scope, $timeout, restAngular) {
		 		var auth = restAngular.all('users/login');

		 		$scope.userLogin = {};
				$scope.isSignUp = _isSignUp;

				$scope.toggleForm = function (isShow) {
					$timeout(function() {
						$scope.isSignUp = isShow;
					}, 100);
				}

				$scope.doLogin = function () {
					console.log($scope.userLogin);
					auth.post()
						.then(function (results) {
							$cookieStore.put('eTherapiToken', $scope.userLogin);
						});
				}
			}
		];

///////////////////////////////////////////////////////////////////////////////////////
		}
	])