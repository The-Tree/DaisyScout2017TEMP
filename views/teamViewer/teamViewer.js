angular.module('daisyscoutApp.team', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/event/:eventID/team/:teamID', {
    templateUrl: 'views/teamViewer/teamViewer.html',
    controller: 'TeamViewerCtrl'
  });
}])

.controller('TeamViewerCtrl', ['$scope', '$http', '$routeParams', '$filter', function($scope, $http, $routeParams, $filter) {
		
	function getEvent() {
		$http.post('PHP/get_event.php', {eventID: $routeParams.eventID})
        .success(function(data) {
            console.log("SUCCESS - Got Event!", data);
			console.log(typeof data);
            $scope.event = data;
        });
	}
	getEvent();	
	
	function getTeam() {
		$http.post('PHP/get_team.php', {teamID: $routeParams.teamID})
        .success(function(data) {
            console.log("SUCCESS - Got Team!", data);
            $scope.team = data;
        });
	}
	getTeam();
		
	function getTeamRecords() {
		$http.post('PHP/get_eventTeamRecords.php', {eventID: $routeParams.eventID, teamID: $routeParams.teamID})
        .success(function(data) {
            console.log("SUCCESS - Got match records for team!", data);
            $scope.matches = data;
			$scope.order('match_num', false);
        });
	}
	getTeamRecords();
	
	function getInterviewRecords() {
		$http.post('PHP/get_eventInterviewRecord.php', {eventID: $routeParams.eventID, teamID: $routeParams.teamID})
        .success(function(data) {
            console.log("SUCCESS - Got interview records for team!", data);
            $scope.interview = data;
        });
	}
	getInterviewRecords();
	
	var orderBy = $filter('orderBy');
	$scope.reverse = false;
	$scope.order = function(predicate, reverse) {
		$scope.matches = orderBy($scope.matches, predicate, reverse)};
}]);