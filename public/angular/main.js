/* MAIN MODULE */
var app = angular.module('MainApplication', [
    "ds.clock",
    "Main-Factory",
    "Main-Directives",
    "Main-Router",
    "Main-ContentManager",
    'ngSanitize',
    'ngAnimate',
    "ngMaterial",
    "jQueryScrollbar",
    "LocalStorageModule"]); //
app.controller('MainController', function ($mdDialog, $mdToast, $state, $mdSidenav, $rootScope, $scope, $log, DataFactory, ConfigurableItems) {
    $scope.Date = {
        weekday: moment().format('dddd'),
        day: moment().format('Do'),
        month: moment().format('MMMM'),
        year: moment().format('YYYY'),
        time: moment().format("h:mm:ss a")
    }
    
    $scope.ConfigurableItems = ConfigurableItems;
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.loadstate = false;
    // $scope.requestAccess = [];
    $scope.MainState = 'login';
    $scope.userDetails = null;
    $scope.ShowCustomToast = function(parameters, action, page) {
        $mdToast.show({
          hideDelay   : 1000,
          position    : 'top right',
          controller  : 'NotificationController',
          templateUrl : 'public/angular/Templates/Modals/toast.html',
          locals      : {
                            param:parameters, 
                            action: action,
                            page: page
                        } 
        });

    };

    $scope.GetMainState = function () {
        return $scope.MainState;
    }
    $scope.ChangeState = function (num) {
        console.log(num);
        $state.go(num);
        $scope.MainState = num;
        $scope.ChangeLoadBarState(true);
    }
    $scope.ChangeLoadBarState = function(loading){
        $scope.loadstate = loading;
    }

    $scope.ChangeRole = function(role){
        $scope.access = role;
    }

    $scope.CheckSessionData = function(page){
        $scope.userDetails = JSON.parse(localStorage.getItem("user"));
        $scope.intruders = false;
        if($scope.userDetails == null){
            $scope.intruders = true;
            $scope.ChangeLoadBarState(false);
            setTimeout(function(){
                $scope.ChangeState('login');
                $scope.MainState = "Login";
            }, 5000);
        }
        else{
            $scope.ChangeState(page);
            $scope.ChangeLoadBarState(false);
        }
    }
    

    $scope.ToggleSideNav = function (cid) {
        $mdSidenav(cid).toggle();
    }

    $scope.Threads = [];
    
    $scope.KillThreads = function () {
        angular.forEach($scope.Threads, function (o) {
            clearInterval(o);
        });
        $scope.Threads = [];
    }
    
    $scope.LoadSessionData = function(){
        $scope.userDetails = JSON.parse(localStorage.getItem("user"))
        if($scope.userDetails != null){
            $scope.userDetails = $scope.userDetails;
            var splitName = $scope.userDetails.name.split(" ");
            $scope.initials = splitName[0].charAt(0).toUpperCase()+ splitName[1].charAt(0).toUpperCase();            
            console.log($scope.initials);
        }
    }
    
    $scope.SignOut = function(ev){
        localStorage.removeItem("user");
        $scope.userDetails = null;
        $scope.LoginState = "Login";
        $scope.MainState = "Login";
        $scope.ChangeState('login');
        $state.go('login');
        
    }
    
    $scope.LoadSessionData();

});