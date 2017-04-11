{
    function service($timeout) {
        $timeout(function () {
            console.log('test');
        }, 10);
    }

    angular
        .module('app')
        .service('mainHomeService', service);
}
