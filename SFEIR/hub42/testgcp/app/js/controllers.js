"use strict";

shareApp.controller("homeController" ,function ($scope) {

    $scope.user = '42';

});

shareApp.controller("objectsController" ,function ($scope, Obj, Sheets, $location) {

	$scope.tri = 'Title';

    Obj.fetch().success(function(resp){
        $scope.objects = resp;
    });

    Sheets.fetch("marque").success(function(resp) {
      $scope.models = resp.Values;
    });
    Sheets.fetch("models").success(function(resp) {
      $scope.types = resp.Values;
    });

    $scope.deleteObject = function(index, id) {
        Obj.remove(id)
            .success(function(resp){
                $scope.objects.splice(index, 1);
            }
        );
    };

    $scope.filterObject = function(filter) {
        Obj.filter(filter)
          .success(function(resp) {
            $scope.objects = resp;
        	  $location.path("/objects");
		        }
        );
    };

	$scope.trier = function (tri) {
		if ($scope.tri === tri) {
			$scope.reverse = !$scope.reverse
		}
		$scope.tri = tri;
	}

});

shareApp.controller('editObjectController', function($scope, Obj, Sheets, $routeParams, $location){

    var objectId = $routeParams.id;

    Obj.fetchOne(objectId).success(function(object){
        $scope.obj = object[0];
    });

    Sheets.fetch("marque").success(function(resp) {
      $scope.models = resp.Values;
    });
    Sheets.fetch("models").success(function(resp) {
      $scope.types = resp.Values;
    });

    $scope.updateObject = function(object){
        Obj.update(object, objectId)
            .success(function() {
                $location.path('/objects');
            })
            .error(function(resp){
                console.log(resp);
            });
    };
});

shareApp.controller("objectFormController" ,function ($scope, Obj, Sheets, $location) {

    $scope.showAlert = false;

    Sheets.fetch("marque").success(function(resp) {
      $scope.models = resp.Values;
    });
    Sheets.fetch("models").success(function(resp) {
      $scope.types = resp.Values;
    });

    $scope.addObject = function(object) {
        console.log(object);
        Obj.create(object)
            .success(function(){
                var newobject = {};
                angular.copy(object, newobject)
                $scope.objects = [];
                $scope.objects.push(newobject);
                $scope.obj = {};
                $location.path('/objects');
            })
    };
});
