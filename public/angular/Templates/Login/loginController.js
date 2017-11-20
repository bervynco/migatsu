 app.controller('LoginController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.user = {
        username: '',
        password: ''
    }
    $scope.Login = function(){
        DataFactory.SignIn($scope.user).success(function(response){
            console.log(response);
            $scope.loggedInUser = response[0];
            if(response.length != 0){
                localStorage.setItem("user", JSON.stringify($scope.loggedInUser));
                $scope.logDetails = {name: $scope.loggedInUser.name, page: 'System Logs Page', action: 'Log In'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                    if($scope.loggedInUser.role === "Administrator"){
                        $scope.$parent.ChangeState("home");
                    }
                    else{
                        $scope.$parent.ChangeState("customer");
                    }
                    
                }).error(function(error){

                });
                
            }
            else{
                $scope.errorMessage = "Username and/or password invalid";
            }
            

        }).error(function(error){

        });
    }
});