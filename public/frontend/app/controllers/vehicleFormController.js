angular.module('CarRentalApp').controller('VehicleFormController', ['$scope', '$routeParams', '$location', 'VehicleService', function($scope, $routeParams, $location, VehicleService) {
    $scope.vehicle = {};
    const vehicleId = $routeParams.id;
  
    if (vehicleId) {
      VehicleService.getVehicle(vehicleId).then(response => {
        $scope.vehicle = response.data;
      });
    }
  
    $scope.saveVehicle = () => {
      if (vehicleId) {
        VehicleService.updateVehicle($scope.vehicle).then(() => $location.path('/vehicles'));
      } else {
        VehicleService.addVehicle($scope.vehicle).then(() => $location.path('/vehicles'));
      }
    };
  }]);
  