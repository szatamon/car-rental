angular.module('CarRentalApp').controller('MainController', ['$scope', 'VehicleService', function($scope, VehicleService) {
    $scope.vehicles = [];
  
    const loadVehicles = () => {
      VehicleService.getVehicles().then(response => {
        $scope.vehicles = response.data;
      }).catch(error => {
        console.error('Error loading vehicles:', error);
      });
    };
  
    $scope.deleteVehicle = (vehicle) => {
      if (confirm('Are you sure you want to delete this vehicle?')) {
        VehicleService.deleteVehicle(vehicle.id).then(() => loadVehicles());
      }
    };
  
    loadVehicles();
  }]);
  