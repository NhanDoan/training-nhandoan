'use strict';
// Restangular service that uses Bing
angular
	.module('common')
	.factory('restAngular', [
		'$rootScope',
		'Restangular',
		'$cookieStore',
		'ENV',
		function($rootScope, Restangular, $cookieStore, ENV) {
			return Restangular.withConfig(function(RestangularConfigurer) {
				// base url
				RestangularConfigurer.setBaseUrl(ENV.apiEndpoint);

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
