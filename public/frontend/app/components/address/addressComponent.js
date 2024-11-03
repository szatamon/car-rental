angular.module('CarRentalApp').component('addressComponent', {
  bindings: {
    address: '=',
    mode: '@'
  },
  templateUrl: '/frontend/app/components/address/address-component.html',
  controller: function() {
    this.$onInit = function() {
      console.log(this)
      if (!this.address) {
        this.address = {
          street: null,
          city: null,
          state: null,
          zipCode: null,
          country: null
        };
      }
    };
  }
});
