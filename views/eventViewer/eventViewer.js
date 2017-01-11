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
		this.totalDefCrossed = 0;
		this.avgDefCrossed = 0;
		//this.totalAutonScored = 0;
		//this.avgAutonScored = 0;
		this.totalAutonCrossed = 0;
		this.totalDefACrossed = 0;
		this.totalDefBCrossed = 0;
		this.totalDefCCrossed = 0;
		this.totalDefDCrossed = 0;
		
		this.totalPortcullisCrossed = 0;
		this.totalChevalDeFriseCrossed = 0;
		this.totalMoatCrossed = 0;
		this.totalRampartsCrossed = 0;
		this.totalDrawbridgeCrossed = 0;
		this.totalSallyPortCrossed = 0;
		this.totalRockwallCrossed = 0;
		this.totalRoughTerrainCrossed = 0;
		this.totalLowBarCrossed = 0;
		
	}
	
	Team.prototype.computeAveragesAndTotalsAndStuff = function() {
	
		// Compute total and average number of totes and containers scored.
		if (this.matchRecords.length > 0) {
			for (var i = 0; i < this.matchRecords.length; i++) 
			{
				
				//shooting calculations
				this.totalHighScored += this.matchRecords[i].high_boulders_scored;
				this.totalLowScored += this.matchRecords[i].low_boulders_scored;
				
				//this.totalAutonScored += this.matchRecords[i].auton_scored_high + this.matchRecords[i].auton_scored_low;
				
				//defense calculations
				this.totalDefACrossed += this.matchRecords[i].portcullis_crossings + this.matchRecords[i].chevaldefrise_crossings;
				this.totalDefBCrossed += this.matchRecords[i].moat_crossings + this.matchRecords[i].ramparts_crossings;
				this.totalDefCCrossed += this.matchRecords[i].drawbridge_crossings + this.matchRecords[i].sallyport_crossings;
				this.totalDefDCrossed += this.matchRecords[i].rockwall_crossings + this.matchRecords[i].roughterrain_crossings;
				
				this.totalPortcullisCrossed += this.matchRecords[i].portcullis_crossings;
				this.totalChevalDeFriseCrossed += this.matchRecords[i].chevaldefrise_crossings;
				this.totalMoatCrossed += this.matchRecords[i].moat_crossings;
				this.totalRampartsCrossed += this.matchRecords[i].ramparts_crossings;
				this.totalDrawbridgeCrossed += this.matchRecords[i].drawbridge_crossings;
				this.totalSallyPortCrossed += this.matchRecords[i].sallyport_crossings;
				this.totalRockwallCrossed += this.matchRecords[i].rockwall_crossings;
				this.totalRoughTerrainCrossed += this.matchRecords[i].roughterrain_crossings;
				this.totalLowBarCrossed += this.matchRecords[i].lowbar_crossings;
				
				if(this.matchRecords[i].auton_cross != "None") //accounts for all of the auton crossings
				{
					this.totalAutonCrossed++;
				}
				
			}
			
			this.totalDefCrossed += this.totalDefACrossed + this.totalDefBCrossed + this.totalDefCCrossed + this.totalDefDCrossed;
			this.avgHighScored = +((this.totalHighScored / this.matchRecords.length).toFixed(2));
			this.avgLowScored = +((this.totalLowScored / this.matchRecords.length).toFixed(2));
			this.avgDefCrossed = +((this.totalDefCrossed / this.matchRecords.length).toFixed(2));
			//this.avgAutonScored = this.totalAutonScored / this.matchRecords.length;
		}
		
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