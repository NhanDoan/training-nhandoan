'use strict';

/**
 * @ngdoc overview
 * @name frontEndApp
 * @description
 * # frontEndApp
 *
 * Main module of the application.
 */
angular
  .module('frontEndApp', [
    'ui.router'
  ])
  .config(function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/');
    $stateProvider

///////////////////////////////////////////////////////////////////////////////////////
// home page
///////////////////////////////////////////////////////////////////////////////////////

    .state('home', {
      url: '/',
      views: {
        '': { templateUrl: 'views/home.html'},
        'header@home': {
          templateUrl: 'views/commons/header.html'
        },
        'sidebar@home': {
          templateUrl: 'views/commons/sidebar.html'
        },
        'footer@home': {
          templateUrl: 'views/commons/footer.html'
        }
      }
    })
    .state('appointment', {
      url:'/appointment',
      views: {
        '': {
          templateUrl: 'views/therapist.html'
        },
        'header@appointment': {
          templateUrl: 'views/commons/header.html'
        },
        'sidebar@appointment': {
          templateUrl: 'views/commons/sidebar.html'
        },
        'footer@appointment': {
          templateUrl: 'views/commons/footer.html'
        }
      }
    })
    .state('profile', {
      url:'/profile',
      views: {
        '': {
          templateUrl: 'views/commons/profile.html'
        },
        'header@profile': {
          templateUrl: 'views/commons/header.html'
        },
        'sidebar@profile': {
          templateUrl: 'views/commons/sidebar.html'
        },
        'footer@profile': {
          templateUrl: 'views/commons/footer.html'
        }
      }
    })
    .state('therapist-account', {
      url:'/therapist-account',
      views: {
        '': {
          templateUrl: 'views/commons/therapist-account.html'
        },
        'header@therapist-account': {
          templateUrl: 'views/commons/header.html'
        },
        'sidebar@therapist-account': {
          templateUrl: 'views/commons/sidebar.html'
        },
        'footer@therapist-account': {
          templateUrl: 'views/commons/footer.html'
        }
      }
    })
    .state('therapist-edit-profile', {
      url:'/therapist-edit-profile',
      views: {
        '': {
          templateUrl: 'views/commons/therapist-edit-profile.html'
        },
        'header@therapist-edit-profile': {
          templateUrl: 'views/commons/header.html'
        },
        'sidebar@therapist-edit-profile': {
          templateUrl: 'views/commons/sidebar.html'
        },
        'footer@therapist-edit-profile': {
          templateUrl: 'views/commons/footer.html'
        }
      }
    });

/////////////////////////////////////////////////////////////////////////////////////////////////
  })

  .run([
    '$rootScope',
    '$state',
    '$stateParams',
    function ($rootScope, $state, $stateParams) {
      $rootScope.$state = $state;
      $rootScope.$stateParams = $stateParams;
    }
  ]);
