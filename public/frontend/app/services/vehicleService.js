angular.module('CarRentalApp').factory('VehicleService', ['$http', function($http) {
    const API_URL = '/api/vehicles';
  
    return {
      getVehicles: () => $http.get(API_URL),
      getVehicle: (id) => $http.get(`${API_URL}/${id}`),
      addVehicle: (vehicle) => $http.post(API_URL, vehicle),
      updateVehicle: (vehicle) => $http.put(`${API_URL}/${vehicle.id}`, vehicle),
      deleteVehicle: (id) => $http.delete(`${API_URL}/${id}`)
    };
  }]);
  