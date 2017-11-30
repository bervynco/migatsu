app.controller('NotificationController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, ConfigurableItems, $mdToast, param, action, page) {
	$scope.SVG = ConfigurableItems.SVG;
	$scope.parameters = param;
	$scope.page = page;
	$scope.action = action;

	if($scope.page == "login"){
		if($scope.action == "success"){
			$scope.icon = $scope.SVG.accept;
			$scope.message = "Login successful";
		}
		else if($scope.action == "invalid"){
			$scope.icon = $scope.SVG.reject;
			$scope.message = "Invalid credentials";
		}
		else if($scope.action == "loading"){
			$scope.icon = $scope.SVG.hourglass;
			$scope.message = "Validating your credentials";
		}
		else{
			$scope.icon = $scope.SVG.reject;
			$scope.message = "Unexpected error occured";
		}
			
	}

});