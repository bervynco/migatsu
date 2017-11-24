/* Content Manager */
var mainConfigManager = angular.module('Main-ContentManager', ["ngMaterial"]);
mainConfigManager.provider('ConfigurableItems', function ConfigurableItemsProvider() {
    var Labels = {
        DashboardTitle: "P&G IT OPERATIONAL EXCELLENCE DASHBOARD"
    }
    var StatusColors = {
        red: "#f04953",
        green: "#FD5109",
        amber: "#ffd144",
        nodata: "transparent",
        downtime: "gray",
        "default": "white"
    }
    var ComponentColors = {
        header: "#293842"
    }

    var FontFamily = {
        main: "Calibri",
    }

    var svgsrc = "public/assets/images/icons/";
    var SVG = {
        testicon: svgsrc + "testicon.svg",
        menu: svgsrc + "menu.svg",
        morevert: svgsrc + "morevert.svg",
        back: svgsrc + "back.svg",
        home: svgsrc + "home.svg",
        admin: svgsrc + "admin.svg",
        crosshair: svgsrc + "crosshair.svg",
        clear: svgsrc + "clear.svg",
        add: svgsrc + "add.svg",
        remove: svgsrc + "remove.svg",
        chev_right: svgsrc + "chev_right.svg",
        search: svgsrc + "search.svg",
        mail: svgsrc + "mail.svg",
        lock: svgsrc + "closed-lock.svg",
        globe: svgsrc + "worldwide.svg",
        notepad: svgsrc + "notepad.svg",
        man: svgsrc + "man.svg",
        info: svgsrc + "info.svg",
        infoblack: svgsrc + "info-black.svg",
        note: svgsrc + "note.svg", //white version of notepad
        chart: svgsrc + "bar-chart.svg",
        management: svgsrc + "teamwork.svg",
        notification: svgsrc + "bell.svg",
        user: svgsrc + "avatar.svg",
        user_white: svgsrc + "avatar_white.svg",
        user_group: svgsrc + "user-group.svg",
        accept: svgsrc + "checking.svg",
        reject: svgsrc + "cancel.svg",
        check: svgsrc + "tick.svg",
        cross: svgsrc + "cross.svg",
        sad: svgsrc + "sad.svg",
        register: svgsrc + "register.svg",// registration for sidenav
        logout: svgsrc + "logout.svg", // logout button
        locked: svgsrc + "locked.svg",
        manual: svgsrc + "manual-book.svg",
        remove_bin: svgsrc + "remove_bin.svg",
        edit: svgsrc + "edit.svg",
        left: svgsrc + "left-arrow.svg",
        right: svgsrc + "right-arrow.svg",
        delivery: svgsrc + "delivery.svg",
        move_to: svgsrc + "move-to.svg",
        lock: svgsrc + "lock.svg",
        hourglass: svgsrc + "hourglass.svg"
    }

    this.$get = function () {
        return {
            Labels: Labels,
            StatusColors: StatusColors,
            SVG: SVG,
            FontFamily: FontFamily,
            ComponentColors: ComponentColors,
        }
    }
});
mainConfigManager.config(function (ConfigurableItemsProvider, $mdThemingProvider, $mdIconProvider) {
    // localStorageServiceProvider
    //     .setStorageType('sessionStorage')
    //     .setDefaultToCookie(false);
    //, localStorageServiceProvider
    var darkContrast = true;

    $mdThemingProvider.definePalette('defaultTheme', {
        '50': "#FD5109",
        '100': "#FD5109",
        '200': "#FD5109",
        '300': "#FD5109",
        '400': "#FD5109",
        '500': "#FD5109",
        '600': "#FD5109",
        '700': "#FD5109",
        '800': "#FD5109",
        '900': "#FD5109",
        'A100': "#FD5109",
        'A200': "#FD5109",
        'A400': "#FD5109",
        'A700': "#FD5109",
        'contrastDefaultColor': 'light',    // whether, by default, text (contrast)
        // on this palette should be dark or light
        'contrastDarkColors': ['50', '100', //hues which contrast should be 'dark' by default
         '200', '300', '400', 'A100'],
        'contrastLightColors': undefined    // could also specify this if default was 'dark'
    });
    $mdThemingProvider.definePalette('primaryTheme', {
        '50': "#64ff00",
        '100': "#64ff00",
        '200': "#64ff00",
        '300': "#64ff00",
        '400': "#64ff00",
        '500': "#64ff00",
        '600': "#64ff00",
        '700': "#64ff00",
        '800': "#64ff00",
        '900': "#64ff00",
        'A100': "#64ff00",
        'A200': "#64ff00",
        'A400': "#64ff00",
        'A700': "#64ff00",
        'contrastDefaultColor': 'light',    // whether, by default, text (contrast)
        // on this palette should be dark or light
        'contrastDarkColors': ['50', '100', //hues which contrast should be 'dark' by default
         '200', '300', '400', 'A100'],
        'contrastLightColors': undefined    // could also specify this if default was 'dark'
    });
    $mdThemingProvider.definePalette('warnTheme', {
        '50': "#FD5109",
        '100': "#FD5109",
        '200': "#FD5109",
        '300': "#FD5109",
        '400': "#FD5109",
        '500': "#FD5109",
        '600': "#FD5109",
        '700': "#FD5109",
        '800': "#FD5109",
        '900': "#FD5109",
        'A100': "#FD5109",
        'A200': "#FD5109",
        'A400': "#FD5109",
        'A700': "#FD5109",
        'contrastDefaultColor': 'light',    // whether, by default, text (contrast)
        // on this palette should be dark or light
        'contrastDarkColors': ['50', '100', //hues which contrast should be 'dark' by default
         '200', '300', '400', 'A100'],
        'contrastLightColors': undefined    // could also specify this if default was 'dark'
    });
    $mdThemingProvider.theme('default')
        .accentPalette('defaultTheme')
        .primaryPalette('primaryTheme')
        .warnPalette('warnTheme').dark();
});
mainConfigManager.run(function ($rootScope, $window) {
  $rootScope._ = $window._;
});