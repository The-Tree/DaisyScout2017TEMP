angular.module('daisyscoutApp.event', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/event/:eventID', {
    templateUrl: 'views/eventViewer/eventViewer.html',
    controller: 'EventViewerCtrl'
  });
}])

.controller('EventViewerCtrl', ['$scope', '$http', '$routeParams', '$filter', function($scope, $http, $routeParams, $filter) {
	
	$scope.eventID = $routeParams.eventID;	
	
	var Team = function(number, name) {
		this.team_num = number;
		this.name = name;
		this.matchRecords = [];
		this.avgHighScored = 0;
		this.totalHighScored = 0;
		this.avgLowScored = 0;
		this.totalLowScored = 0;
		
		this.totalGearsScored = 0;
		this.totalRotorsScored = 0;
		
	}
	
	Team.prototype.computeAveragesAndTotalsAndStuff = function() {
	
		// Compute total and average number of totes and containers scored.
		if (this.matchRecords.length > 0) {
			for (var i = 0; i < this.matchRecords.length; i++) 
			{
				
				//shooting calculations
				this.totalHighScored += this.matchRecords[i].high_balls_scored;
				this.totalLowScored += this.matchRecords[i].low_balls_scored;
				this.totalGearsScored += this.matchRecords[i].gears;
				this.totalRotorsScored += this.matchRecords[i].teleop_rotors;


			}
			
			//this.avgAutonScored = this.totalAutonScored / this.matchRecords.length;
		}
		
		this.gearsScored = this.totalGearsScored;
		
		// 
	}
		
	console.log($routeParams);
	function getEvent() {
		$http.post('PHP/get_event.php', {eventID: $routeParams.eventID})
        .success(function(data) {
            console.log("SUCCESS - Got Event!", data);
			console.log(typeof data);
            $scope.event = data;
        });
	}
	getEvent();
		
	function getTeams() {
		$http.post('PHP/get_eventTeamList.php', {eventID: $routeParams.eventID})
        .success(function(data) {
            console.log("SUCCESS - Got Teams for event!", data);
            //$scope.teams = data;
			$scope.teams = [];
			for (var i = 0; i < data.length; i++) {
				$scope.teams.push(new Team(data[i].team_num, data[i].name));
			}
			$scope.order('team_num', false);
        });
	}
	getTeams();

	function getMatchRecords() {
		$http.post('PHP/get_eventMatchRecords.php', {eventID: $routeParams.eventID})
        .success(function(data) {
            console.log("SUCCESS - Got match records for event!", data);
			for (var i = 0; i < $scope.teams.length; i++) {
				for (var j = 0; j < data.length; j++) {
					if (data[j].team_num === $scope.teams[i].team_num) {
						$scope.teams[i].matchRecords.push(data[j]);
					}
				}
				$scope.teams[i].computeAveragesAndTotalsAndStuff();
			}
        });
	}
	getMatchRecords();
	
	function getInterviewRecords() {
		$http.post('PHP/get_interviewRecords.php', {eventID: $routeParams.eventID})
		.success(function(data) {
			console.log("SUCCESS - Got interview records for team!", data);
			$scope.interviews = data;
		});
	}
	getInterviewRecords();
	
	$scope.openTeamViewer = function(team) {
		window.location = "#/event/" + $scope.eventID + "/team/" + team.team_num;
	}
	
	var orderBy = $filter('orderBy');
	$scope.reverse = false;
	$scope.order = function(predicate, reverse) {
		$scope.teams = orderBy($scope.teams, predicate, reverse);
		$scope.interviews = orderBy($scope.interviews, predicate, reverse);
	}
}]);