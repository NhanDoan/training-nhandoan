angular.module('starter-app').controller('SampleController', function($scope) {
  'use strict';

  var enforceIntegers, isCorrect, setEquationLabel;
  $scope.equation = {
    a: 1,
    b: 2,
    c: 3
  };
  isCorrect = function() {
    return ($scope.equation.a + $scope.equation.b) === $scope.equation.c;
  };
  enforceIntegers = function() {
    var key, value, _ref, _results;
    _ref = $scope.equation;
    _results = [];
    for (key in _ref) {
      value = _ref[key];
      _results.push($scope.equation[key] = parseInt($scope.equation[key]));
    }
    return _results;
  };
  setEquationLabel = function() {
    return $scope.equationLabel = isCorrect() ? 'correct' : 'incorrect';
  };
  setEquationLabel();
  return $scope.$watch('equation', function() {
    enforceIntegers();
    return setEquationLabel();
  }, true);
});
