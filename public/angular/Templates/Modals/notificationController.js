app.controller('NotificationController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, ConfigurableItems, $mdToast, param, action, page) {
	$scope.SVG = ConfigurableItems.SVG;
	$scope.parameters = param;
	$scope.page = page;
	$scope.action = action;

	if($scope.page == "request-access"){
		if($scope.action == "granted")
			$scope.message = "Access granted to " + $scope.parameters.name;
		else if($scope.action == "denied")
			$scope.message = "Access denied to " + $scope.parameters.name;
	}

});