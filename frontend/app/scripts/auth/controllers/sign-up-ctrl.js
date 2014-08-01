'use strict';

angular
	.module('auth')
	.controller('auth.signUpCtrl',[
		'$scope',
		'$modal',
		function ($scope, $modal) {

///////////////////////////////////////////////////////////////////////////////////////

	$scope.open = function (size) {

		var modalSignUp = $modal.open({
			templateUrl: 'views/directives/modals/sign-up.html',
			windowClass: 'login-register',
			controller: function() {
				
			},
			size: size
		});
	};

///////////////////////////////////////////////////////////////////////////////////////
		}
	])