var app = angular.module('myApp', [] );

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller("ListController", function($scope, $http, Json2Request) {

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
                return Json2Request(obj);
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
                return Json2Request(obj);
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

app.directive('myCustomer', function() {
    return {
        templateUrl: '/dialog.html'
    };
});

app.factory('Json2Request', function(){
    return function(obj) {
        var str = [];
        for(var p in obj)
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        return str.join("&");
    }
})