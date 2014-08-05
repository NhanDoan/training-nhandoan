'use strict';
// Restangular service that uses Bing
angular
	.module('common')
	.factory('restAngular', [
		'$rootScope',
		'Restangular',
		'$cookieStore',
		'appSettings',
		function($rootScope, Restangular, $cookieStore, appSettings) {
			return Restangular.withConfig(function(RestangularConfigurer) {
				// base url
				RestangularConfigurer.setBaseUrl(appSettings.apiUrl);

				// add token
				// RestangularConfigurer.setDefaultHeaders({
				// 	token: $cookieStore.get('eTherapiToken')
				// });
				// RestangularConfigurer.addResponseInterceptor(function(data, operation, what, url, response, deferred) {
					// return data;
					// $rootScope.$broadcast(
					// 	'errorGlobal.handle',
					// 	{
					// 		status: response.status,
					// 		message: response.message
					// 	}
					// );
				// });

			});
		}
	]);
