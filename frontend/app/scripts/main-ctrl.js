'use strict';

angular
	.module('app')
	.controller('MainCtrl', [
		'$scope',
		'restAngular',
		function($scope, restAngular) {
			restAngular.all('posts').getList().then(function(data) {
				console.log('data:', data);
			});

			///////////////////////////////////////////////////////////////////////////////////////
			// TODO:: handle event errors
			$scope.$on('errorGlobal.handle', function(data) {
				// code here
				console.log(data);
			});

			///////////////////////////////////////////////////////////////////////////////////////
		}
	]);
