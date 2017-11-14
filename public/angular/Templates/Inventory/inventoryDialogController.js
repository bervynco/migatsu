 app.controller('InventoryDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    DataFactory.GetSupplierList().success(function(response){
        $scope.supplierList = response;
    }).error(function(error){

    });

    if($scope.action == "Add"){
        $scope.dialogHeading = "Add New Inventory";
        $scope.inventory = {
            supplier_id: '',
            product_code: '',
            product_description: '',
            purchase_price: '',
            balance: '',
            threshold: '',
            location: '',
            remarks: ''
        }
    }
    else{
        $scope.dialogHeading = "Edit Inventory Details";
        $scope.inventory = angular.copy(data);
    }

    

    $scope.ChangeSupplier = function(list){
        $scope.inventory.supplier_id = list;
    }
    $scope.SubmitNewInventoryDetails = function(){
        console.log($scope.inventory);
        if($scope.action == "Add"){
            DataFactory.AddNewInventory($scope.inventory).success(function(response){
                if(response == "Successful"){
                    $mdDialog.hide("Successful");
                }
            }).error(function(error){

            }); 
        }
        else{
            DataFactory.EditInventoryItem($scope.inventory).success(function(response){
                console.log(response);
                if(response == "Successful"){
                    $mdDialog.hide("Successful");
                }
            }).error(function(error){

            }); 
        }  
    }

    $scope.Close = function(){
        $mdDialog.hide("Cancel");
    }
});