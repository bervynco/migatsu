 app.controller('InventoryController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("inventory");
    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Inventory Page', action: 'View'};
    
    $scope.tableFieldNames = ['Supplier Name', 'Product Code', 'Product Description', 'Purchase Price', 'Balance', 'Threshold', 'Location', 'Remarks'];
    $scope.currentPage = 1;

    DataFactory.SetPageLog($scope.logDetails).success(function(response){
    }).error(function(error){

    });
    
    function getData(){
        DataFactory.GetInventoryList().success(function(response){
            $scope.inventoryList = response;
        }).error(function(error){

        });
    }
    

    $scope.CheckThreshold = function(list){
        if(list.threshold > list.balance){
            return 'warning';
        }
        else{
            return "";
        }
    }
    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 10 <= $scope.filtered.length){
            $scope.currentPage = $scope.currentPage + 1;
            // modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 1){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }

    $scope.AddNewInventory = function(ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Inventory/inventoryDialog.html",
            locals: {
                 action: 'Add',
                 data: ''
            },
            controller: 'InventoryDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Inventory Page', action: 'Add'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        });
    }
    $scope.EditInventoryItem = function(inventory, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Inventory/inventoryDialog.html",
            locals: {
                 action: 'Edit',
                 data: inventory
            },
            controller: 'InventoryDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Inventory Page', action: 'Edit'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        });
    }

    $scope.DeleteInventoryItem = function(inventory, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to delete ' + inventory.product_id + '?')
            .textContent("There's no turning back after deleting it.")
            .targetEvent(ev)
            .ok('Yes, Delete it!')
            .cancel('No');

        $mdDialog.show(confirm).then(function() {
            DataFactory.DeleteInventoryItem(inventory).success(function(response){
                if(response == "Successful"){
                    $mdToast.show(
                        $mdToast.simple()
                            .textContent(inventory.product_id + " has been deleted")
                            .position("top right")
                            .hideDelay(4000)
                    );
                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Inventory Page', action: 'Delete'};

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
    getData();
});