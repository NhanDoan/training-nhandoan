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
        '': { templateUrl: '/assets/templates/home.html'},
        'header@home': {
          templateUrl: '/assets/templates/commons/header.html'
        },
        'sidebar@home': {
          templateUrl: '/assets/templates/commons/sidebar.html'
        },
        'footer@home': {
          templateUrl: '/assets/templates/commons/footer.html'
        }
      }
    })
    .state('appointment', {
      url:'/appointment',
      views: {
        '': {
          templateUrl: '/assets/templates/therapist.html'
        },
        'header@appointment': {
          templateUrl: '/assets/templates/commons/header.html'
        },
        'sidebar@appointment': {
          templateUrl: '/assets/templates/commons/sidebar.html'
        },
        'footer@appointment': {
          templateUrl: '/assets/templates/commons/footer.html'
        }
      }
    })
    .state('profile', {
      url:'/profile',
      views: {
        '': {
          templateUrl: '/assets/templates/commons/profile.html'
        },
        'header@profile': {
          templateUrl: '/assets/templates/commons/header.html'
        },
        'sidebar@profile': {
          templateUrl: '/assets/templates/commons/sidebar.html'
        },
        'footer@profile': {
          templateUrl: '/assets/templates/commons/footer.html'
        }
      }
    })
    .state('therapist-account', {
      url:'/therapist-account',
      views: {
        '': {
          templateUrl: '/assets/templates/commons/therapist-account.html'
        },
        'header@therapist-account': {
          templateUrl: '/assets/templates/commons/header.html'
        },
        'sidebar@therapist-account': {
          templateUrl: '/assets/templates/commons/sidebar.html'
        },
        'footer@therapist-account': {
          templateUrl: '/assets/templates/commons/footer.html'
        }
      }
    })
    .state('therapist-edit-profile', {
      url:'/therapist-edit-profile',
      views: {
        '': {
          templateUrl: '/assets/templates/commons/therapist-edit-profile.html'
        },
        'header@therapist-edit-profile': {
          templateUrl: '/assets/templates/commons/header.html'
        },
        'sidebar@therapist-edit-profile': {
          templateUrl: '/assets/templates/commons/sidebar.html'
        },
        'footer@therapist-edit-profile': {
          templateUrl: '/assets/templates/commons/footer.html'
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
