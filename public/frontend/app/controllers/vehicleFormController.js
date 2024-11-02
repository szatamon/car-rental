angular.module('CarRentalApp').controller('VehicleFormController', ['$scope', 'VehicleService', 'CarBrandService', '$routeParams', function($scope, VehicleService, CarBrandService, $routeParams) {
  $scope.vehicle = {};

  if ($routeParams.id) {
    VehicleService.getVehicle($routeParams.id).then(function(response) {
      $scope.vehicle = response.data;
    });
  }

  CarBrandService.getAllBrands().then(function(response) {
    $scope.carBrands = response.data;
  });

  $scope.saveVehicle = function() {
    if ($scope.vehicle.id) {
      VehicleService.updateVehicle($scope.vehicle);
    } else {
      VehicleService.createVehicle($scope.vehicle);
    }
  };
}]);

  