"use strict";

var shareApp = angular.module('shareApp', ['ngRoute', '$strap.directives', 'ngMaterial']);

shareApp.config(function($routeProvider) {
    $routeProvider
        .when('/home', {
            templateUrl: 'partials/home.html',
            controller : 'homeController'
        })
        .when('/objects', {
            templateUrl: 'partials/objects.html',
            controller : 'objectsController'
        })
        .when('/objects/edit/:id', {
            templateUrl: 'partials/edit.html',
            controller: 'editObjectController'
        })
        .otherwise({
            redirectTo: '/home'
        });
});

shareApp.config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('blue-grey')
    .accentPalette('green');
});
