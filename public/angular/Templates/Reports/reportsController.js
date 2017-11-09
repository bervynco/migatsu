app.controller('ReportsController', function ($scope, $rootScope, $interval, DataFactory, $state, $window) {
	$scope.$parent.CheckSessionData("reports");

	$scope.selectedReportType = null;
	$scope.reportList = ["Users", "Customers", "Suppliers", "Payables", "Receivables", "Inventory", 
	"Purchase Order", "System Logs", "Transactions"];
	$scope.reportTypeList = ["All Dates", "Current Month", "Current Year", "Custom"];

	$scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Reports Page', action: 'View'};

	DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

	});
	
	$scope.generateReport = {
		type: '',
		name: '',
		start_date: '',
		end_date: ''
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
		if($scope.generateReport.start_date != null){
			$scope.generateReport.start_date = moment($scope.generateReport.start_date).
			format("YYYY-MM-DD HH:mm");
		}
		if($scope.generateReport.end_date != null){
			$scope.generateReport.end_date = moment($scope.generateReport.end_date).
			format("YYYY-MM-DD HH:mm");
		}
		DataFactory.GenerateReport($scope.generateReport).success(function(response){
			console.log(response);
			$scope.logDetails = {name: $scope.userDetails.name, page: 'Reports Page', action: 'Generate Report'};

			DataFactory.SetPageLog($scope.logDetails).success(function(response){
				console.log(response);
			}).error(function(error){

			});
			$window.location.href= "..\\migatsu_api\\storage\\excel\\exports\\" + response + ".xls";
			
		}).error(function(error){

		});
	}
});