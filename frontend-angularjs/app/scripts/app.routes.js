{
	function states($locationProvider, $stateProvider) {
		// Remove # for non html browser
		$locationProvider.html5Mode(true);
		$locationProvider.hashPrefix = '!';

		// $urlRouterProvider.otherwise('/');

		const template = {
			abstract: true,
			views: {
				'header@': {
					templateUrl: 'views/common/header/header.template.html',
					controller: 'headerController',
					controllerAs: 'headerCtrl'
				},
				'breadcrumb@': {},
				'main@': {},
				'sidenav@': {},
				'footer@': {
					templateUrl: 'views/common/footer/footer.template.html'
				}
			}
		};

		const main = {
			parent: 'template',
			url: '/',
			views: {
				'main@': {
					templateUrl: 'views/mainHome/mainHome.template.html',
					controller: 'mainHomeController',
					controllerAs: 'mainHomeCtrl'
				}
			}
		};

		$stateProvider
			.state('template', template)
			.state('main', main);
	}

	angular.module('app').config(states);
}
