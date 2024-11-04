angular.module('CarRentalApp').controller('VehicleListController', ['$scope', 'VehicleService', function($scope, VehicleService) {
  $scope.vehicles = [];

  $scope.loadError = false;
  $scope.loading = false;
  
  const loadVehicles = () => {
    $scope.loading = true;
    $scope.loadError = false;

    VehicleService.getVehicles().then(response => {
      $scope.vehicles = response.data;
      $scope.loading = false;
    }).catch(error => {
      console.error('Error loading vehicles:', error);
      $scope.loadError = true;
      $scope.loading = false;
    });
  };
  
  $scope.deleteVehicle = (vehicle) => {
    if (confirm('Are you sure you want to delete this vehicle?')) {
      VehicleService.deleteVehicle(vehicle.id).then(() => loadVehicles());
    }
  };
  
  loadVehicles();
}]);

