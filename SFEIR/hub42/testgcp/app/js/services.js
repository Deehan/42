"use strict";

shareApp.factory("Obj", function ($http) {
    var API_URI = '/api/objects';

    return {

        fetch : function() {
            return $http.get(API_URI);
        },

        create : function(object) {
            return  $http.post(API_URI, object);
        },

        remove  : function(id) {
            return $http.delete(API_URI + '/' + id);
        },

        fetchOne : function(id) {
            return $http.get(API_URI + '/' + id);
        },

        update : function(object, id) {
             return $http.put(API_URI + '/' + id, object);
        },

        filter : function(filters) {
             return $http.get(API_URI, {params: {Type: filters.Type, Cap: filters.Cap, Price: filters.Price, Model: filters.Model}});
        }

    };

});

shareApp.factory("Sheets", function ($http) {
    var API_URI = '/api/info';

    return {

        fetch : function(name) {
            return $http.get(API_URI, {params: {Sheet: "car_sheet", Format: "json", Onglet: name}});
        }

    };

});
