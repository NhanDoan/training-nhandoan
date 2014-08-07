'use strict';

angular
	.module('app')
	.controller('MainCtrl', [
		'$rootScope',
		'$scope',
		'restAngular',
		'$cookieStore',
		'$timeout',
		function($rootScope, $scope, restAngular, $cookieStore, $timeout) {
			///////////////////////////////////////////////////////////////////////////////////////
			// TODO:: handle event message
			$scope.$on('handle:message', function (event, data) {
				// $scope.message = data.message.email;
				// $scope.status = data.ok;
			});
			///////////////////////////////////////////////////////////////////////////////////////

			// handle logout
			$scope.logout = function () {
				var token = $cookieStore.get('eTherapiToken');
				if (token) {
					$cookieStore.remove('eTherapiToken');
					$rootScope.isLogin = false;	
				} 
			}
		}
	]);
