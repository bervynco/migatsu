 app.controller('CustomerController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData('customer');
    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Customer Page', action: 'View'};
    $scope.currentPage = 0;
    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });
    function getData(){
        DataFactory.GetCustomerList().success(function(response){
            $scope.customerList = response;
            $scope.$parent.ChangeLoadBarState(false);
        }).error(function(error){

        });
    }
    

    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 14 <= $scope.filtered.length){
            $scope.currentPage = $scope.currentPage + 1;
            //modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 0){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }

    $scope.AddNewCustomer = function(ev){
         $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Customer/customerDialog.html",
            locals: {
                 action: 'Add',
                 data: ''
            },
            controller: 'CustomerDialogController'
        }).then(function(data){
            $scope.logDetails = {name: $scope.userDetails.name, page: 'Customers Page', action: 'Add'};

            DataFactory.SetPageLog($scope.logDetails).success(function(response){
                console.log(response);
            }).error(function(error){

            });
            if(data == "Successful"){
                getData();
            }
            else if(data == "Cancel"){
                //do nothing
            }
            else {
                $scope.filtered.push(data);
                $scope.currentPage = Math.floor($scope.filtered.length/14);
                console.log($scope.currentPage);
            }
        });
    }

    $scope.EditCustomer = function(customer, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Customer/customerDialog.html",
            locals: {
                 action: 'Edit',
                 data: customer
            },
            controller: 'CustomerDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Customers Page', action: 'Edit'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
               getData();
            }
        });
    }

    $scope.DeleteCustomer = function(customer, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to delete ' + customer.name + '?')
            .textContent("There's no turning back after deleting it.")
            .targetEvent(ev)
            .ok('Yes, Delete it!')
            .cancel('No');

        $mdDialog.show(confirm).then(function() {
            DataFactory.DeleteCustomer(customer).success(function(response){
                if(response == "Successful"){
                    $mdToast.show(
                        $mdToast.simple()
                            .textContent(customer.name + " has been deleted")
                            .position("top right")
                            .hideDelay(4000)
                    );

                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Customers Page', action: 'Delete'};

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