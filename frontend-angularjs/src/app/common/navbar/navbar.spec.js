describe('nav component', () => {
  beforeEach(module('app', $provide => {
    $provide.factory('nav', () => {
      return {
        templateUrl: 'app/nav.html'
      };
    });
  }));

  it('should...', angular.mock.inject(($rootScope, $compile) => {
    const element = $compile('<nav></nav>')($rootScope);
    $rootScope.$digest();
    expect(element).not.toBeNull();
  }));
});
