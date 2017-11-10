 app.controller('UserManagementDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;
    $scope.errorMessage = null;

    console.log($scope.action);
    $scope.password = {
        password: '',
        confirmPassword: ''
    }
    if($scope.action == "Add"){
        $scope.dialogHeading = "Add New User";
        $scope.user = {
            name: '',
            username: '',
            password: '',
            role: ''
        }
        $scope.confirmPassword = null;
    }
    else if($scope.action == "Change Password"){
        $scope.dialogHeading = "Change Password";
        $scope.user = angular.copy(data);
        $scope.selectedRole = $scope.user.role;
    }
    else{
        $scope.dialogHeading = "Edit User Details";
        $scope.user = angular.copy(data);
        $scope.selectedRole = $scope.user.role;
    }
    console.log($scope.user);
    $scope.password = {
        password: '',
        confirmPassword: ''
    }
    $scope.roleList = [
        {
            id: '1',
            role: 'Administrator'
        },
        {
            id: '2',
            role: 'Non-Administrator'
        }
    ];
    
    $scope.ChangeRole = function(list){
        $scope.user.role = list;
    }
    $scope.SubmitNewUserDetails = function(){
        // $scope.errorMessage = null;
        if($scope.action == "Add"){
            console.log($scope.password);
            if($scope.password.password == $scope.password.confirmPassword){
                $scope.user.password = $scope.password.password;
                DataFactory.AddNewUser($scope.user).success(function(response){
                    if(response == "Successful")
                        $mdDialog.hide("Success");
                    else{
                        $scope.errorMessage = response;
                    }
                }).error(function(error){

                });
            }
        }
        else if($scope.action == "Edit"){
            DataFactory.EditUser($scope.user).success(function(response){
                if(response == "Successful")
                    $mdDialog.hide("Success");
                else{
                    $scope.errorMessage = response;
                }
            }).error(function(error){

            });
        }
        else if($scope.action == "Change Password"){
            if($scope.password.password === $scope.password.confirmPassword){
                var userData = {};
                userData.id = $scope.user['id'];
                userData.name = $scope.user['name'];
                userData.password = $scope.password['password'];
                userData.confirmPassword = $scope.password['confirmPassword'];

                $scope.errorMessage = null;
                DataFactory.ChangePassword(userData).success(function(response){
                    console.log(response);
                    if(response == "Successful")
                        $mdDialog.hide("Success");
                }).error(function(error){

                });
            }
            else{
                $scope.errorMessage = "Passwords entered are not the same.";
            }
            
        }
        else;
        
       
    }
    $scope.Close = function(){
        $mdDialog.hide();
    }
});