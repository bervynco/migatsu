 app.controller('PurchaseOrderDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    DataFactory.GetInventoryList().success(function(response){
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
                    product_id: '',
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
        
        console.log($scope.po);
    }

    $scope.AddNewOrder = function(){
        $scope.po.order_list.push({
            product_id: '',
            quantity: '',
            description: ''
        });

    }

    $scope.SubmitNewPurchaseOrderDetails = function(){
        for(var k = 0; k < $scope.po.orderList.length; k++){
            if($scope.po.orderList[k].product_id == "" || $scope.po.orderList[k].quantity == ""){
                console.log("Complete all fields");
                $scope.po.orderList.splice(k, 1);
            }
        }
        $scope.po.promised_delivery_date = moment( $scope.po.promised_delivery_date).
            format("YYYY-MM-DD HH:mm");
        $scope.po.actual_delivery_date = moment($scope.po.due_date).
            format("YYYY-MM-DD HH:mm");
        DataFactory.AddPurchaseOrder($scope.po).success(function(response){
            console.log(response);
            $mdDialog.hide("Successful");
        }).error(function(error){

        });
    }
    $scope.Close = function(){
        $mdDialog.hide("Cancel");
    }
});