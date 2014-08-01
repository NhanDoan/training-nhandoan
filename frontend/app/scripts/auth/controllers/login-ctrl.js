'use strict';

angular
	.module('auth')
	.controller('auth.loginCtrl',[
		'$scope',
		'$modal',
		function ($scope, $modal) {

///////////////////////////////////////////////////////////////////////////////////////

	$scope.open = function (size) {
		var modalSignUp = $modal.open({
			templateUrl: 'views/directives/modals/login.html',
			windowClass: 'login-register',
			controller: function() {

			},
			size: size
		});
	};

///////////////////////////////////////////////////////////////////////////////////////
		}
	])