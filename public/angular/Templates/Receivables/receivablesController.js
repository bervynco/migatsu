 app.controller('ReceivablesController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("receivables");

    $scope.tableFieldNames = ['Customer Name', 'PO Number', 'Delivery Date', 'Amount', 'Invoice ID', 'Terms', 'Due Date', 'Overdue Days', 'Remarks'];
    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Receivables Page', action: 'View'};
    
    $scope.currentPage = 1;
    $scope.receivableList = [];
    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });

    function getData(){
        DataFactory.GetReceivableList().success(function(response){
            $scope.receivableList = response;
            console.log(response);
        }).error(function(error){

        });
    }
    

    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 10 <= $scope.receivableList.length){
            $scope.currentPage = $scope.currentPage + 1;
            modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 1){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }

    $scope.CheckDueDate = function(list){
        var a = moment();
        var b = moment(list.due_date);

        var overdueDays = a.diff(b);

        return overdueDays;
    }
    $scope.ToggleDone = function(list){
        DataFactory.ToggleReceivableDone(list).success(function(response){
            if(response === "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Receivables Page', action: 'Transaction Done'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        }).error(function(error){

        });
    }
    $scope.AddNewReceivable = function(ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Receivables/receivablesDialog.html",
            locals: {
                 action: 'Add',
                 data:  ''
            },
            controller: 'ReceivableDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Receivables Page', action: 'Add'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        });
    }
    $scope.EditReceivable = function(receivable, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "public/angular/Templates/Receivables/receivablesDialog.html",
            locals: {
                 action: 'Edit',
                 data:  receivable
            },
            controller: 'ReceivableDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $scope.logDetails = {name: $scope.userDetails.name, page: 'Receivables Page', action: 'Edit'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                }).error(function(error){

                });
                getData();
            }
        });
    }
    $scope.DeleteReceivable = function(receivable, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to delete ' + receivable.customer_name + "'s" + ' receivable?')
            .textContent("There's no turning back after deleting it.")
            .targetEvent(ev)
            .ok('Yes, Delete it!')
            .cancel('No');

        $mdDialog.show(confirm).then(function() {
            DataFactory.DeleteReceivable(receivable).success(function(response){
                if(response == "Successful"){
                    $mdToast.show(
                        $mdToast.simple()
                            .textContent(receivable.customer_name + "s" + ' receivable has been deleted')
                            .position("top right")
                            .hideDelay(4000)
                    );
                    $scope.logDetails = {name: $scope.userDetails.name, page: 'Receivables Page', action: 'Delete'};

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