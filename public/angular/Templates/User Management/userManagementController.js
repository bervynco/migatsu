 app.controller('UserManagementController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("user-management");

    $scope.tableFieldNames = ['Employee Name', 'Username', 'Role'];
    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'User Management Page', action: 'View'};
    $scope.currentPage = 1;

    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });

    DataFactory.GetUserList().success(function(response){
        $scope.userList = response;
        console.log($scope.userList);
    }).error(function(error){

    });

    $scope.ChangePage = function(i){
    }
    $scope.NextPage = function(i){
        if(($scope.currentPage + 1 )* 10 <= $scope.userList.length){
            $scope.currentPage = $scope.currentPage + 1;
            modifyArray($scope.currentPage);
        }
        
    }
    $scope.PreviousPage = function(i){
        if($scope.currentPage != 1){
            $scope.currentPage = $scope.currentPage - 1;
        }
    }

    $scope.AddNewUser = function(ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./public/angular/Templates/User Management/userManagementDialog.html",
            locals: {
                 action: 'Add',
                 data: ''
            },
            controller: 'UserManagementDialogController'
        }).then(function(data){
            if(data == "Success"){
                $window.location.reload();
            }
        });
    }

    $scope.EditUser = function(user, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./public/angular/Templates/User Management/userManagementDialog.html",
            locals: {
                 action: 'Edit',
                 data: user
            },
            controller: 'UserManagementDialogController'
        }).then(function(data){
            if(data == "Success"){
                $window.location.reload();
            }
        });
    }

    $scope.ChangePassword = function(user, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./public/angular/Templates/User Management/changePasswordDialog.html",
            locals: {
                 action: 'Change Password',
                 data: user
            },
            controller: 'UserManagementDialogController'
        }).then(function(data){
            console.log(data);
            if(data == "Success"){
                $window.location.reload();
            }
        });
    }
    $scope.DeleteUser = function(user, ev){
        var confirm = $mdDialog.confirm()
            .title('Would you like to delete ' + user.name + '?')
            .textContent("There's no turning back after deleting it.")
            .targetEvent(ev)
            .ok('Yes, Delete it!')
            .cancel('No');

        $mdDialog.show(confirm).then(function() {
            DataFactory.DeleteUser(user).success(function(response){
                if(response == "Successful"){
                    $mdToast.show(
                        $mdToast.simple()
                            .textContent(user.name + " has been deleted")
                            .position("top right")
                            .hideDelay(4000)
                    );
                }
                
            }).error(function(error){

            });
            
        }, function() {
            
        });
    }
});