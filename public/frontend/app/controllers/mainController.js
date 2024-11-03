angular.module('CarRentalApp').controller('MainController', ['$scope', '$location', function($scope, $location) {
    $scope.appTitle = 'Car Rental Application';
    $scope.goToList = function() {
      $location.path('/vehicles');
    };
}]);
  