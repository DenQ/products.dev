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
        "title": "",
        description: "",
        photo: ""
    };

    $scope.getProduct = function(id) {
        var responsePromise = $http.get("/app_dev.php/product/" + id + "/", {}, {});
        responsePromise.success(function(dataFromServer, status, headers, config) {
            $scope.product = dataFromServer;
        });
        responsePromise.error(function(data, status, headers, config) {
            console.log("Submitting form failed!");
        });
    }

    $scope.emptyProduct = function() {
        $scope.product = {
            title: "",
            description: "",
            photo: ""
        };
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
        if (confirm('Are you sure you want to delete this product?')) {
            var responsePromise = $http.delete("/app_dev.php/product/" + id + "/", {}, {});
            responsePromise.success(function(dataFromServer, status, headers, config) {
                $scope.reloadListProduct();
            });
            responsePromise.error(function(data, status, headers, config) {
                console.log("Submitting form failed!");
            });
        }
    }

    $scope.updateProduct = function(product) {
        $scope.cfdump = "";
        var responsePromise = $http({
            method: "put",
            url: "http://products.dev/app_dev.php/product/" + product.id + "/",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {
                "title": product.title,
                "description": product.description,
                "photo": product.photo
            },
            transformRequest: function(obj) {
                var str = [];
                for(var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            }
        });
        responsePromise.success(function(dataFromServer, status, headers, config) {
            $scope.emptyProduct();
            $scope.reloadListProduct();
        });
        responsePromise.error(function(data, status, headers, config) {
            console.log("Submitting form failed!");
        });
    }

    $scope.createProduct = function(product) {
        $scope.cfdump = "";
        var responsePromise = $http({
            method: "POST",
            url: "http://products.dev/app_dev.php/product/",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {
                "title": product.title,
                "description": product.description,
                "photo": product.photo
            },
            transformRequest: function(obj) {
                var str = [];
                for(var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            }
        });
        responsePromise.success(function(dataFromServer, status, headers, config) {
            $scope.emptyProduct();
            $scope.reloadListProduct();
        });
        responsePromise.error(function(data, status, headers, config) {
            console.log("Submitting form failed!");
        });
    }

    $scope.reloadListProduct();
});

myApp.directive('myCustomer', function() {
    return {
        templateUrl: '/dialog.html'
    };
});