 app.controller('OutboundDeliveryController', function ($scope, $rootScope, $interval, DataFactory, $state, $mdDialog, $window) {
    $scope.SVG = $scope.ConfigurableItems.SVG;
    $scope.$parent.CheckSessionData("outbound-delivery");

    $scope.userDetails = JSON.parse(localStorage.getItem("user"));
    $scope.logDetails = {name: $scope.userDetails.name, page: 'Outbound Delivery Page', action: 'View'};

    $scope.currentPage = 1;
    DataFactory.SetPageLog($scope.logDetails).success(function(response){
        console.log(response);
    }).error(function(error){

    });

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

    function getData(){
        DataFactory.GetOutboundDeliveryList().success(function(response){
        $scope.outboundDeliveryList = response;
        console.log(response);
    }).error(function(error){

    });
    }
    

    $scope.MoveToDelivery = function(list, ev){
        $mdDialog.show({
            parent: angular.element(document.body),
            targetEvent: ev,
            templateUrl: "./angular/Templates/Outbound Delivery/outboundDeliveryDialog.html",
            locals: {
                 action: 'Edit',
                 data: list
            },
            controller: 'OutboundDeliveryDialogController'
        }).then(function(data){
            if(data == "Successful"){
                $window.location.reload();
            }
        });
        // var now = moment().format("YYYY-MM-DD HH:mm");
        // console.log(now);
        // list.promised_delivery_date = now;
        // list.actual_delivery_date = now;
        // DataFactory.EditPurchaseOrder(list).success(function(response){
        //     console.log(response);
        //     $window.location.reload();
        // }).error(function(error){

        // });
    }

    getData();
});