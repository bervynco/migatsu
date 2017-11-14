 app.controller('PayableDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    DataFactory.GetSupplierList().success(function(response){
        $scope.supplierList = response;
    }).error(function(error){

    });

    DataFactory.GetPurchaseOrderList().success(function(response){
        $scope.purchaseOrderList = response;
    }).error(function(error){

    });

    
    if($scope.action == "Add"){
        $scope.dialogHeading = "Add New Payable";
        $scope.payable = {
            supplier_id: '',
            po_id: '',
            delivery_date: '',
            supplier_dr_id: '',
            terms: '',
            due_date: '',
            overdue_days: '',
            remarks: ''
        }
    }
    else{
        console.log(data);
        $scope.dialogHeading = "Edit Payable Details";
        $scope.payable = angular.copy(data);
        $scope.payable.delivery_date = new Date($scope.payable.delivery_date);
        $scope.payable.due_date = new Date($scope.payable.due_date);
        $scope.selectedSupplier = $scope.payable.supplier_id;
        console.log($scope.payable);
    }

   

    $scope.ChangeSupplier = function(list){
        $scope.payable.supplier_id = list;
    }
    $scope.SubmitNewPayableDetails = function(){
        console.log($scope.payable);
        if($scope.payable.supplier_id != null && $scope.payable.delivery_date != null && $scope.payable.due_date != null 
            && $scope.payable.supplier_dr_id != null && $scope.payable.terms != null){
                //$scope.payable.po_id != null && 
                $scope.payable.delivery_date = moment($scope.payable.delivery_date).
                format("YYYY-MM-DD HH:mm");
                $scope.payable.due_date = moment($scope.payable.due_date).
                format("YYYY-MM-DD HH:mm");

                console.log($scope.payable);
                if($scope.action == 'Add'){
                    DataFactory.AddNewPayable($scope.payable).success(function(response){
                        if(response == "Successful"){
                            $mdDialog.hide("Successful");
                        }
                    }).error(function(error){
                        $mdDialog.hide("Error");
                    });
                }
                else{
                    DataFactory.EditPayable($scope.payable).success(function(response){
                        if(response == "Successful"){
                            $mdDialog.hide("Successful");
                        }
                    }).error(function(error){
                        $mdDialog.hide("Error");
                    });
                }
                
        }
        else {
            // error
        }
    }
    $scope.Close = function(){
        $mdDialog.hide("Cancel");
    }
});