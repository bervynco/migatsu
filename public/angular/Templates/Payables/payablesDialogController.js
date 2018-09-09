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

        $scope.order_list= [
                {
                    product_id: '',
                    quantity: '',
                    description: ''
                }
        ];
    }
    else{
        $scope.dialogHeading = "Edit Payable Details";
        $scope.payable = angular.copy(data);
        $scope.payable.delivery_date = new Date($scope.payable.delivery_date);
        $scope.payable.due_date = new Date($scope.payable.due_date);
        $scope.selectedSupplier = $scope.payable.supplier_id;
        // $scope.payable.supplier_dr_id = parseInt($scope.payable.supplier_dr_id);
        $scope.payable.terms = parseInt($scope.payable.terms);
    }

    $scope.AddNewOrder = function(){
        $scope.order_list.push({
            product_id: '',
            uom: '',
            quantity: '',
            description: ''
        });

    }

    $scope.ChangeSupplier = function(list){
        $scope.payable.supplier_id = list;
    }

    $scope.removeItem = function(idx){
        if($scope.order_list.length > 1){
            $scope.order_list.splice(idx, 1);
        }
    }
    $scope.SubmitNewPayableDetails = function(){
        if($scope.payable.supplier_id != null && $scope.payable.delivery_date != null && $scope.payable.due_date != null 
            && $scope.payable.supplier_dr_id != null && $scope.payable.terms != null){
                //$scope.payable.po_id != null && 
                $scope.payable.delivery_date = moment($scope.payable.delivery_date).
                format("YYYY-MM-DD HH:mm");
                $scope.payable.due_date = moment($scope.payable.due_date).
                format("YYYY-MM-DD HH:mm");
                
                if($scope.action == 'Add'){
                    $scope.payable.order_list = $scope.order_list;
                    DataFactory.AddNewPayable($scope.payable).success(function(response){
                        if(response != 'Error'){
                            $mdDialog.hide(response);
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