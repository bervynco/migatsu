app.controller('ReportsController', function ($scope, $rootScope, $interval, DataFactory, $state, $window, $mdToast) {
	$scope.$parent.CheckSessionData("reports");

	$scope.selectedReportType = null;
	$scope.reportList = [
		{
			name: "Users",
			alternative: "users"
		},
		{
			name: "Customers",
			alternative: "customers"
		},
		{
			name: "Suppliers",
			alternative: "suppliers"
		},
		{
			name: "Payables",
			alternative: "payables"
		},
		{
			name: "Receivables",
			alternative: "receivables"
		},
		{
			name: "Inventory",
			alternative: "inventory"
		},
		{
			name: "Purchase Order",
			alternative: "purchase_orders"
		},
		{
			name: "System Logs",
			alternative: "logs"
		}
	];
	$scope.reportTypeList = ["All Dates", "Current Month", "Current Year"];

	$scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Reports Page', action: 'View'};

	DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

	});
	
	$scope.generateReport = {
		type: '',
		name: ''
	}
	$scope.ChangeReport = function(report){
		$scope.report = report;
		$scope.generateReport.name = report;
	}

	$scope.ChangeReportType = function(reportType){
		$scope.selectedReportType = reportType;
		$scope.generateReport.type = reportType;
	}

	$scope.GenerateReport = function(){
		if($scope.generateReport.type == "" || $scope.generateReport.name == ""){
			$scope.$parent.ShowCustomToast(null, 'incomplete', 'reports');
		}
		else {
			DataFactory.GenerateReport($scope.generateReport).success(function(response){
				$scope.logDetails = {name: $scope.userDetails.name, page: 'Reports Page', action: 'Generate Report'};

				DataFactory.SetPageLog($scope.logDetails).success(function(response){
				}).error(function(error){

				});
				$scope.$parent.ShowCustomToast(null, 'successful', 'reports');
				$window.location.href = response;
				
			}).error(function(error){

			});
		}
		// if($scope.generateReport.start_date != null){
		// 	$scope.generateReport.start_date = moment($scope.generateReport.start_date).
		// 	format("YYYY-MM-DD HH:mm");
		// }
		// if($scope.generateReport.end_date != null){
		// 	$scope.generateReport.end_date = moment($scope.generateReport.end_date).
		// 	format("YYYY-MM-DD HH:mm");
		// }
		
	}
});