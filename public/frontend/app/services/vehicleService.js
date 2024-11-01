angular.module('CarRentalApp').service('VehicleService', ['$http', function($http) {
  this.getVehicles = function() {
    return $http.get('/api/vehicles');
  };

  this.getVehicle = function(id) {
    return $http.get('/api/vehicles/' + id);
  };

  this.createVehicle = function(vehicle) {
    return $http.post('/api/vehicles', vehicle);
  };

  this.updateVehicle = function(vehicle) {
    return $http.put('/api/vehicles/' + vehicle.id, vehicle);
  };

  this.deleteVehicle = function(id) {
    return $http.delete('/api/vehicles/' + id);
  };
}]);
