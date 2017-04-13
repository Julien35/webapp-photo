{
    class HeaderController {
        constructor() {
            this.title = 'Web App Photo';
        }
    }

    angular
        .module('app')
        .controller('HeaderController', HeaderController);
}