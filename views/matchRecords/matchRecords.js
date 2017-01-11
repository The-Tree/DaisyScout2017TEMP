angular.module('daisyscoutApp.matchRecords', ['ngRoute'])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/event/:eventID/addMatchRecord', {
    templateUrl: 'views/matchRecords/matchRecords.html',
    controller: 'MatchRecordsCtrl'
  });
}])

.controller('MatchRecordsCtrl', ['$scope', '$http', '$routeParams', '$filter', function($scope, $http, $routeParams, $filter) {
	
	function updateMatchRecords() {
        $http.get('PHP/get_matchRecords.php')
        .success(function(data) {
            console.log("SUCCESS - Got MatchRecords!", data);
            $scope.MatchRecords = data;
			
			// Clear the input field.
			$scope.MatchRecordName = '';
        });
    }
	
	function getTeams() {
		$http.post('PHP/get_eventTeamList.php', {eventID: $routeParams.eventID})
        .success(function(data) {
            $scope.teams = data;
			$scope.teams = $filter('orderBy')($scope.teams, 'team_num', false);
        });
	}
	getTeams();
	
	function defaultValue(property, value) {
		if (typeof property === 'undefined') {
			return value;
		}
		return property;
	}
	
	function defined(value) {
		return typeof value !== 'undefined';
	}
	
	function checkRequiredField(name, field) {	
		if (!defined(field)) {
			alert(name + " is a required field.");
			return false;
		}
		return true;
	}
	
	function validateTeamNumber(teamNum) {
		for (var i = 0; i < $scope.teams.length; i++) {
			if (parseInt(teamNum) === $scope.teams[i].team_num) {
				return true;
			}
		}
		return false;
	}
	
	function addMatchRecord(
        team_num,
        match_num,
        scout_name,
        auton_reach,
        auton_cross,
        auton_midline,
        auton_scored_high,
        auton_shot_high,
        auton_scored_low,
        auton_shot_low,
        bot_type,
        defensive_ability,
        portcullis_crossings,
        chevaldefrise_crossings,
        moat_crossings,
        ramparts_crossings,
        drawbridge_crossings,
        sallyport_crossings,
        roughterrain_crossings,
        rockwall_crossings,
        lowbar_crossings,
        shooter_range,
        primary_goal,
        high_boulders_scored,
        high_boulders_shot,
        low_boulders_scored,
        low_boulders_shot,
        balls_acquired,
        challenge,
        scaled,
        comments) {

		console.log("Team Number: ", team_num);
		if (!validateTeamNumber(team_num)) {
			alert("Team number is not valid");
		}
		else if (checkRequiredField("Team number", team_num) && checkRequiredField("Match number", match_num)) {
			$http.post('PHP/add_matchRecord.php', {
                event_id: $routeParams.eventID,
                team_num: team_num, 
                match_num: match_num, 
                scout_name: defaultValue(scout_name, 'REDACTED'),
                auton_reach: defaultValue(auton_reach, 'None'),
                auton_cross: defaultValue(auton_cross, 'None'),
                auton_midline: defaultValue(auton_midline, 'no'),
                auton_scored_high: defaultValue(auton_scored_high, 0),
                auton_shot_high: defaultValue(auton_shot_high, 0),
                auton_scored_low: defaultValue(auton_scored_low, 0),
                auton_shot_low: defaultValue(auton_shot_low, 0),
                bot_type: defaultValue(bot_type, 'UNKNOWN'),
                defensive_ability: defaultValue(defensive_ability, 1),
                portcullis_crossings: defaultValue(portcullis_crossings, 0), 
                chevaldefrise_crossings: defaultValue(chevaldefrise_crossings, 0), 
                moat_crossings: defaultValue(moat_crossings, 0), 
                ramparts_crossings: defaultValue(ramparts_crossings, 0),
                drawbridge_crossings: defaultValue(drawbridge_crossings, 0), 
                sallyport_crossings: defaultValue(sallyport_crossings, 0), 
                roughterrain_crossings: defaultValue(roughterrain_crossings, 0), 
                rockwall_crossings: defaultValue(rockwall_crossings, 0), 
                lowbar_crossings: defaultValue(lowbar_crossings, 0),
                shooter_range: defaultValue(shooter_range, 'UNKNOWN'),
                primary_goal: defaultValue(primary_goal, 'UNKNOWN'),
                high_boulders_scored: defaultValue(high_boulders_scored, 0), 
                high_boulders_shot: defaultValue(high_boulders_shot, 0),
                low_boulders_scored: defaultValue(low_boulders_scored, 0), 
                low_boulders_shot: defaultValue(low_boulders_shot, 0), 
                balls_acquired: defaultValue(balls_acquired, 'UNKNOWN'),
                challenge: defaultValue(challenge, 'no'),
                scaled: defaultValue(scaled, 'no'),
                comments: defaultValue(comments, '')
			})
            .success(function(data) {
                console.log('MatchRecord added!', data);
				updateMatchRecords();
				alert("Success! Match record added.");
				location.reload();
				window.location = "/#/event/"+ $routeParams.eventID;
            });
		}
	}
    
	$scope.addMatchRecord = addMatchRecord;
	
	// Load initial data to display
	updateMatchRecords();
	
}]);