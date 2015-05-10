var app = angular.module('myApp', [] );

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.controller("ListController", function($scope, $http, Json2Request) {

    $scope.products = [];

    /**
     * Current product
     */
    $scope.product = {
        "title": "",
        description: "",
        photo: ""
    };

    $scope.getProduct = function(id) {
        $http.get("/app_dev.php/product/" + id + "/", {}, {})
            .success(function(dataFromServer, status, headers, config) {
                $scope.product = dataFromServer;
            })
            .error(function(data, status, headers, config) {
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
        $http.get("/app_dev.php/products/", {}, {})
            .success(function(dataFromServer, status, headers, config) {
                $scope.products = dataFromServer;
            })
            .error(function(data, status, headers, config) {
                console.log("Submitting form failed!");
            });
    }

    $scope.removeProduct = function(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            $http.delete("/app_dev.php/product/" + id + "/", {}, {})
                .success(function(dataFromServer, status, headers, config) {
                    var newScope = new Array();
                    $scope.products.forEach(function(item, index, arr){
                        if (item.id !== id) {
                            newScope.push(item);
                        }
                    });
                    $scope.products = newScope;
                })
                .error(function(data, status, headers, config) {
                    console.log("Submitting form failed!");
                });
        }
    }

    $scope.updateProduct = function(product) {
        $scope.cfdump = "";
        $http({
            method: "put",
            url: "/app_dev.php/product/" + product.id + "/",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {
                "title": product.title,
                "description": product.description,
                "photo": product.photo
            },
            transformRequest: function(obj) {
                return Json2Request(obj);
            }
        })
            .success(function(dataFromServer, status, headers, config) {
                $scope.products.forEach(function(item, index, arr){
                    if (item.id === product.id) {
                        arr[index] = product;
                    }
                });
                $scope.emptyProduct();
            })
            .error(function(data, status, headers, config) {
                console.log("Submitting form failed!");
            });
    }

    $scope.createProduct = function(product) {
        $scope.cfdump = "";
        $http({
            method: "POST",
            url: "/app_dev.php/product/",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {
                "title": product.title,
                "description": product.description,
                "photo": product.photo
            },
            transformRequest: function(obj) {
                return Json2Request(obj);
            }
        })
            .success(function(dataFromServer, status, headers, config) {
                $scope.emptyProduct();
                $scope.reloadListProduct();
            })
            .error(function(data, status, headers, config) {
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

console.log('1111');