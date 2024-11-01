angular.module('CarRentalApp').controller('VehicleFormController', ['$scope', 'VehicleService', '$routeParams', function($scope, VehicleService, $routeParams) {
  $scope.vehicle = {};

  if ($routeParams.id) {
    VehicleService.getVehicle($routeParams.id).then(function(response) {
      $scope.vehicle = response.data;
    });
  }

  $scope.saveVehicle = function() {
    if ($scope.vehicle.id) {
      VehicleService.updateVehicle($scope.vehicle);
    } else {
      VehicleService.createVehicle($scope.vehicle);
    }
  };
}]);

  