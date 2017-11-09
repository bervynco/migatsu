 app.controller('ReceivableDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    DataFactory.GetCustomerList().success(function(response){
        $scope.customerList = response;
    }).error(function(error){

    });

    DataFactory.GetPurchaseOrderList().success(function(response){
        $scope.purchaseOrderList = response;
    }).error(function(error){

    });

    $scope.selected
    if($scope.action == "Add"){
        $scope.dialogHeading = "Add New Receivable";
        $scope.receivable = {
            customer_id: '',
            po_id: '',
            delivery_date: '',
            amount: '',
            invoice_id: '',
            terms: '',
            due_date: '',
            remarks: ''
        }
    }
    else{
        $scope.dialogHeading = "Edit Receivable Details";
        $scope.receivable = angular.copy(data);
       
        $scope.receivable.delivery_date = new Date($scope.receivable.delivery_date);
        $scope.receivable.due_date = new Date($scope.receivable.due_date);
        $scope.receivable.invoice_id = $scope.receivable.invoice_id;
        console.log($scope.receivable);
    }

    

    $scope.ChangeCustomer = function(id){
        console.log(id);
        $scope.receivable.customer_id = id;
    }

    $scope.ChangePurchaseOrder = function(id){
        $scope.receivable_po_id = id;
    }
    $scope.SubmitNewReceivableDetails = function(){
        if($scope.receivable.customer_id != null && $scope.receivable.delivery_date != null && $scope.receivable.due_date != null 
            && $scope.receivable.amount != null && $scope.receivable.invoice_id != null && $scope.receivable.terms != null){
                // && $scope.receivable.po_id != null && 
                $scope.receivable.delivery_date = moment($scope.receivable.delivery_date).
                format("YYYY-MM-DD HH:mm");
                $scope.receivable.due_date = moment($scope.receivable.due_date).
                format("YYYY-MM-DD HH:mm");

                if($scope.action == 'Add'){
                    DataFactory.AddNewReceivable($scope.receivable).success(function(response){
                        $mdDialog.hide("Successful");
                    }).error(function(error){
                        $mdDialog.hide("Error");
                    });
                }
                else if($scope.action == "Edit"){
                    DataFactory.EditReceivable($scope.receivable).success(function(response){
                        $mdDialog.hide("Successful");
                    }).error(function(error){
                        $mdDialog.hide("Error");
                    });
                }
                else;
                
        }
        else {
            // error
        }
        
    }
    $scope.Close = function(){
        $mdDialog.hide('Cancel');
    }
});