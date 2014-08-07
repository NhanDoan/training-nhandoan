'use strict';

angular
	.module('app')
	.controller('MainCtrl', [
		'$scope',
		'restAngular',
    'ENV',
		function($scope, restAngular, ENV) {
			restAngular.all('posts').getList().then(function(data) {
				console.log('data:', data, ENV);
			});

			// TODO:: handle event errors
			$scope.$on('errorGlobal.handle', function(data) {
				// code here
				console.log(data);
			});

		}
	]);
