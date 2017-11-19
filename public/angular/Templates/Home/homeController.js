app.controller('HomeController', function ($scope, $rootScope, $interval, DataFactory, $state) {
	$scope.$parent.CheckSessionData('home');
	$scope.userDetails = JSON.parse(localStorage.getItem("user"));
	$scope.logDetails = {name: $scope.userDetails.name, page: 'Transaction Page', action: 'View'};
	
	DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

	});
	
	DataFactory.GetPayablesToday().success(function(response){
		console.log(response);
		$scope.payablesList = response;
	}).error(function(error){

	});

	DataFactory.GetReceivablesToday().success(function(response){
		console.log(response);
		$scope.receivablesList = response;
	}).error(function(error){

	});

	DataFactory.GetPurchaseOrderToday().success(function(response){
		console.log(response);
		$scope.poList = response;
	}).error(function(error){

	});

	DataFactory.GetInventoryToday().success(function(response){
		console.log(response);
		$scope.inventoryList = response;
	}).error(function(error){

	});

	
	DataFactory.GetOutboundDeliveryToday().success(function(response){
		console.log(response);
		$scope.deliveryList = response;
	}).error(function(error){

	});
});