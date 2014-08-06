'use strict';

angular
	.module('app')
	.controller('auth.signUpCtrl', [
		'$scope',
		'$modal',
		'$cookieStore',
    'Restangular',
		function($scope, $modal, $cookieStore, Restangular) {
			var overrideBaseURL = Restangular.withConfig(function(RestangularConfigurer) {
				RestangularConfigurer.setBaseUrl('http://localhost:3000');
			});

			///////////////////////////////////////////////////////////////////////////////////////
			var _isSignUp = false,
				modalSignUp = function() {
					$modal.open({
						templateUrl: 'templates/directives/modals/sign-up.html',
						windowClass: 'login-register',
						controller: signUpModalInstanceCtrl
					});
				};

			$scope.open = function(isShow) {
				_isSignUp = isShow;
				modalSignUp();
			};

			var signUpModalInstanceCtrl = [
				'$scope',
				'$timeout',
				'restAngular',
				'$modalInstance',
				function($scope, $timeout, restAngular, $modalInstance) {

					$scope.userLogin = {};
					$scope.userSignUp = {};
					$scope.isSignUp = _isSignUp;
					$scope.userSignUp.user_type = "patient";

					$scope.toggleForm = function(isShow) {
						$timeout(function() {
							$scope.isSignUp = isShow;
						}, 100);
					};

					$scope.doLogin = function() {
						var restLogin = overrideBaseURL.one('login').get($scope.userLogin);

						restLogin.then(function(results) {
							// success
							console.log('DONE::', results);

							$modalInstance.dismiss();
							$cookieStore.put('eTherapiToken', $scope.userLogin);

						});
					};

					$scope.onChooseTypeOfuser = function(type) {
						$scope.userSignUp.user_type = type;
					};

					$scope.doSignUp = function() {
						var signUpPromise = overrideBaseURL.one('sign_up').customPOST({ user: $scope.userSignUp });

						signUpPromise.then(function(data) {
							console.log('DONE', data);
						});
					};
				}
			];

			///////////////////////////////////////////////////////////////////////////////////////
		}
	]);
