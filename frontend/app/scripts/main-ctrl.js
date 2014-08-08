'use strict';

angular
	.module('app')
	.controller('MainCtrl', [
		'$rootScope',
		'$scope',
		'restAngular',
		'$cookieStore',
		'$timeout',
		'Restangular',
    'ENV',
		function($rootScope, $scope, restAngular, $cookieStore, $timeout, Restangular, ENV) {
			var overrideBaseURL = Restangular.withConfig(function(RestangularConfigurer) {
					RestangularConfigurer.setBaseUrl(ENV.apiEndpoint);
				});

			///////////////////////////////////////////////////////////////////////////////////////
			// TODO:: handle event message
			$scope.$on('handle:message', function (event, data) {
				// $scope.message = data.message.email;
				// $scope.status = data.ok;
			});
			///////////////////////////////////////////////////////////////////////////////////////

			// handle logout (It's remove later)
			$scope.logout = function () {
				var logoutPromise = overrideBaseURL.one('logout').get();
				logoutPromise.then(function (resp) {
					if (resp.ok === 0) {
						$cookieStore.remove('eTherapiToken');
						$rootScope.isLogin = false;
						$rootScope.msgLogout = resp.message;
					} else {
						$rootScope.isLogin = true;
						$rootScope.msgLogout = resp.message;
					}
				}, function (error) {
					// TODO:: handle error
					console.log('An error occurred ', error.statusText);
				});

			};
		}
	]);
