<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<base href="http://localhost:8080/pektounleashed/app/">-->
    <title>Migatsu Inventory System</title>
    <!--build:js public/assets/js/main.min.js -->
    <script src="public/assets/js/jquery-2.2.1.js"></script>
    <script src="public/assets/js/angular.min.js"></script>
    <script src="public/assets/js/angular-animate.min.js"></script>
    <script src="public/assets/js/angular-aria.min.js"></script>
    <script src="public/assets/js/angular-material.min.js"></script>
    <script src="public/assets/js/angular-messages.min.js"></script>
    <script src="public/assets/js/jquery.scrollbar.min.js"></script>
    
    <!-- <script src="public/assets/libraries/Highcharts/highcharts.js"></script>
    <script src="public/assets/libraries/Highcharts/highcharts-custom.js"></script> -->
    <script src="public/assets/js/peity.js"></script>
    <script src="public/assets/js/tinycolor.js"></script>
    <script src="public/assets/js/md-color-picker.js"></script>
    <script src="public/assets/js/uirouter.js"></script>
    <script src="public/assets/js/moment.js"></script>
    <script src="public/assets/js/lodash.js"></script>
    <script src="public/assets/js/angular-local-storage.js"></script>
    <!-- endbuild -->
    <!--build:js angular/angular.min.js -->
    <script src="public/angular/Shared/mainContentManager.js"></script>
    <script src="public/angular/Shared/mainDirectives.js"></script>
    <script src="public/angular/Shared/mainFactory.js"></script>
    <script src="public/angular/Shared/mainRouter.js"></script>
    <script src="public/angular/main.js"></script>

    <!-- Project -->
    <script src="public/angular/Templates/Login/loginController.js"></script>
    <script src="public/angular/Templates/Home/homeController.js"></script>
    <script src="public/angular/Templates/Help/helpController.js"></script>
    <script src="public/angular/Templates/Reports/reportsController.js"></script>
    <script src="public/angular/Templates/Logs/logsController.js"></script>
    <script src="public/angular/Templates/User Management/userManagementController.js"></script>
    <script src="public/angular/Templates/User Management/userManagementDialogController.js"></script>
    <script src="public/angular/Templates/Customer/customerController.js"></script>
    <script src="public/angular/Templates/Customer/customerDialogController.js"></script>
    <script src="public/angular/Templates/Inventory/inventoryController.js"></script>
    <script src="public/angular/Templates/Inventory/inventoryDialogController.js"></script>
    <script src="public/angular/Templates/Payables/payablesController.js"></script>
    <script src="public/angular/Templates/Payables/payablesDialogController.js"></script>
    <script src="public/angular/Templates/Receivables/receivablesController.js"></script>
    <script src="public/angular/Templates/Receivables/receivablesDialogController.js"></script>
    <script src="public/angular/Templates/Purchase Order/purchaseOrderController.js"></script>
    <script src="public/angular/Templates/Purchase Order/purchaseOrderDialogController.js"></script>
    <script src="public/angular/Templates/Outbound Delivery/outboundDeliveryController.js"></script>
    <script src="public/angular/Templates/Outbound Delivery/outboundDeliveryDialogController.js"></script>
    <script src="public/angular/Templates/Supplier/supplierController.js"></script>
    <script src="public/angular/Templates/Supplier/supplierDialogController.js"></script>
    <script src="public/angular/Templates/Modals/notificationController.js"></script>
    <!--build:css css/styles.min.css-->
    <link rel="stylesheet" href="public/assets/css/jquery.scrollbar.css">
    <link rel="stylesheet" href="public/assets/css/material.css">
    <link rel="stylesheet" href="public/assets/css/styles.css">
    <link rel="stylesheet" href="public/assets/css/md-color-picker.css">
    <link rel="stylesheet" href="public/assets/css/RGraph.css">
    <link rel="stylesheet" href="public/assets/css/mainstyle.css">

    <!--endbuild-->
