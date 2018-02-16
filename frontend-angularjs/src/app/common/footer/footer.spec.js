describe('footer component', () => {
  beforeEach(module('app', $provide => {
    $provide.factory('mainFooter', () => {
      return {
        templateUrl: 'app/footer.html'
      };
    });
  }));

  it('should render \'FountainJS team\'', angular.mock.inject(($rootScope, $compile) => {
    const element = $compile('<main-footer></main-footer>')($rootScope);
    $rootScope.$digest();
    const footer = element.find('a');
    expect(footer.html().trim()).toEqual('');
  }));
});
