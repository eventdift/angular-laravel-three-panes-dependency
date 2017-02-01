mainApp.controller('citiesController', function($scope,$http,API_URL) {
        
    var distribution = this;

    //editors logic
    distribution.showEditor1 = false;
    distribution.showEditor2 = false;
    
    distribution.Cities = {cityname:'',state:0};
    distribution.Areas = {areaname:'',city:0};

    //editor functions
    distribution.Editor1 = function() {
        distribution.showEditor1 = true;
        distribution.Cities.cityname = '';
    };
    distribution.cancelEditor1 = function(){
        distribution.showEditor1 = false;
    }

    distribution.Editor2 = function() {
        distribution.showEditor2 = true;
        distribution.Areas.areaname = '';
    };
    distribution.cancelEditor2 = function(){
        distribution.showEditor2 = false;
    }
    <!---->

    distribution.setTab2 = function(val){
        console.log(val);
        distribution.tab2 = val || 0;
        distribution.Areas.city = val;
        distribution.cancelEditor2();
        var API_URL3 = API_URL + '/area/'+ val;
        $http.get(API_URL3)
            .success(function(response) {
                console.log(response);
                distribution.AreaReturn = response;
            }).error(function(error) {
            console.log(error);
            alert('This is embarassing. An error has occured. Please check the log for details');
        });
    }

    distribution.setTab = function(val){
        distribution.processing = true;
        console.log(val);
        distribution.tab = val || 0;
        distribution.tab2 = 0;
        distribution.Cities.state = val;
        distribution.AreaReturn = [];
        distribution.cancelEditor1();
        distribution.cancelEditor2();
        var API_URL2 = API_URL + '/cities/'+ val;
        $http.get(API_URL2)
            .success(function(response) {
                console.log(response);
                distribution.CityReturn = response;
                distribution.processing = false;
            }).error(function(error) {
            console.log(error);
            alert('This is embarassing. An error has occured. Please check the log for details');
        });
    }

    
        //save city
distribution.saveCity = function() {
        console.log(distribution.Cities);
        $http({
            method: 'POST',
            url: API_URL + '/' + 'city/store',
            data: distribution.Cities,            
        }).success(function(response) {
                distribution.setTab(distribution.tab); 
                distribution.cancelEditor1();   
        }).error(function(response) {
            console.log(response);
            alert('This is embarassing. An error has occured. Please check the log for details');
        });
    };

    //save new Area(s)
    distribution.saveArea = function() {
        console.log(distribution.Areas);
        $http({
            method: 'POST',
            url: API_URL + '/' + 'area/store',
            data: distribution.Areas,
            
        }).success(function(response) {
                distribution.setTab2(distribution.tab2);
                distribution.cancelEditor1();
        }).error(function(response) {
            console.log(response);
            alert('This is embarassing. An error has occured. Please check the log for details');
        });
    };

    
    //assign marketer
    distribution.toggle = function(cityName,id){
        distribution.areaId = id;
        distribution.formTitle = cityName;
        $('#myModal').modal('show');
    }

    distribution.attachMarketer = function(){
        $http.get('area/'+distribution.areaId+'/attachMarketer/'+distribution.marketerName)
        .success(function(){
            distribution.setTab2(distribution.tab2);
            $('#myModal').modal('hide');
        })
        .error(function(error){
            console.log(error);
        })
    }


    distribution.confirmDelete = function(Locator,cityid) {
        console.log(cityid);
        switch(Locator){
            case 'area':
                var message = 'Area ?';
                var APP_URL = '/area/';
                break;
            case 'city':
                var message = 'City ?';
                var APP_URL = '/cities/';
                break;
            default:
                break;
        };
        var isConfirmDelete = confirm('Are you sure you want to remove this ' + message + 'This would result in the REMOVAL OF AREAS in the ' + message);
        if (isConfirmDelete) {
            $http({
                method: 'DELETE',
                url: API_URL + APP_URL + cityid
            }).
                    success(function(data){
                        console.log(data);
                        switch(Locator){
                            case 'city':
                                distribution.setTab(distribution.tab);    
                                break;
                            case 'area':
                                distribution.setTab2(distribution.tab2);
                                break;
                            default :
                                break;
                        };
                    }).
                    error(function(data) {
                        console.log(data);
                        alert('Unable to delete');
                    });
        } else {
            return false;
        }
    }

});