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
				'$rootScope',
				'$scope',
				'$timeout',
				'restAngular',
				'$modalInstance',
				function($rootScope, $scope, $timeout, restAngular, $modalInstance) {

					$scope.userLogin = {};
					$scope.userSignUp = {};
					$scope.isSignUp = _isSignUp;
					$scope.userSignUp.user_type = "patient";

					// toggle form sign up / login / reset password
					$scope.toggleForm = function(isShow) {
						$timeout(function() {
							$scope.isSignUp = isShow;
						}, 100);
					};

					// choose user type account
					$scope.onChooseTypeOfuser = function(type) {
						$scope.userSignUp.user_type = type;
					};

					// handle login form
					$scope.doLogin = function() {
						var restLogin = overrideBaseURL.one('login').get($scope.userLogin);

						restLogin.then(function (data) {
							if (data.user) { // login success
								$rootScope.isLogin = true;
								$rootScope.user = data.user;
								$cookieStore.put('eTherapiToken', data.user);	
								$modalInstance.dismiss(); // close modal form when login success
							} else { // error
								$rootScope.isLogin = false;
								$rootScope.message = data.message;
							}
						}, function (error) {
							// handle error server response
							console.log('error form server: ', error);
						});
					};

					// handle sign up formS	
					$scope.doSignUp = function() {
						var signUpPromise = overrideBaseURL.one('sign_up').customPOST({ user: $scope.userSignUp });

						signUpPromise.then(function (data) {
							if (data.ok === '0') {	// sign up success
								$rootScope.$broadcast('handle:message', data);
								$modalInstance.dismiss(); // close modal form when sign up success
							} else { // error
								$scope.errMessage = data.message
								console.log('message error: ', data.message);
								$scope.status = data.ok;
							}
						}, function (error) {
							// TODO:: handle error server response
							console.log('error from server: ', error);
						});
					};
				}
			];

			///////////////////////////////////////////////////////////////////////////////////////
		}
	]);
