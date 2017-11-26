 app.controller('LoginController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $mdToast, $window) {
    $scope.ChangeLoadBarState(false);
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.user = {
        username: '',
        password: ''
    }
    $scope.Login = function(){
        $scope.$parent.ShowCustomToast(null, 'loading', 'login');
        DataFactory.SignIn($scope.user).success(function(response){
            $scope.loggedInUser = response[0];
            if(response.length != 0){
                localStorage.setItem("user", JSON.stringify($scope.loggedInUser));
                $scope.logDetails = {name: $scope.loggedInUser.name, page: 'Login', action: 'Log In'};

                DataFactory.SetPageLog($scope.logDetails).success(function(response){
                    console.log(response);
                    $scope.$parent.ShowCustomToast(null, 'success', 'login');
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
                $scope.$parent.ShowCustomToast(null, 'invalid', 'login');
                $scope.errorMessage = "Username and/or password invalid";
            }
            

        }).error(function(error){

        });
    }
});