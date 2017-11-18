 app.controller('PurchaseOrderDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    DataFactory.GetInventoryList().success(function(response){
        console.log(response);
        $scope.inventoryList = response;
    }).error(function(error){

    });
    DataFactory.GetCustomerList().success(function(response){
        $scope.customerList = response;
    }).error(function(error){

    });
    
    if($scope.action == "Add"){
        $scope.dialogHeading = "Add New Purchase Order";
        $scope.po = {
            customer_id: '',
            customer_po_id: '',
            order_list : [
                {
                    
                    id: '',
                    quantity: '',
                    description: ''
                }
            ],
            promised_delivery_date: '',
            actual_delivery_date: '',
            invoice_id:'',
            amount: '',
            dr_id:'',
            remarks: ''
        }
    }
    else{
        $scope.dialogHeading = "Edit Purchase Order Details";
        $scope.po = angular.copy(data);
        $scope.po.promised_delivery_date = new Date($scope.po.promised_delivery_date);
        $scope.po.actual_delivery_date = new Date($scope.po.actual_delivery_date);
        $scope.po.order_list = JSON.parse($scope.po.order_list);
        console.log($scope.po);
    }

    $scope.AddNewOrder = function(){
        $scope.po.order_list.push({
            id: '',
            quantity: '',
            description: ''
        });

    }

    $scope.SubmitNewPurchaseOrderDetails = function(){
        console.log($scope.po);
        for(var k = 0; k < $scope.po.order_list.length; k++){
            if($scope.po.order_list[k].id == "" || $scope.po.order_list[k].quantity == ""){
                console.log("Complete all fields");
                $scope.po.order_list.splice(k, 1);
            }
        }
        $scope.po.promised_delivery_date = moment( $scope.po.promised_delivery_date).
            format("YYYY-MM-DD HH:mm");
        $scope.po.actual_delivery_date = moment($scope.po.due_date).
            format("YYYY-MM-DD HH:mm");

        if($scope.action == "Add"){
            DataFactory.AddPurchaseOrder($scope.po).success(function(response){
                console.log(response);
                $mdDialog.hide("Successful");
            }).error(function(error){

            });
        }
        else if($scope.action == "Edit"){
            DataFactory.EditPurchaseOrder($scope.po).success(function(response){
                console.log(response);
                $mdDialog.hide("Successful");
            }).error(function(error){

            });
        }
        
    }
    $scope.Close = function(){
        $mdDialog.hide("Cancel");
    }
});