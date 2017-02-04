angular.module('daisyscoutApp.editMatchRecord', ['ngRoute'])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/event/:eventID/editMatch/:matchID', {
    templateUrl: 'views/editMatch/editMatch.html',
    controller: 'EditMatchRecordCtrl'
  });
}])

.controller('EditMatchRecordCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
	function getMatchRecord() {
        $http.post('PHP/get_matchRecord.php', {matchID: $routeParams.matchID})
        .success(function(data) {
            console.log("SUCCESS - Got MatchRecord!", data);
            $scope.match = data;
        });
    }
	getMatchRecord();
	
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
	
	function updateMatchRecord() {
			
		if (checkRequiredField("Team number", $scope.match.team_num) && checkRequiredField("Match number", $scope.match.match_num)) 
		{	                                                                                                                                                                                                                                                    
			console.log($scope.match);
			$http.post('PHP/edit_matchRecord.php', 
			{
                match_id: $routeParams.matchID,
				event_id: $routeParams.eventID,
				scout_name: defaultValue($scope.match.scout_name, 'REDACTED'),
                team_num: $scope.match.team_num, 
                match_num: $scope.match.match_num, 
                auton_midline: defaultValue($scope.match.auton_midline, 'no'),
                auton_scored_high: defaultValue($scope.match.auton_scored_high, 0),
                auton_shot_high: defaultValue($scope.match.auton_shot_high, 0),
                auton_scored_low: defaultValue($scope.match.auton_scored_low, 0),
                auton_shot_low: defaultValue($scope.match.auton_shot_low, 0),
				auton_gears: defaultValue($scope.match.auton_gears, 0),
				auton_rotors: defaultValue($scope.match.auton_rotors, 0),
                driver_skill: defaultValue($scope.match.driver_skill, 3),
				human_skill: defaultValue($scope.match.human_skill, 3),
				defense_skill: defaultValue($scope.match.defense_skill, 3),
				bot_type: defaultValue($scope.match.bot_type, 0),
				shooter_range: defaultValue($scope.match.shooter_range, 0),
				high_balls_scored: defaultValue($scope.match.high_balls_scored, 0),
				high_balls_shot: defaultValue($scope.match.high_balls_shot, 0),
				low_balls_scored: defaultValue($scope.match.low_balls_scored, 0),
				low_balls_shot: defaultValue($scope.match.low_balls_shot, 0),
				gears: defaultValue($scope.match.gears, 0),
				teleop_rotors: defaultValue($scope.match.teleop_rotors, 0),
				balls_acquired: defaultValue($scope.match.balls_acquired, 0),
				climb: defaultValue($scope.match.climb, 'no'),
                comments: defaultValue($scope.match.comments, '')
            })
            .success(function(data) {
                console.log('MatchRecord edited!', data);
                //getMatchRecord();
                alert("Success! Updated match record.");
                window.location = "/#/event/"+ $routeParams.eventID + "/team/" + $scope.match.team_num;
                // TODO: redirect to main page / clear values from fields
            });
		}
	}
    
	$scope.updateMatchRecord = updateMatchRecord;	

}]);