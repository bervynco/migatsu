 app.controller('PurchaseOrderController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("purchase-order");

    $scope.tableFieldNames = ['Customer Name', 'PO ID', 'Quantity', 'Amount', 
    'Promised Delivery Date', 'Invoice ID', 'DR ID', 'Actual Delivery Date', 'Remarks'];

    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'View'};
    $scope.currentPage = 0;

    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });

    function getData(){
        DataFactory.GetPurchaseOrderList().success(function(response){
            console.log(response);
            $scope.purchaseOrderList = response;
        }).error(function(error){

        });
    }
   

    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 14 <= $scope.filtered.length){
            $scope.currentPage = $scope.currentPage + 1;
            modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 1){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }

    $scope.ToggleDone = function(list){
        DataFactory.TogglePurchaseOrderDone(list).success(function(response){
            if(response === "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'Transaction Done'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        }).error(function(error){

        });
    }

    $scope.AddNewPurchaseOrder = function(ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Purchase Order/purchaseOrderDialog.html",
            locals: {
                 action: 'Add',
                 data: ''
            },
            controller: 'PurchaseOrderDialogController'
        }).then(function(data){
            $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'Add'};

            DataFactory.SetPageLog($scope.logDetails).success(function(response){
                console.log(response);
            }).error(function(error){

            });
            if(data == "Error" || data == "Successful"){
                getData();
            }
            else if(data == "Cancel"){
                //do nothing
            }
            else {
                $scope.filtered.push(data);
                $scope.currentPage = Math.floor($scope.filtered.length/14);
                console.log($scope.filtered);
            }
        });
    }

    $scope.EditPurchaseOrder = function(list, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Purchase Order/purchaseOrderDialog.html",
            locals: {
                 action: 'Edit',
                 data: list
            },
            controller: 'PurchaseOrderDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'Edit'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        });
    }

    $scope.DeletePurchaseOrder = function(purchaseOrder, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to delete ' + purchaseOrder.name + "'s" + ' purchase order?')
            .textContent("There's no turning back after deleting it.")
            .targetEvent(ev)
            .ok('Yes, Delete it!')
            .cancel('No');

        $mdDialog.show(confirm).then(function() {
            DataFactory.DeletePurchaseOrder(purchaseOrder).success(function(response){
                if(response == "Successful"){
                    $mdToast.show(
                        $mdToast.simple()
                            .textContent(purchaseOrder.name + "s" + ' purchase order has been deleted')
                            .position("top right")
                            .hideDelay(4000)
                    );
                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'Delete'};

                    DataFactory.SetPageLog($scope.logDetails).success(function(response){
                        console.log(response);
                    }).error(function(error){

                    });    
                    getData();
                }
                
            }).error(function(error){

            });
            
        }, function() {
            
        });
    }

    $scope.MoveToDelivery = function(list, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to move the delivery date of PO# ' + list.customer_po_id + ' to today?')
            .textContent('This changes will reflect real time.')
            .targetEvent(ev)
            .ok('Yes')
            .cancel('Cancel');
        $mdDialog.show(confirm).then(function() {
            var now = moment().format("YYYY-MM-DD HH:mm");
            console.log(now);
            list.promised_delivery_date = now;

            DataFactory.EditPurchaseOrder(list).success(function(response){
                console.log(response);
                if(response == "Successful"){
                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'Move Delivery Data'};

                    DataFactory.SetPageLog($scope.logDetails).success(function(response){
                        console.log(response);
                    }).error(function(error){

                    });
                    getData();
                }
                
            }).error(function(error){

            });
        }), function() {
        
        };
        
    }
    $scope.ApplyInventoryChanges = function(list, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to apply inventory changes to PO# ' + list.customer_po_id)
            .textContent('This changes will reflect real time.')
            .targetEvent(ev)
            .ok('Yes')
            .cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            DataFactory.ApplyInventoryChanges(list).success(function(response){
                console.log(response);
                if(response == "Successful" || response == "Conditional Success"){
                    
                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'Apply Inventory Changes'};

                    DataFactory.SetPageLog($scope.logDetails).success(function(response){
                        console.log(response);
                    }).error(function(error){

                    });
                    $state.reload();
                }
                else{

                }
                
            }).error(function(error){

            });
        }, function() {
        
        });
        
    }
    getData();
});