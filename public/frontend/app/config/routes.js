angular.module('CarRentalApp').config(['$routeProvider', function($routeProvider) {
    $routeProvider
      .when('/vehicles', {
        templateUrl: 'app/views/vehicleList.html',
        controller: 'VehicleListController'
      })
      .when('/vehicles/add', {
        templateUrl: 'app/views/vehicleForm.html',
        controller: 'VehicleFormController'
      })
      .when('/vehicles/edit/:id', {
        templateUrl: 'app/views/vehicleForm.html',
        controller: 'VehicleFormController'
      })
      .otherwise({
        redirectTo: '/vehicles'
      });
  }]);
  