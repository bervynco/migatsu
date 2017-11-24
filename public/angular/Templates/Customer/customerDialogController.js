 app.controller('CustomerDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    if($scope.action == "Add"){
        $scope.dialogHeading = "Add New Customer";
        $scope.customer = {
            name: '',
            phone_number: '',
            tin: ''
        }
    }
    else{
        console.log(data);
        $scope.dialogHeading = "Edit Customer Details";
        $scope.customer = angular.copy(data);
    }

    
    $scope.SubmitNewCustomerDetails = function(){
        console.log($scope.customer);
        if($scope.action == "Add"){
            DataFactory.AddNewCustomer($scope.customer).success(function(response){
                if(response == "Successful")
                    $mdDialog.hide("Successful");
            }).error(function(error){

            });
        }
        else{
            DataFactory.EditCustomer($scope.customer).success(function(response){
                
                $mdDialog.hide("Successful");
            }).error(function(error){

            });
        }
        
    }
    $scope.Close = function(){
        $mdDialog.hide("Cancel");
    }
});