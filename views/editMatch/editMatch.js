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
                team_num: $scope.match.team_num, 
                match_num: $scope.match.match_num, 
                scout_name: defaultValue($scope.match.scout_name, 'REDACTED'),
                auton_reach: defaultValue($scope.match.auton_reach, 'None'),
                auton_cross: defaultValue($scope.match.auton_cross, 'None'),
                auton_midline: defaultValue($scope.match.auton_midline, 'no'),
                auton_scored_high: defaultValue($scope.match.auton_scored_high, 0),
                auton_shot_high: defaultValue($scope.match.auton_shot_high, 0),
                auton_scored_low: defaultValue($scope.match.auton_scored_low, 0),
                auton_shot_low: defaultValue($scope.match.auton_shot_low, 0),
                bot_type: defaultValue($scope.match.bot_type, 'UNKNOWN'),
                defensive_ability: defaultValue($scope.match.defensive_ability, 1),
                portcullis_crossings: defaultValue($scope.match.portcullis_crossings, 0), 
                chevaldefrise_crossings: defaultValue($scope.match.chevaldefrise_crossings, 0), 
                moat_crossings: defaultValue($scope.match.moat_crossings, 0), 
                ramparts_crossings: defaultValue($scope.match.ramparts_crossings, 0),
                drawbridge_crossings: defaultValue($scope.match.drawbridge_crossings, 0), 
                sallyport_crossings: defaultValue($scope.match.sallyport_crossings, 0), 
                roughterrain_crossings: defaultValue($scope.match.roughterrain_crossings, 0), 
                rockwall_crossings: defaultValue($scope.match.rockwall_crossings, 0), 
                lowbar_crossings: defaultValue($scope.match.lowbar_crossings, 0),
                shooter_range: defaultValue($scope.match.shooter_range, 'UNKNOWN'),
                primary_goal: defaultValue($scope.match.primary_goal, 'UNKNOWN'),
                high_boulders_scored: defaultValue($scope.match.high_boulders_scored, 0), 
                high_boulders_shot: defaultValue($scope.match.high_boulders_shot, 0),
                low_boulders_scored: defaultValue($scope.match.low_boulders_scored, 0), 
                low_boulders_shot: defaultValue($scope.match.low_boulders_shot, 0), 
                balls_acquired: defaultValue($scope.match.balls_acquired, 'UNKNOWN'),
                challenge: defaultValue($scope.match.challenge, 'no'),
                scaled: defaultValue($scope.match.scaled, 'no'),
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