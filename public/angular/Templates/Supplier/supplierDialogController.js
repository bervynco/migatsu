 app.controller('SupplierDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    console.log($scope.SVG);
    if($scope.action == "Add"){
        $scope.dialogHeading = "Add New Supplier";
        $scope.supplier = {
            name: '',
            phone_number: '',
            tin: '',
            address: ''
        }
    }
    else{
        $scope.dialogHeading = "Edit Supplier Details";
        $scope.supplier = angular.copy(data);
        console.log($scope.supplier);
    }

    
    $scope.SubmitNewSupplierDetails = function(){
        console.log($scope.supplier);
        if($scope.action == "Add"){
            DataFactory.AddNewSupplier($scope.supplier).success(function(response){
                if(response == "Successful")
                    $mdDialog.hide("Successful");
            }).error(function(error){

            });
        }
        else if($scope.action == "Edit"){
            DataFactory.EditSupplier($scope.supplier).success(function(response){
                if(response == "Successful")
                    $mdDialog.hide("Successful");
            }).error(function(error){

            });
        }
        else;
        
    }
    $scope.Close = function(){
        $mdDialog.hide("Cancel");
    }
});