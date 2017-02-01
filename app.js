var app = angular.module('distributionareas',[])
	.constant('API_URL', 'http://localhost/customizedshop/public').constant('CSRF', '{{ csrf_token() }}');

