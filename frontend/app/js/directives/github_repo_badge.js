angular.module('starter-app.github').directive('githubRepoBadge', function(GithubAPI) {
  'use strict';

  return {
    restrict: 'A',
    scope: {
      githubRepoBadge: '@'
    },
    replace: true,
    link: function(scope, elem, attrs) {
      var repo, username, vars;
      vars = scope.githubRepoBadge.split("/");
      username = vars[0];
      repo = vars[1];
      scope.data = null;
      return GithubAPI.fetchRepoInfo(username, repo).then(function(data) {
        return scope.data = data;
      }, function(errMsg) {
        return scope.errorMessage = errMsg;
      });
    },
    template: "<div class='github-repo-badge' data-ng-show='data'>\n  <span class='github-repo-badge-error' data-ng-bind='errorMessage'></span>\n  <div class='github-repo-badge-content' ng-hide='errorMessage'>\n    <img class='github-repo-badge-avatar' ng-if='data.owner.avatar_url' data-ng-src=\"{{data.owner.avatar_url + 'size=30'}}\" />\n    <strong class='github-repo-badge-name' data-ng-bind='data.name'></strong>\n    <div class='github-repo-badge-description' data-ng-bind='data.description'></div>\n    <i class='fa fa-star fa-fw'></i>\n    <span class='github-repo-badge-stars' data-ng-bind='data.stargazers_count'></span><br/>\n    <i class='fa fa-exclamation fa-fw'></i>\n    <span class='github-repo-badge-issues' data-ng-bind='data.open_issues'></span>\n  </div>\n</div>"
  };
});
