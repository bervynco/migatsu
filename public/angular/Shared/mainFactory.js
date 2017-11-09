/* Factory */
var mainFactory = angular.module('Main-Factory', []); //
mainFactory.factory('DataFactory', ['$http', function ($http) {
    var pre = "";

    function makeid() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        for (var i = 0; i < 3; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    var locationString = "/migatsu_api/public/api/";
    return {
        //Samples
        SampleGET: function () {
            return $http({
                url: "url/sampleget",
                method: 'GET', cache: false
            });
        },
        SamplePOST: function (obj) {
            return $http({
                method: "POST",
                url: "url/samplepost",
                data: obj,
            });
        },

        /* Login */
        SignIn: function(user){
            console.log(user);
            return $http({
                method: "POST",
                url: 'index.php/UserManagement/login',
                headers: {
                    'Content-Type': 'application/json'
                },
                data: user
            });
        },
        /* End of Login */
        /** System Logs **/
        SetPageLog: function(logDetail){
            return $http({
                method: "POST",
                url: "index.php/LogManagement/setPageLog",
                headers: {
                    'Content-Type': 'application/json'
                },
                data: logDetail
            });
        },
        GetPageLogs: function(){
            return $http({
                method: "GET",
                url: "index.php/LogManagement/getPageLogs",
                headers: {
                    'Content-Type': 'application/json'
                }
            });
        },
        /** Inventory **/
        GetInventoryToday: function(){
            return $http({
                method: "GET",
                url: locationString + "inventory/get/today",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        GetInventoryList: function(){
            return $http({
                method: "GET",
                url: locationString + "inventory/get/list",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        AddNewInventory: function(inventory){
            return $http({
                method: "POST",
                url: locationString + "inventory/add",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:inventory
            })
        },
        EditInventoryItem: function(inventory){
            return $http({
                method: "POST",
                url: locationString + "inventory/edit",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:inventory
            })
        },
        DeleteInventoryItem: function(inventory){
            return $http({
                method: "DELETE",
                url: locationString + "inventory/delete",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:inventory
            })
        },
        /** Customer **/
        GetCustomerList: function(){
            return $http({
                method: "GET",
                url: locationString + "customer/get/list",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        AddNewCustomer: function(customer){
            return $http({
                method: "POST",
                url: locationString + "customer/add",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:customer
            })
        },
        EditCustomer: function(customer){
            return $http({
                method: "POST",
                url: locationString + "customer/edit",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:customer
            })
        },
        DeleteCustomer: function(customer){
            return $http({
                method: "DELETE",
                url: locationString + "customer/delete",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:customer
            })
        },

        /** Receivables */
        GetReceivablesToday: function(){
            return $http({
                method: "GET",
                url: locationString + "receivables/get/today",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        GetReceivableList: function(){
            return $http({
                method: "GET",
                url: locationString + "receivables/get/list",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        AddNewReceivable: function(receivable){
            return $http({
                method: "POST",
                url: locationString + "receivables/add",
                headers: {
                    'Content-Type': 'application/json'
                },
                data: receivable
            })
        },
        EditReceivable: function(receivable){
            return $http({
                method: "POST",
                url: locationString + "receivables/edit",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:receivable
            })
        },
        DeleteReceivable: function(receivable){
            return $http({
                method: "DELETE",
                url: locationString + "receivables/delete",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:receivable
            })
        },
        
        /** Payables **/
        GetPayablesToday: function(){
            return $http({
                method: "GET",
                url: locationString + "payables/get/today",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        GetPayableList: function(){
            return $http({
                method: "GET",
                url: locationString + "payables/get/list",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        AddNewPayable: function(payable){
            return $http({
                method: "POST",
                url: locationString + "payables/add",
                headers: {
                    'Content-Type': 'application/json'
                },
                data: payable
            })
        },
        EditPayable: function(payable){
            return $http({
                method: "POST",
                url: locationString + "payables/edit",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:payable
            })
        },
        DeletePayable: function(payable){
            return $http({
                method: "DELETE",
                url: locationString + "payables/delete",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:payable
            })
        },

        /** Purchase Order **/
        GetPurchaseOrderToday: function(){
            return $http({
                method: "GET",
                url: locationString + "po/get/today",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        GetPurchaseOrderList: function(){
            return $http({
                method: "GET",
                url: locationString + "po/get/list",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        AddPurchaseOrder: function(po){
            return $http({
                method: "POST",
                url: locationString + "po/add",
                headers: {
                    'Content-Type': 'application/json'
                },
                data: po
            })
        },
        EditPurchaseOrder: function(po){
            return $http({
                method: "POST",
                url: locationString + "po/edit",
                headers: {
                    'Content-Type': 'application/json'
                },
                data: po
            })
        },
        ApplyInventoryChanges: function(po){
            return $http({
                method: "POST",
                url: locationString + "po/changes/inventory",
                headers: {
                    'Content-Type': 'application/json'
                },
                data: po
            })
        },

        /** Suppliers **/
        GetSupplierList: function(){
            return $http({
                method: "GET",
                url: locationString + "supplier/get/list",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        AddNewSupplier: function(supplier){
            return $http({
                method: "POST",
                url: locationString + "supplier/add",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:supplier
            })
        },
        EditSupplier: function(supplier){
            return $http({
                method: "POST",
                url: locationString + "supplier/edit",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:supplier
            })
        },
        DeleteSupplier: function(supplier){
            return $http({
                method: "DELETE",
                url: locationString + "supplier/delete",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:supplier
            })
        },
        /** User Management  **/
        GetUserList: function(){
            return $http({
                method: "GET",
                url: "index.php/UserManagement/getAllUsers",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },
        AddNewUser: function(user){
            return $http({
                method: "POST",
                url: "index.php/UserManagement/addNewUser",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:user
            })
        },
        EditUser: function(user){
            return $http({
                method: "POST",
                url: "index.php/UserManagement/editUser",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:user
            })
        },
        DeleteUser: function(user){
            return $http({
                method: "DELETE",
                url: "index.php/UserManagement/deleteUser",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:user
            })
        },
        ChangePassword: function(user){
            console.log(user);
            return $http({
                method: "POST",
                url: "index.php/UserManagement/changePassword",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:user
            })
        },
        /** Generate Report */
        GenerateReport: function(report){
            return $http({
                method: "POST",
                url: locationString + "reports/generate",
                headers: {
                    'Content-Type': 'application/json'
                },
                data:report
            })
        },
        GetOutboundDeliveryList: function(){
            return $http({
                method: "GET",
                url: locationString + "outbound/get/list",
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        },

    }

}]);