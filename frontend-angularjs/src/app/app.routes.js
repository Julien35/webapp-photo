{
    /** @ngInject */
    function routesConfig($stateProvider, $urlRouterProvider, $locationProvider) {
        $locationProvider.html5Mode(true).hashPrefix('!');
        $urlRouterProvider.otherwise('/');

        $stateProvider
            .state('public', {
                url: '/',
                component: 'app'
            });
    }

    angular
        .module('app')
        .config(routesConfig);
}
