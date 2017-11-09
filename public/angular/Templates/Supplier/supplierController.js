 app.controller('SupplierController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("supplier");
    
    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Suppliers Page', action: 'View'};
    $scope.currentPage = 1;

    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });
    
    DataFactory.GetSupplierList().success(function(response){
        $scope.supplierList = response;
        console.log(response);
    }).error(function(error){

    });

    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 10 <= $scope.supplierList.length){
            $scope.currentPage = $scope.currentPage + 1;
            // modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 1){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }

    $scope.AddNewSupplier = function(ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./angular/Templates/Supplier/supplierDialog.html",
            locals: {
                 action: 'Add',
                 data: ''
            },
            controller: 'SupplierDialogController'
        }).then(function(data) {
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Suppliers Page', action: 'Add'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                $window.location.reload();
            }
            console.log(data);
        });
    }

    $scope.EditSupplier = function(supplier, ev){
        console.log(supplier);
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./angular/Templates/Supplier/supplierDialog.html",
            locals: {
                 action: 'Edit',
                 data: supplier
            },
            controller: 'SupplierDialogController'
        }).then(function(data) {
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Suppliers Page', action: 'Edit'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                $window.location.reload();
            }
            console.log(data);
        });
    }

    $scope.DeleteSupplier = function(supplier, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to delete ' + supplier.name + '?')
            .textContent("There's no turning back after deleting it.")
            .targetEvent(ev)
            .ok('Yes, Delete it!')
            .cancel('No');

        $mdDialog.show(confirm).then(function() {
            DataFactory.DeleteSupplier(supplier).success(function(response){
                if(response == "Successful"){
                    $mdToast.show(
                        $mdToast.simple()
                            .textContent(supplier.name + " has been deleted")
                            .position("top right")
                            .hideDelay(4000)
                    );
                    $window.location.reload();
                }
                
            }).error(function(error){

            });
            
        }, function() {
            
        });
    }
});