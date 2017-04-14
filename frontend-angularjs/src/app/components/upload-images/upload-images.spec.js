describe('uploadImages component', () => {
  beforeEach(module('app', $provide => {
    $provide.factory('uploadImages', () => {
      return {
        templateUrl: 'app/uploadImages.html'
      };
    });
  }));

  it('should...', angular.mock.inject(($rootScope, $compile) => {
    const element = $compile('<uploadImages></uploadImages>')($rootScope);
    $rootScope.$digest();
    expect(element).not.toBeNull();
  }));
});
