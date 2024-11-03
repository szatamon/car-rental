angular.module('CarRentalApp').controller('VehicleFormController', ['$scope', '$location', 'VehicleService', 'CarBrandService', '$routeParams', function($scope, $location, VehicleService, CarBrandService, $routeParams) {
  $scope.vehicle = {};

  CarBrandService.getAllBrands().then(function(response) {
    $scope.carBrands = response.data;
  });

  if ($routeParams.id) {
    VehicleService.getVehicle($routeParams.id).then(function(response) {
      $scope.vehicle = response.data;
      $scope.vehicle.brand = $scope.carBrands.find(function(brand) {
        return brand.name === $scope.vehicle.brand;
      });
    });
  }

  $scope.saveVehicle = function() {
    if ($scope.vehicle.id) {
      VehicleService.updateVehicle($scope.vehicle).then(function() {
        $location.path('/vehicles');
      });
    } else {
      VehicleService.createVehicle($scope.vehicle).then(function() {
        $location.path('/vehicles');
      });;
    }
  };
}]);

  