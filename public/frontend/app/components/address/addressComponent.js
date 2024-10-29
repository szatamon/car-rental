angular.module('CarRentalApp').directive('addressComponent', function() {
    return {
      restrict: 'E',
      templateUrl: 'app/components/address/addressTemplate.html',
      scope: {
        address: '='
      }
    };
  });
  