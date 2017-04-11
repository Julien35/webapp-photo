{
    function controller(mainHomeService) {
        this.service = mainHomeService;
    }

    angular
        .module('app')
        .controller('mainHomeController', controller);
}
