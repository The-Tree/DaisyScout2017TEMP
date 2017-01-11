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
			$http.post('PHP/edit_interviewRecord.php', 
			{
				interview_id: $routeParams.interviewID,
				event_id: $routeParams.eventID,
				team_num: $scope.interview.team_num,
				scout_name: defaultValue($scope.interview.scout_name, "REDACTED"),
				base_width: defaultValue($scope.interview.base_width, 0), 
				base_length: defaultValue($scope.interview.base_length, 0),
				drive_motors: defaultValue($scope.interview.drive_motors, "UNKNOWN"),
				wheel_num: defaultValue($scope.interview.wheel_num, 0),
				drive_system: defaultValue($scope.interview.drive_system, "UNKNOWN"),
				wheel_type: defaultValue($scope.interview.wheel_type, "UNKNOWN"),
				speed: defaultValue($scope.interview.speed, 0),
				shooter_type: defaultValue($scope.interview.shooter_type, "UNKNOWN"),
				primary_area: defaultValue($scope.interview.primary_area, "UNKNOWN"),
				primary_goal: defaultValue($scope.interview.primary_goal, "UNKNOWN"),
				portcullis: defaultValue($scope.interview.portcullis, "UNKNOWN"),
				chevel: defaultValue($scope.interview.chevel, "UNKNOWN"),
				moat: defaultValue ($scope.interview.moat, "UNKNOWN"),
				ramparts: defaultValue ($scope.interview.ramparts, "UNKNOWN"),
				drawbridge: defaultValue ($scope.interview.drawbridge, "UNKNOWN"),
				sally: defaultValue ($scope.interview.sally, "UNKNOWN"),
				rough: defaultValue($scope.interview.rough, "UNKNOWN"),
				rockwall: defaultValue($scope.interview.rockwall,"UNKNOWN"),
				low_bar: defaultValue($scope.interview.low_bar, "UNKNOWN"),
				challenge_ability: defaultValue($scope.interview.challenge_ability, "UNKNOWN"),
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
				//this is a second test
            });
		}
	}
    
	$scope.updateInterviewRecord = updateInterviewRecord;	

}]);