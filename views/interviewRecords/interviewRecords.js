angular.module('daisyscoutApp.interviewRecords', ['ngRoute'])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/event/:eventID/addInterview', {
    templateUrl: 'views/interviewRecords/interviewRecords.html',
    controller: 'InterviewRecordsCtrl'
  });
}])

.controller('InterviewRecordsCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
	function updateInterviewRecords() {
        $http.get('PHP/get_interviewRecords.php')
        .success(function(data) {
            console.log("SUCCESS - Got InterviewRecords!", data);
            $scope.InterviewRecords = data;
			console.log("EVENT ID: " + $routeParams.eventID);
			// Clear the input field.
			$scope.InterviewRecordName = '';
        });
    }
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
	
	function addInterviewRecord(team_num, scout_name, base_width, base_length, drive_motors, wheel_num, drive_system, wheel_type, speed, shooter_type, primary_area, primary_goal, portcullis, chevel, moat, ramparts, drawbridge, sally, rough, rockwall, low_bar, challenge_ability, scale_ability) {
			
		if (checkRequiredField("Team #", team_num) ) 
		{	
			$http.post('PHP/add_interviewRecord.php', 
			{
				event_id: $routeParams.eventID,
				team_num: team_num,
				scout_name: defaultValue(scout_name, "REDACTED"),
                base_width: defaultValue(base_width, 0),
				base_length: defaultValue(base_length, 0), 
				drive_motors: defaultValue(drive_motors, "UNKNOWN"),
				wheel_num: defaultValue(wheel_num, 0),
				drive_system: defaultValue(drive_system, "UNKNOWN"),
				wheel_type: defaultValue(wheel_type, "UNKNOWN"),
				speed: defaultValue(speed, 0),
				shooter_type: defaultValue(shooter_type, "UNKNOWN"),
				primary_area: defaultValue(primary_area, "UNKNOWN"),
				primary_goal: defaultValue(primary_goal, "UNKNOWN"),
				portcullis: defaultValue(portcullis, "UNKNOWN"),
				chevel: defaultValue (chevel, "UNKNOWN"),
				moat: defaultValue (moat, "UNKNOWN"),
                ramparts: defaultValue(ramparts, "UNKNOWN"),
                drawbridge: defaultValue(drawbridge, "UNKNOWN"),
				sally: defaultValue(sally, "UNKNOWN"),
				rough: defaultValue (rough, "UNKNOWN"),
				rockwall: defaultValue (rockwall, "UNKNOWN"),
				low_bar: defaultValue(low_bar, "UNKNOWN"),
				challenge_ability: defaultValue(challenge_ability, "UNKNOWN"),
				scale_ability: defaultValue(scale_ability, "UNKNOWN")
				})
					.success(function(data) {
						console.log('InterviewRecord added!', data);
						updateInterviewRecords();
						alert("Success! Added interview record to database");
						location.reload();

						window.location = "/#/event/"+ $routeParams.eventID;
						// TODO: redirect to main page / clear values from fields
						//NOT TODO: Redirect maybe
					});
		}
	}
    
	$scope.addInterviewRecord = addInterviewRecord;
	
	// Load initial data to display
	updateInterviewRecords();	

}]);