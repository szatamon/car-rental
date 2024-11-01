angular.module('CarRentalApp').config(['$routeProvider', function($routeProvider) {
  $routeProvider
    .when('/vehicles', {
      templateUrl: '/frontend/app/views/vehicleList.html',
      controller: 'VehicleListController'
    })
    .when('/vehicles/add', {
      templateUrl: '/frontend/app/views/vehicleForm.html',
      controller: 'VehicleFormController'
    })
    .when('/vehicles/edit/:id', {
      templateUrl: '/frontend/app/views/vehicleForm.html',
      controller: 'VehicleFormController'
    })
    .otherwise({
      redirectTo: '/vehicles'
    });
}]);
