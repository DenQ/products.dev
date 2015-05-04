// объявляем модуль и присваиваем его переменной myApp
var myApp = angular.module('myApp', [] );

myApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});


myApp.controller("ListController", function($scope, $http) {

    /**
     * Current product
     */
    $scope.product = {
        title: "",
        description: ""
    };

    $scope.editProduct = function(id) {
        var responsePromise = $http.get("/app_dev.php/product/" + id + "/", {}, {});
        responsePromise.success(function(dataFromServer, status, headers, config) {
            $scope.product = dataFromServer;
        });
        responsePromise.error(function(data, status, headers, config) {
            console.log("Submitting form failed!");
        });
    }

    $scope.reloadListProduct = function() {
        $scope.products = [];
        var responsePromise = $http.get("/app_dev.php/products/", {}, {});
        responsePromise.success(function(dataFromServer, status, headers, config) {
            $scope.products = dataFromServer;
        });
        responsePromise.error(function(data, status, headers, config) {
            console.log("Submitting form failed!");
        });
    }

    $scope.removeProduct = function(id) {
        if (confirm('remove')) {
            var responsePromise = $http.delete("/app_dev.php/product/" + id + "/", {}, {});
            responsePromise.success(function(dataFromServer, status, headers, config) {
                $scope.reloadListProduct();
            });
            responsePromise.error(function(data, status, headers, config) {
                console.log("Submitting form failed!");
            });
        }
    }

    $scope.reloadListProduct();
});

myApp.directive('myCustomer', function() {
    return {
        templateUrl: '/dialog.html'
    };
});

//myApp.controller("MyController", function($scope, $http) {
//        //var responsePromise = $http.put("/app_dev.php/product/1/", {title:'title 555'}, {});
//        //var responsePromise = $http.put("/app_dev.php/product/2/", dataObject, {});
//        //var responsePromise = $http.put("http://products.dev/app_dev.php/product/1/", dataObject, {});
//    $scope.cfdump = "";
//    var responsePromise = $http({
//        method: "put",
//        url: "http://products.dev/app_dev.php/product/1/",
//        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
//        data: {
//            "title": "title 555"
//        },
//        transformRequest: function(obj) {
//            var str = [];
//            for(var p in obj)
//                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
//            return str.join("&");
//        }
//    });
//        //responsePromise.success(function(dataFromServer, status, headers, config) {
//        //    console.log(dataFromServer);
//        //});
//        //responsePromise.error(function(data, status, headers, config) {
//        //    console.log(status);
//        //    //alert("Submitting form failed!");
//        //});
//    //}
//});