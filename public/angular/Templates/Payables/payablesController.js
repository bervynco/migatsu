 app.controller('PayablesController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("payables");

    $scope.tableFieldNames = ['Supplier Name', 'PO ID', 'Delivery Date', 'Supplier DR ID', 'Terms', 'Due Date', 'Overdue Days', 'Remarks'];
    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Payables Page', action: 'View'};
    $scope.currentPage = 0;

    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });

    function getData(){
        DataFactory.GetPayableList().success(function(response){
            $scope.payableList = response;
        }).error(function(error){

        });
    }
    

    $scope.CheckDueDate = function(list){
        var a = moment();
        var b = moment(list.due_date);

        var overdueDays = a.diff(b);

        return overdueDays;
    }

    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 13 <= $scope.filtered.length){
            $scope.currentPage = $scope.currentPage + 1;
            // modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 0){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }
    
    $scope.ToggleDone = function(list, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to toggle ' + list.name + "'s" + ' as done and archived?')
            .textContent("This item will be archived and not deleted.")
            .targetEvent(ev)
            .ok('Yes')
            .cancel('No');
        $mdDialog.show(confirm).then(function() {
            DataFactory.TogglePayableDone(list).success(function(response){
                if(response === "Successful"){
                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Payables Page', action: 'Transaction Done'};

                    DataFactory.SetPageLog($scope.logDetails).success(function(response){
                        console.log(response);
                    }).error(function(error){

                    });
                    getData();
                }
            }).error(function(error){

            });
        });
    }
    $scope.AddNewPayable = function(ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Payables/payablesDialog.html",
            locals: {
                 action: 'Add',
                 data: ''
            },
            controller: 'PayableDialogController'
        }).then(function(data){
            $scope.logDetails = {name: $scope.userDetails.name, page: 'Payables Page', action: 'Add'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

            });
            if(data == "Successful"){
                getData();
            }
            else {
                $scope.filtered.push(data);
                $scope.currentPage = Math.floor($scope.filtered.length/14);
            }
        });
    }
    $scope.EditPayable = function(payable, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Payables/payablesDialog.html",
            locals: {
                 action: 'Edit',
                 data: payable
            },
            controller: 'PayableDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Payables Page', action: 'Edit'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        });
    }

    $scope.DeletePayable = function(payable, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to delete ' + payable.supplier_name + "'s" + ' payable?')
            .textContent("There's no turning back after deleting it.")
            .targetEvent(ev)
            .ok('Yes, Delete it!')
            .cancel('No');

        $mdDialog.show(confirm).then(function() {
            DataFactory.DeletePayable(payable).success(function(response){
                if(response == "Successful"){
                    $mdToast.show(
                        $mdToast.simple()
                            .textContent(payable.supplier_name + "s" + ' payable has been deleted')
                            .position("top right")
                            .hideDelay(4000)
                    );
                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Payables Page', action: 'Delete'};

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