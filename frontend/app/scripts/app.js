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
  .module('app', [
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
        '': { templateUrl: 'templates/home.html'},
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
      url:'/appointment',
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
      url:'/profile',
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
      url:'/therapist-account',
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
    .state('therapist-edit-profile', {
      url:'/therapist-edit-profile',
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
