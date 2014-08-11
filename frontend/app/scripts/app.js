'use strict';

/**
 * @ngdoc overview
 * @name app
 * @description
 * # app
 *
 * Main module of the application.
 */
angular
	.module('app', [
		'ngCookies',
		'ui.router',
		'ui.bootstrap',
    'config',
		'common',
		'restangular',
    'ngMockE2E',
    'angular-data.DSCacheFactory',
    'ui.select2'
	])
	.config([
		'$stateProvider',
		'$urlRouterProvider',
		'$locationProvider',
		'$httpProvider',
    'ENV',
    '$provide',
		function($stateProvider, $urlRouterProvider, $locationProvider, $httpProvider, ENV, $provide) {
			// fix cross domain Ajax call
			$httpProvider.defaults.headers.common['X-CSRF-Token'] = angular.element('meta[name=csrf-token]').attr('content');
			// $urlRouterProvider.otherwise('/');
			$stateProvider

			//////////////////////////////////////////////////////////////////////////
			// home page
			//////////////////////////////////////////////////////////////////////////

			.state('home', {
				url: '/',
				views: {
					'': {
						templateUrl: 'templates/home.html'
					},
					'header@home': {
						templateUrl: 'templates/commons/header.html'
					},
					'sidebar@home': {
						templateUrl: 'templates/commons/sidebar.html'
					},
					'footer@home': {
						templateUrl: 'templates/commons/footer.html'
					}
				}
			})
				.state('appointment', {
					url: '/appointment',
					views: {
						'': {
							templateUrl: 'templates/therapist.html'
						},
						'header@appointment': {
							templateUrl: 'templates/commons/header.html'
						},
						'sidebar@appointment': {
							templateUrl: 'templates/commons/sidebar.html'
						},
						'footer@appointment': {
							templateUrl: 'templates/commons/footer.html'
						}
					}
				})
				.state('profile', {
					url: '/profile',
					views: {
						'': {
							templateUrl: 'templates/commons/profile.html'
						},
						'header@profile': {
							templateUrl: 'templates/commons/header.html'
						},
						'sidebar@profile': {
							templateUrl: 'templates/commons/sidebar.html'
						},
						'footer@profile': {
							templateUrl: 'templates/commons/footer.html'
						}
					}
				})
				.state('therapist-account', {
					url: '/therapist-account',
					views: {
						'': {
							templateUrl: 'templates/commons/therapist-account.html'
						},
						'header@therapist-account': {
							templateUrl: 'templates/commons/header.html'
						},
						'sidebar@therapist-account': {
							templateUrl: 'templates/commons/sidebar.html'
						},
						'footer@therapist-account': {
							templateUrl: 'templates/commons/footer.html'
						}
					}
				})
        .state('patient-edit-profile', {
          url: '/patient-edit-profile',
          views: {
            '': {
              templateUrl: 'templates/commons/patient-edit-profile.html'
            },
            'header@patient-edit-profile': {
              templateUrl: 'templates/commons/header.html'
            },
            'sidebar@patitent-edit-profile': {
              templateUrl: 'templates/commons/sidebar.html'
            },
            'footer@patitent-edit-profile': {
              templateUrl: 'templates/commons/footer.html'
            }
          }
        })
				.state('therapist-edit-profile', {
					url: '/therapist-edit-profile',
					views: {
						'': {
							templateUrl: 'templates/commons/therapist-edit-profile.html'
						},
						'header@therapist-edit-profile': {
							templateUrl: 'templates/commons/header.html'
						},
						'sidebar@therapist-edit-profile': {
							templateUrl: 'templates/commons/sidebar.html'
						},
						'footer@therapist-edit-profile': {
							templateUrl: 'templates/commons/footer.html'
						}
					}
				});

        if(ENV.name !== 'development') {
			    // enable pushState
			    $locationProvider.html5Mode(true);
        }
			//////////////////////////////////////////////////////////////////////////
		}
	])

.run(['$rootScope',
	'$state',
	'$stateParams',
	'$cookieStore',
  '$httpBackend',
	function($rootScope, $state, $stateParams, $cookieStore, $httpBackend) {
		$rootScope.$state = $state;
		$rootScope.$stateParams = $stateParams;
		$rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
			var token = $cookieStore.get('eTherapiToken');
			if (token) {
				$rootScope.isLogin = true;
				$rootScope.user = token;
			} else {
				$rootScope.isLogin = false;
			}
		});

    var phones = [{name: 'phone1', data: 'Nhan Doan'}, {name: 'phone2', data: 'Ngoc Nhan'}];

    $httpBackend.whenGET('/patient-edit-profile').respond(function() {
      console.log("Getting phones");
      return [200, phones, {}];
    });
    $httpBackend.whenPOST('/patient-edit-profile').respond(function(method, url, data, headers){
      console.log(method, url, data, headers);
      phones.push(angular.fromJson(data));
      return [200, {}, {}];
    });
    $httpBackend.whenGET(/^\w+.*/).passThrough();
    $httpBackend.whenPOST(/^\w+.*/).passThrough();
	}
]);
