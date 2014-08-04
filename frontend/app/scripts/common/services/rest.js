// Restangular service that uses Bing
angular
  .module('common')
  .factory('restAngular',[
    'Restangular',
    '$cookieStore',
    function(Restangular, $cookieStore) {
      return Restangular.withConfig(function(RestangularConfigurer) {
        RestangularConfigurer.setBaseUrl('http://0.0.0.0:3000/api/v1/');
        RestangularConfigurer.setDefaultHeaders({token: $cookieStore.get('eTherapiToken')});
      });
}]);