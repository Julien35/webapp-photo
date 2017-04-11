(function () {
    'use strick';


    function headerController() {
        // variable name such as vm, which stands for ViewModel
        var vm = this;
        vm.title = 'Web Photo';

    }


    angular
        .module('app')
        .controller('headerController', headerController);

})();
