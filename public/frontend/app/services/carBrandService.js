angular.module('CarRentalApp').service('CarBrandService', function($http) {
    this.getAllBrands = function() {
        return $http.get('/api/car-brands');
    };
});