/* For Authentication and UI-Router */
var mainRouter = angular.module('Main-Router', ["ui.router"]); //
mainRouter.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/login');
    $stateProvider
        .state('site', {
            'abstract': true,
            template: '<div ui-view layout flex/>'
        })
        //LoginMain Page
        .state('login', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/login",
            templateUrl: "public/angular/Templates/Login/login.html",
            controller: "LoginController"
        })
        .state('home', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/home",
            templateUrl: "public/angular/Templates/Home/home.html",
            controller: "HomeController"
        })
        .state('reports', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/reports",
            templateUrl: "public/angular/Templates/Reports/reports.html",
            controller: "ReportsController"
        })
        .state('help', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/help",
            templateUrl: "public/angular/Templates/Help/help.html",
            controller: "HelpController"
        })
        .state('logs', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/logs",
            templateUrl: "public/angular/Templates/Logs/logs.html",
            controller: "LogController"
        })
        .state('user-management', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/um",
            templateUrl: "public/angular/Templates/User Management/userManagement.html",
            controller: 'UserManagementController'
        })
        .state('customer', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/customer",
            templateUrl: "public/angular/Templates/Customer/customer.html",
            controller: 'CustomerController'
        })
        .state('inventory', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/inventory",
            templateUrl: "public/angular/Templates/Inventory/inventory.html",
            controller: 'InventoryController'
        })
        .state('receivables', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/receivables",
            templateUrl: "public/angular/Templates/Receivables/receivables.html",
            controller: 'ReceivablesController'
        })
        .state('payables', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/payables",
            templateUrl: "public/angular/Templates/Payables/payables.html",
            controller: 'PayablesController'
        })
        .state('purchase-order', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/po",
            templateUrl: "public/angular/Templates/Purchase Order/purchaseOrder.html",
            controller: 'PurchaseOrderController'
        })
        .state('outbound-delivery', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/delivery",
            templateUrl: "public/angular/Templates/Outbound Delivery/outboundDelivery.html",
            controller: 'OutboundDeliveryController'
        })
        .state('supplier', {
            parent: 'site',
            data: {
                roles: []
            },
            url: "/supplier",
            templateUrl: "public/angular/Templates/Supplier/supplier.html",
            controller: 'SupplierController'
        })

}]);