</head>
<body ng-app="MainApplication" ng-controller="MainController" ng-class="{'login': MainState == 'login'}" ng-cloak layout="row" layout-align="start stretch">
    <hud-styles></hud-styles>
    <!--START: LOADER-->
     <div ng-if="loadstate" class="load-container">
        <div class="loader-circle"></div>
        <div class="loader-line-mask">
            <div class="loader-line"></div>
        </div>
    </div> 
    <!--END: LOADER-->
    <div flex layout="row" layout-align="start stretch">
        <div flex="15" layout="column" layout-align="start stretch" class="table" ng-if="MainState != 'login'">
            <div flex="5" layout layout-align="center center">
                <span flex layout layout-align="center stretch"> <!-- Placeholder 1 --></span>
            </div>
            <div flex="15" layout layout-align="start center">
                <div flex="30"  layout layout-align="start center">
                    <div layout layout layout-align="center stretch" class="user-profile"> 
                        <div flex layout layout-align="center center">{{initials}}</div>
                    </div>
                </div>
                <div flex layout="column" layout-align="start stretch">
                    <span>{{userDetails.name}}</span>
                    <span my-setter height-in-percent="1"></span>
                    <!-- <span flex="none" my-setter height-in-percent="1"></span> -->
                    <span>{{userDetails.role}}</span>
                    
                    
                </div>
            </div>
            <div flex class="list" layout="column" layout-align="start stretch" ng-if="MainState != 'login'">
                <div flex="none" my-setter height-in-percent="4" layout layout-align="start stretch">
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <div flex layout layout-align="start center"> Menu</div>
                </div>
                <div class="item" my-setter height-in-percent="7" layout layout-align="start stretch" 
                 ng-class="{'state-active': MainState == 'home'}" ng-click="ChangeState('home')" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'home'}"></span>
                    <md-tooltip md-direction="right">This is your today's transactions</md-tooltip>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <div flex layout layout-align="start center">Transactions</div>
                </div> 
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('customer')" 
                    ng-class="{'state-active': MainState == 'customer'}">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'customer'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">View your clients here.</md-tooltip>
                    <div flex layout layout-align="start center">Customers</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('supplier')"
                    ng-class="{'state-active': MainState == 'supplier'}">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'supplier'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">View your suppliers here.</md-tooltip>
                    <div flex layout layout-align="start center">Suppliers</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('inventory')"
                    ng-class="{'state-active': MainState == 'inventory'}">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'inventory'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">More details regarding AMAT</md-tooltip>
                    <div flex layout layout-align="start center">Inventory</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('receivables')"
                    ng-class="{'state-active': MainState == 'receivables'}" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'receivables'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">More details regarding AMAT</md-tooltip>
                    <div flex layout layout-align="start center">Receivables</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('payables')"
                    ng-class="{'state-active': MainState == 'payables'}" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'payables'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">More details regarding AMAT</md-tooltip>
                    <div flex layout layout-align="start center">Payables</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('purchase-order')"
                    ng-class="{'state-active': MainState == 'purchase-order'}" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'purchase-order'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">More details regarding AMAT</md-tooltip>
                    <div flex layout layout-align="start center">Purchase Order</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('outbound-delivery')"
                    ng-class="{'state-active': MainState == 'outbound-delivery '}" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'outbound-delivery'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">Scheduled Delivery for today</md-tooltip>
                    <div flex layout layout-align="start center">Outbound Delivery Page</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('user-management')"
                    ng-class="{'state-active': MainState == 'user-management'}" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'user-management'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">Add and modify user access.</md-tooltip>
                    <div flex layout layout-align="start center">User Management</div>
                </div>
                <!-- <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('help')">
                    <span flex="none" my-setter width-in-percent="15" layout layout-align="center stretch">
                        <md-icon md-svg-src="{{SVG.info}}" layout layout-align="center center"></md-icon>
                    </span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">More details regarding AMAT</md-tooltip>
                    <div flex layout layout-align="start center">Reports</div>
                </div> -->
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('logs')"
                    ng-class="{'state-active': MainState == 'logs'}" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'logs'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">View Inventory System's activities</md-tooltip>
                    <div flex layout layout-align="start center">System Logs</div>
                </div>
                <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('reports')"
                    ng-class="{'state-active': MainState == 'reports'}" ng-if="userDetails.role ==='Administrator'">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'reports'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">Generate various reports</md-tooltip>
                    <div flex layout layout-align="start center">Reports</div>
                </div>
                <!-- <div class="item" flex="none" my-setter height-in-percent="7" layout layout-align="start stretch" ng-click="ChangeState('help')"
                    ng-class="{'state-active': MainState == 'help'}">
                    <span flex="none" my-setter width-in-percent="3" ng-class="{'state-active-bar': MainState == 'help'}"></span>
                    <span flex="none" my-setter width-in-percent="5"></span>
                    <md-tooltip md-direction="right">More details regarding the system</md-tooltip>
                    <div flex layout layout-align="start center">Help</div>
                </div> -->
            </div>
        </div>
        <div flex layout="column" layout-align="start stretch">
            <div flex="5" layout class="master-header" ng-if="MainState != 'login'">
                <div flex="none" class="homebtn" ng-click="PageChange()" layout layout-align="center center"><!--ng-if="State.current.name!='ao'" -->
                    <!-- <i class="material-icons">home</i> -->
                </div>
                <div my-setter width-in-percent="1"></div>
                <div flex="none" my-setter width-in-percent="40" class="company-text" layout layout-align="start center">
                    <!-- <img src="public/assets/images/logo/amat-logo.jpg" /> -->
                    <span> Migatsu Inventory System </span>
                </div>
                <div flex></div>
                <div flex="25" layout="row" layout-align="center stretch" class="info-tab">
                    <div flex="none" my-setter width-in-percent="20"></div>
                    <div flex layout="column" layout-align="center end">
                        <span class="greet">Hello, {{userDetails.name}}</span>
                    </div>
                    <div flex="none" my-setter width-in-percent="5"></div>
                    <div flex="10" layout="column" layout-align="center end" ng-click="SignOut($event)">
                        <md-icon md-svg-src="{{SVG.logout}}" class="pointer" flex></md-icon>
                    </div>
                </div>
            </div>
            <div flex ui-view layout class="main-container"></div>

        </div>
    </div>
    
</body>
</html>
