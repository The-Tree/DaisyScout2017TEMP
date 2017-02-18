angular.module('daisyscoutApp.matchRecords', ['ngRoute'])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/event/:eventID/addMatchRecord', {
    templateUrl: 'views/matchRecords/matchRecords.html',
    controller: 'MatchRecordsCtrl'
  });
}])
//Gets data
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
	//Allows return to index to work
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
	//This currently is not used - probably wont be - but keep in just in case
	//Redirects to main event page
	function returnToIndex()
	{
		console.log('Returned to Index');
		window.location = "/#/event/"+ $routeParams.eventID;
		location.reload();
	}
	//MAKE SURE THE VALUES HERE AND IN DAISYBASE MATCH	
	function addMatchRecord(
		scout_name,
        team_num,
        match_num,
        auton_midline,
        auton_scored_high,
        auton_shot_high,
        auton_scored_low,
        auton_shot_low,
		auton_gears,
		auton_rotors,
		driver_skill,
		human_skill,
		defense_skill,
        bot_type,
		shooter_range,
        high_balls_scored,
        high_balls_shot,
        low_balls_scored,
        low_balls_shot,
		gears,
		teleop_rotors,
        balls_acquired,
        climb,
        comments) {
		//Makes sure team number and match number are valid
		console.log("Team Number: ", team_num);
		if (!validateTeamNumber(team_num)) {
			alert("Team number is not valid");
		}
		else if (checkRequiredField("Team number", team_num) && checkRequiredField("Match number", match_num)) {
			$http.post('PHP/add_matchRecord.php', {
                event_id: $routeParams.eventID,
				scout_name: defaultValue(scout_name, 'REDACTED'),
                team_num: team_num, 
                match_num: match_num,
                auton_midline: defaultValue(auton_midline, 'no'),
                auton_scored_high: defaultValue(auton_scored_high, 0),
                auton_shot_high: defaultValue(auton_shot_high, 0),
                auton_scored_low: defaultValue(auton_scored_low, 0),
                auton_shot_low: defaultValue(auton_shot_low, 0),
				auton_gears: defaultValue(auton_gears, 0),
				auton_rotors: defaultValue(auton_rotors, 0),
				driver_skill: defaultValue(driver_skill, 3),//3 because three is mid point of 1 and 5
				human_skill: defaultValue(human_skill, 3),
				defense_skill: defaultValue(defense_skill, 3),
                bot_type: defaultValue(bot_type, 'UNKNOWN'),
				shooter_range: defaultValue(shooter_range, 'UNKNOWN'),
                high_balls_scored: defaultValue(high_balls_scored, 0), 
                high_balls_shot: defaultValue(high_balls_shot, 0),
                low_balls_scored: defaultValue(low_balls_scored, 0), 
                low_balls_shot: defaultValue(low_balls_shot, 0), 
				gears: defaultValue(gears, 0),
				teleop_rotors: defaultValue(teleop_rotors, 0),
                balls_acquired: defaultValue(balls_acquired, 'UNKNOWN'),
                climb: defaultValue(climb, 'no'),
                comments: defaultValue(comments, '')
			})
            .success(function(data) {
                console.log('MatchRecord added!', data);
				updateMatchRecords();
				alert("Success! Match record added.");
				location.reload();
				
            });
		}
	}
    
	$scope.addMatchRecord = addMatchRecord;
	
	// Load initial data to display
	updateMatchRecords();
	
}]);