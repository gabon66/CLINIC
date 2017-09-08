
var ClinicApp = angular.module('AppClinic', ['ui.bootstrap','ngRoute']);

// Configuración de las rutas


ClinicApp.config(function($routeProvider,$locationProvider) {
    $locationProvider.hashPrefix('');
    $routeProvider
        .when('/', {
            templateUrl: '../bundles/portal/pages/gateways.html',
            controller: 'gwController'
        })
        .when('/gateways', {
            templateUrl: '../bundles/portal/pages/gateways.html',
            controller: 'gwController'
        })
        .when('/pacientes', {
            templateUrl: '../bundles/portal/pages/pacientes.html',
            controller: 'pacientesController'
        })
        .when('/mediciones', {
            templateUrl: '../bundles/portal/pages/mediciones.html',
            controller: 'medicionesController'
        })


});

ClinicApp.controller('mainController', function($scope,$http) {
    console.log("main control");
});

ClinicApp.controller('gwController', function($scope,$http) {
    console.log("gw control");
});


ClinicApp.controller('pacientesController', function($scope,$uibModal,$http) {
    console.log("pacientes control");
    $scope.pacientes=new  Array();
    var getPacinests=function () {

        $http({
            method: 'GET',
            url: Routing.generate('get_pacientes')
        }).then(function (response) {

            $scope._pacientes=response.data;
            for (var a = 0; a < $scope._pacientes.length; a++) {
                $scope.paciente=$scope._pacientes[a];

                $scope.paciente.data=angular.fromJson($scope._pacientes[a].data);
                //console.log(pac);
                $scope.pacientes.push($scope.paciente);
            }

            console.log($scope.pacientes);

        });
    }

    $scope.showMediciones= function (user) {


        var modalInstance = $uibModal.open({
            templateUrl: 'mediciones.html',
            controller: 'ModalMedicionesCtrol',
            size:'lg',
            resolve: {
                user: function () {
                    return user;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.selected = selectedItem;
        }, function () {
            //$log.info('Modal dismissed at: ' + new Date());
        });
};

    getPacinests();
});
ClinicApp.controller('ModalMedicionesCtrol', function($scope,$http, $uibModalInstance, user) {
    $scope.user = user;
    $scope.mediciones=new  Array();
    console.log(user);
    var getMediciones =function () {
        $http({
            method: 'GET',
            url: Routing.generate('get_medicion')+"/id_patient/"+user.id
        }).then(function (response) {

            $scope._mediciones=response.data;
            console.log(response);
            for (var a = 0; a < $scope._mediciones.length; a++) {
                $scope.medicion=$scope._mediciones[a];
                $scope.medicion.data=angular.fromJson($scope._mediciones[a].data);
                //console.log(pac);
                $scope.mediciones.push($scope.medicion);
            }
        });

    };
    getMediciones();
    console.log(user);
    $scope.cerrar=function () {
        $uibModalInstance.dismiss('cancel');
    };


});


ClinicApp.controller('medicionesController', function($scope,$http) {

    $scope.mediciones=new  Array();
    var getData=function () {

        $http({
            method: 'GET',
            url: Routing.generate('get_mediciones')
        }).then(function (response) {

            $scope._mediciones=response.data;
            for (var a = 0; a < $scope._mediciones.length; a++) {
                $scope.medicion=$scope._mediciones[a];

                $scope.medicion.data=angular.fromJson($scope._mediciones[a].data);
                //console.log(pac);
                $scope.mediciones.push($scope.medicion);
            }

            console.log($scope.mediciones);

        });
    }

    getData();

});