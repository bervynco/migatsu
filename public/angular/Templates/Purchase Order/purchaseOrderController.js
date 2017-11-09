 app.controller('PurchaseOrderController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("purchase-order");

    $scope.tableFieldNames = ['Customer Name', 'PO ID', 'Quantity', 'Amount', 
    'Promised Delivery Date', 'Invoice ID', 'DR ID', 'Actual Delivery Date', 'Remarks'];

    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Purchase Order Page', action: 'View'};
    $scope.currentPage = 1;

    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });

    DataFactory.GetPurchaseOrderList().success(function(response){
        console.log(response);
        $scope.purchaseOrderList = response;
    }).error(function(error){

    });

    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 10 <= $scope.purchaseOrderList.length){
            $scope.currentPage = $scope.currentPage + 1;
            modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 1){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }

    $scope.AddNewPurchaseOrder = function(ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./angular/Templates/Purchase Order/purchaseOrderDialog.html",
            locals: {
                 action: 'Add',
                 data: ''
            },
            controller: 'PurchaseOrderDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $window.location.reload();
            }
        });
    }

    $scope.EditPurchaseOrder = function(list, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./angular/Templates/Purchase Order/purchaseOrderDialog.html",
            locals: {
                 action: 'Edit',
                 data: list
            },
            controller: 'PurchaseOrderDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $window.location.reload();
            }
        });
    }
    $scope.MoveToDelivery = function(list){
        var now = moment().format("YYYY-MM-DD HH:mm");
        console.log(now);
        list.promised_delivery_date = now;

        DataFactory.EditPurchaseOrder(list).success(function(response){
            console.log(response);
            $window.location.reload();
        }).error(function(error){

        });
    }
    $scope.ApplyInventoryChanges = function(list){
        DataFactory.ApplyInventoryChanges(list).success(function(response){
            console.log(response);
            if(response == "Successful" || response == "Conditional Success"){
                $window.location.reload();
            }
            else{

            }
            
        }).error(function(error){

        });
    }
});