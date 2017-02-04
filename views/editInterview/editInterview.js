angular.module('daisyscoutApp.editInterviewRecord', ['ngRoute'])
.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/event/:eventID/editInterview/:interviewID', {
    templateUrl: 'views/editInterview/editInterview.html',
    controller: 'EditInterviewRecordCtrl'
  });
}])

.controller('EditInterviewRecordCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
	function getInterviewRecord() {
        $http.post('PHP/get_interviewRecord.php', {interviewID: $routeParams.interviewID})
        .success(function(data) {
            console.log("SUCCESS - Got InterviewRecord!", data);
            $scope.interview = data;
        });
    }
	getInterviewRecord();
	
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
	
	function updateInterviewRecord() {
			
		if (checkRequiredField("Team #", $scope.interview.team_num) ) 
		{	
			console.log($scope.interview);
			$http.post('PHP/edit_interviewRecord.php', 
			{
				interview_id: $routeParams.interviewID,
				event_id: $routeParams.eventID,
				scout_name: defaultValue($scope.interview.scout_name, "REDACTED"),
				team_num: $scope.interview.team_num,
				base_width: defaultValue($scope.interview.base_width, 0), 
				base_length: defaultValue($scope.interview.base_length, 0),
				base_height: defaultValue($scope.interview.base_height, 0),
				drive_motors: defaultValue($scope.interview.drive_motors, "UNKNOWN"),
				wheel_num: defaultValue($scope.interview.wheel_num, 0),
				drive_system: defaultValue($scope.interview.drive_system, "UNKNOWN"),
				wheel_type: defaultValue($scope.interview.wheel_type, "UNKNOWN"),
				speed: defaultValue($scope.interview.speed, 0),
				shooter_type: defaultValue($scope.interview.shooter_type, "UNKNOWN"),
				capacity: defaultValue($scope.interview.capacity, 0),
				ball_rof: defaultValue($scope.interview.ball_rof, 0),
				primary_goal: defaultValue($scope.interview.primary_goal, "UNKNOWN"),
				gear_ability: defaultValue($scope.interview.gear_ability, "UNKNOWN"),
				scale_ability: defaultValue($scope.interview.scale_ability, "UNKNOWN"),
            })
            .success(function(data) {
                console.log('InterviewRecord edited!', data);
                getInterviewRecord();
                alert("Success! Updated interview record.");
                window.location = "/#/event/"+ $routeParams.eventID + "/team/" + $scope.interview.team_num;
                // TODO: redirect to main page / clear values from fields
				//NOT TO DO: redirect to main page
				
				//this is a test
            });
		}
	}
    
	$scope.updateInterviewRecord = updateInterviewRecord;	

}]);