app.controller('HelpController', function ($scope, $rootScope, $interval, DataFactory, $state) {
	$scope.$parent.CheckSessionData('help');
	$scope.$parent.ChangeLoadBarState(false);
	$scope.SVG = $scope.ConfigurableItems.SVG;
	$scope.logDetails = {name: 'Bervyn Co', page: 'Help Page', action: 'View'};

    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });

    DataFactory.GetPageLogs().success(function(response){
        console.log(response);
        console.log("SUCCESS");
    }).error(function(error){
        
    });
});