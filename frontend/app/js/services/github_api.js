angular.module('starter-app.github').factory('GithubAPI', function($http, $cacheFactory, $q) {
  'use strict';
  var repoCache;
  repoCache = $cacheFactory('github-repositories');
  return {
    fetchRepoInfo: function(username, repoName) {
      var cacheKey, cached, deferred, promise;
      cacheKey = '' + username + '/' + repoName;
      deferred = $q.defer();
      promise = deferred.promise;
      cached = repoCache.get(cacheKey);
      if (cached) {
        deferred.resolve(cached);
      } else {
        $http.get('https://api.github.com/repos/' + username + '/' + repoName).then(function(data) {
          repoCache.put(cacheKey, data.data);
          return deferred.resolve(data.data);
        }, function(err) {
          return deferred.reject(err);
        });
      }
      return promise;
    }
  };
});
