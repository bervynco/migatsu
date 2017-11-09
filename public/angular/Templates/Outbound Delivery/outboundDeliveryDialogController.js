 app.controller('OutboundDeliveryDialogController', function ($scope, $rootScope, ConfigurableItems, $interval, DataFactory, $state, $mdDialog, action, data) {
    // $scope.SVG = $scope.$parent.ConfigurableItems.SVG;
    // $scope.$parent.ChangeLoadBarState(false);
    $scope.SVG = ConfigurableItems.SVG;
    $scope.action = action;

    $scope.dialogHeading = "Change Delivery Date";
    $scope.outboundDelivery = angular.copy(data);
    $scope.outboundDelivery.actual_delivery_date = new Date($scope.outboundDelivery.actual_delivery_date);
    $scope.outboundDelivery.promised_delivery_date = new Date($scope.outboundDelivery.promised_delivery_date);
    // if($scope.action == "Add"){
    //     $scope.dialogHeading = "Add New Customer";
    //     $scope.customer = {
    //         name: '',
    //         phone_number: '',
    //         tin: ''
    //     }
    // }
    // else{
    //     console.log(data);
    //     $scope.dialogHeading = "Edit Customer Details";
    //     $scope.customer = angular.copy(data);
    // }

    
    $scope.SubmitNewDeliveryDetails = function(){
        $scope.outboundDelivery.promised_delivery_date = moment($scope.outboundDelivery.promised_delivery_date).
            format("YYYY-MM-DD HH:mm");
        $scope.outboundDelivery.actual_delivery_date = moment($scope.outboundDelivery.actual_delivery_date).
            format("YYYY-MM-DD HH:mm");
        DataFactory.EditPurchaseOrder($scope.outboundDelivery).success(function(response){
            console.log(response);
            $mdDialog.hide("Successful");
        }).error(function(error){

        });
        
    }
    $scope.Close = function(){
        $mdDialog.hide("Cancel");
    }
});