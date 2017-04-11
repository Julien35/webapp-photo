{
	function controller() {
		// TODO Here manage global app instructions via services and factory like loader, spinner,...
		this.pageTile = "WebApp Photo";
	}
	angular.module('app').controller('mainController', controller);
}
