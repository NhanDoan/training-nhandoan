'use strict';
var app;

app = angular.module('starter-app');

app.config(function($stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise('/');

  return $stateProvider.state('home', {
    url: '/',
    templateUrl: '/templates/home.html'
  });
});
