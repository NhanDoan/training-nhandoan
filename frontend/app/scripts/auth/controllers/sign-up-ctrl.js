'use strict';

angular
	.module('auth')
	.controller('auth.signUpCtrl',[
		'$scope',
		'$modal',
		function ($scope, $modal) {

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
			'$modalInstance',
			'$timeout',
		 	function ($scope, $modalInstance, $timeout) {
				$scope.isSignUp = _isSignUp;

				$scope.toggleForm = function (isShow) {
					$timeout(function() {
						$scope.isSignUp = isShow;
					}, 100);
				}

			}
		];

///////////////////////////////////////////////////////////////////////////////////////
		}
	])