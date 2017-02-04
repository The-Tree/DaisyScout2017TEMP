<?php

class Daisybase
{
    private $db;
    const EVENTS = 'Events';
	const MATCHRECORDS = 'MatchRecords';
	const INTERVIEWRECORDS = 'InterviewRecords';
	const TEAMS = 'Teams';
	const EVENTTEAMS = 'EventTeams';

    public function __construct($db) {
        $this->db = $db;
    }
    
	//EVENTS
    public function addEvent($name) {
        $add = $this->db->prepare(
            "INSERT INTO " . self::EVENTS . "(name) values(:name)");
            
        $add->bindValue(':name', $name, SQLITE3_TEXT);
        $add->execute();
        $add->close();
        
        return $this->db->changes() > 0;
    }
    
    public function getEvents() {
    
        $events = array();
        $query = "SELECT * FROM " . self::EVENTS;
        $result = $this->db->query($query);
        
        while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
            array_push($events, $res);
        }
        
        return $events;
    }
	
	public function getEvent($eventID) {
		
		$event = array();
		$query = $this->db->prepare("SELECT * FROM " . self::EVENTS . " WHERE event_id=:id");
        $query->bindValue(':id', $eventID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($event, $res);
		}
		
		return $event[0];
	}
	
	public function getTeam($teamID) {
		
		$team = array();
		$query = $this->db->prepare("SELECT * FROM " . self::TEAMS . " WHERE team_num=:teamID");
        $query->bindValue(':teamID', $teamID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($team, $res);
		}
		
		return $team[0];
	}
	
	public function getEventTeamList($eventID) {
		
		$teams = array();
		$query = $this->db->prepare("SELECT * from " . self::EVENTTEAMS . " JOIN " . self::TEAMS . " on " . self::EVENTTEAMS . ".team_num = " . SELF::TEAMS . ".team_num WHERE event_id=:id");
        $query->bindValue(':id', $eventID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($teams, $res);
		}
		
		return $teams;
	}
	
	public function getEventTeamRecords($eventID, $teamID) {
		$records = array();
		$query = $this->db->prepare("SELECT * from " . self::MATCHRECORDS . " WHERE event_id=:eventID and team_num=:teamID");
        $query->bindValue(':eventID', $eventID, SQLITE3_INTEGER);
		$query->bindValue(':teamID', $teamID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($records, $res);
		}
		
		return $records;
	}
	
	//MATCH RECORDS
	public function addMatchRecord($event_id,
								  $scout_name,
                                  $team_num,
								  $match_num,
                                  $auton_midline,
                                  $auton_scored_high,
                                  $auton_shot_high,
                                  $auton_scored_low,
                                  $auton_shot_low,
								  $auton_gears,
								  $auton_rotors,
								  $driver_skill,
								  $human_skill,
								  $defense_skill,
                                  $bot_type,
								  $shooter_range,
                                  $high_balls_scored,
                                  $high_balls_shot,
                                  $low_balls_scored,
                                  $low_balls_shot,
								  $gears,
								  $teleop_rotors,
                                  $balls_acquired,
                                  $climb,
                                  $comments) {
        $add = $this->db->prepare(
            "INSERT INTO " . self::MATCHRECORDS . " (event_id, scout_name, team_num, match_num, auton_midline, auton_scored_high, auton_shot_high, auton_scored_low, auton_shot_low, auton_gears, auton_rotors, driver_skill, human_skill, defense_skill, bot_type, shooter_range, high_balls_scored, high_balls_shot, low_balls_scored, low_balls_shot, gears, teleop_rotors, balls_acquired, climb, comments) values(:event_id, :scout_name, :team_num, :match_num, :auton_midline, :auton_scored_high, :auton_shot_high, :auton_scored_low, :auton_shot_low, :auton_gears, :auton_rotors, :driver_skill, :human_skill, :defense_skill, :bot_type, :shooter_range, :high_balls_scored, :high_balls_shot, :low_balls_scored, :low_balls_shot, :gears, :teleop_rotors, :balls_acquired, :climb, :comments)");
            
        $add->bindValue(':event_id', $event_id, SQLITE3_INTEGER);  
		$add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);  
        $add->bindValue(':match_num', $match_num, SQLITE3_INTEGER);
        
        $add->bindValue(':auton_midline', $auton_midline, SQLITE3_TEXT);
        $add->bindValue(':auton_scored_high', $auton_scored_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_high', $auton_shot_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_scored_low', $auton_scored_low, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_low', $auton_shot_low, SQLITE3_INTEGER);
		$add->bindValue(':auton_gears', $auton_gears, SQLITE3_INTEGER);
		$add->bindValue(':auton_rotors', $auton_rotors, SQLITE3_INTEGER);
        
		$add->bindValue(':driver_skill', $driver_skill, SQLITE3_INTEGER);
		$add->bindValue(':human_skill', $human_skill, SQLITE3_INTEGER);
		$add->bindValue(':defense_skill', $defense_skill, SQLITE3_INTEGER);
		
        $add->bindValue(':bot_type', $bot_type, SQLITE3_TEXT);

		$add->bindValue(':shooter_range', $shooter_range, SQLITE3_TEXT);
        $add->bindValue(':high_balls_scored', $high_balls_scored, SQLITE3_INTEGER);
        $add->bindValue(':high_balls_shot', $high_balls_shot, SQLITE3_INTEGER);
        $add->bindValue(':low_balls_scored', $low_balls_scored, SQLITE3_INTEGER);
        $add->bindValue(':low_balls_shot', $low_balls_shot, SQLITE3_INTEGER);
		
		$add->bindValue(':gears', $gears, SQLITE3_INTEGER);
		$add->bindValue(':teleop_rotors', $teleop_rotors, SQLITE3_INTEGER);
        
        $add->bindValue(':balls_acquired', $balls_acquired, SQLITE3_TEXT);
        $add->bindValue(':climb', $climb, SQLITE3_TEXT);

        $add->bindValue(':comments', $comments, SQLITE3_TEXT);
		
        $add->execute();
        $add->close();
        
        return $this->db->changes() > 0;
	}
	
	public function editMatchRecord($event_id,
								  $scout_name,
                                  $team_num,
								  $match_num,
                                  $auton_midline,
                                  $auton_scored_high,
                                  $auton_shot_high,
                                  $auton_scored_low,
                                  $auton_shot_low,
								  $auton_gears,
								  $auton_rotors,
								  $driver_skill,
								  $human_skill,
								  $defense_skill,
                                  $bot_type,
								  $shooter_range,
                                  $high_balls_scored,
                                  $high_balls_shot,
                                  $low_balls_scored,
                                  $low_balls_shot,
								  $gears,
								  $teleop_rotors,
                                  $balls_acquired,
                                  $climb,
                                  $comments) {
        $add = $this->db->prepare(
            "UPDATE " . self::MATCHRECORDS . " SET event_id=:event_id, scout_name=:scout_name, team_num=:team_num, match_num=:match_num, auton_midline=:auton_midline, auton_scored_high=:auton_scored_high, auton_shot_high=:auton_shot_high, auton_scored_low=:auton_scored_low, auton_shot_low=:auton_shot_low, auton_gears=:auton_gears, auton_rotors=:auton_rotors, driver_skill=:driver_skill, human_skill=:human_skill, defense_skill=:defense_skill, bot_type=:bot_type, shooter_range=:shooter_range, high_balls_scored=:high_balls_scored, high_balls_shot=:high_balls_shot, low_balls_scored=:low_balls_scored, low_balls_shot=:low_balls_shot, gears=:gears, teleop_rotors=:teleop_rotors, balls_acquired=:balls_acquired, climb=:climb, comments=:comments WHERE match_id=:match_id");
            
        $add->bindValue(':event_id', $event_id, SQLITE3_INTEGER);  
		$add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);  
        $add->bindValue(':match_num', $match_num, SQLITE3_INTEGER);
        
        $add->bindValue(':auton_midline', $auton_midline, SQLITE3_TEXT);
        $add->bindValue(':auton_scored_high', $auton_scored_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_high', $auton_shot_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_scored_low', $auton_scored_low, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_low', $auton_shot_low, SQLITE3_INTEGER);
		$add->bindValue(':auton_gears', $auton_gears, SQLITE3_INTEGER);
		$add->bindValue(':auton_rotors', $auton_rotors, SQLITE3_INTEGER);
        
		$add->bindValue(':driver_skill', $driver_skill, SQLITE3_INTEGER);
		$add->bindValue(':human_skill', $human_skill, SQLITE3_INTEGER);
		$add->bindValue(':defense_skill', $defense_skill, SQLITE3_INTEGER);
		
        $add->bindValue(':bot_type', $bot_type, SQLITE3_TEXT);

		$add->bindValue(':shooter_range', $shooter_range, SQLITE3_TEXT);
        $add->bindValue(':high_balls_scored', $high_balls_scored, SQLITE3_INTEGER);
        $add->bindValue(':high_balls_shot', $high_balls_shot, SQLITE3_INTEGER);
        $add->bindValue(':low_balls_scored', $low_balls_scored, SQLITE3_INTEGER);
        $add->bindValue(':low_balls_shot', $low_balls_shot, SQLITE3_INTEGER);
		
		$add->bindValue(':gears', $gears, SQLITE3_INTEGER);
		$add->bindValue(':teleop_rotors', $teleop_rotors, SQLITE3_INTEGER);
        
        $add->bindValue(':balls_acquired', $balls_acquired, SQLITE3_TEXT);
        $add->bindValue(':climb', $climb, SQLITE3_TEXT);

        $add->bindValue(':comments', $comments, SQLITE3_TEXT);
		
        $add->execute();
        $add->close();
        
        return $this->db->changes() > 0;
    }
	
	public function getMatchRecords() {
		
		$matchRecords = array();
		$query = "SELECT * FROM " . self::MATCHRECORDS;
		$result = $this->db->query($query);
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($matchRecords, $res);
		}
		
		return $matchRecords;
	}
	
	public function getEventMatchRecords($eventID) {
		$records = array();
		$query = $this->db->prepare("SELECT * from " . self::MATCHRECORDS . " WHERE event_id=:eventID");
        $query->bindValue(':eventID', $eventID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($records, $res);
		}
		
		return $records;
	}
	
	public function getMatchRecord($matchID) {
		$records = array();
		$query = $this->db->prepare("SELECT * from " . self::MATCHRECORDS . " WHERE match_id=:matchID");
        $query->bindValue(':matchID', $matchID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			return $res;
		}
		
		//return $records[0];
	}

	//INTERVIEW RECORDS
	public function addInterviewRecord($event_id, $scout_name, $team_num, $base_width, $base_length, $base_height, $drive_motors, $wheel_num, $drive_system, $wheel_type, $speed, $shooter_type, $capacity, $ball_rof, $primary_goal, $gear_ability, $scale_ability) {
        $add = $this->db->prepare("INSERT INTO " . self::INTERVIEWRECORDS . "(event_id, scout_name, team_num, base_width, base_length, base_height, drive_motors, wheel_num, drive_system, wheel_type, speed, shooter_type, capacity, ball_rof, primary_goal, gear_ability, scale_ability) values(:event_id, :scout_name, :team_num, :base_width, :base_length, :base_height, :drive_motors, :wheel_num, :drive_system, :wheel_type, :speed, :shooter_type, :capacity, :ball_rof, :primary_goal, :gear_ability, :scale_ability)");
            
        $add->bindValue(':event_id', $event_id, SQLITE3_INTEGER);
        $add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);
		
        $add->bindValue(':base_width', $base_width, SQLITE3_INTEGER);
        $add->bindValue(':base_length', $base_length, SQLITE3_INTEGER);
        $add->bindValue(':base_height', $base_height, SQLITE3_INTEGER);
        $add->bindValue(':drive_motors', $drive_motors, SQLITE3_TEXT);
        $add->bindValue(':wheel_num', $wheel_num, SQLITE3_INTEGER);
        $add->bindValue(':drive_system', $drive_system, SQLITE3_TEXT);
        $add->bindValue(':wheel_type', $wheel_type, SQLITE3_TEXT);        
    
        $add->bindValue(':speed', $speed, SQLITE3_INTEGER);
		
        $add->bindValue(':shooter_type', $shooter_type, SQLITE3_TEXT);
        $add->bindValue(':capacity', $capacity, SQLITE3_INTEGER);
		$add->bindValue(':ball_rof', $ball_rof, SQLITE3_INTEGER);
		$add->bindValue(':primary_goal', $primary_goal, SQLITE3_TEXT);
		
		$add->bindValue(':gear_ability', $gear_ability, SQLITE3_TEXT);
        $add->bindValue(':scale_ability', $scale_ability, SQLITE3_TEXT);
        $add->execute();
        $add->close();
        
        return $this->db->changes() > 0;
    }
	
	public function getInterviewRecords($eventID) {
		
		$interviewRecords = array();
		$query = $this->db->prepare("SELECT * from " . self::INTERVIEWRECORDS . " WHERE event_id=:eventID");
        $query->bindValue(':eventID', $eventID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($interviewRecords, $res);
		}
		
		return $interviewRecords;
	}
	
	public function getEventInterviewRecord($eventID, $teamID) {
		$records = array();
		$query = $this->db->prepare("SELECT * from " . self::INTERVIEWRECORDS . " WHERE event_id=:eventID and team_num=:teamID");
        $query->bindValue(':eventID', $eventID, SQLITE3_INTEGER);
		$query->bindValue(':teamID', $teamID, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($records, $res);
		}
		
		return $records[0];
	}
	
	public function getInterviewRecord($interview_id) {
		$records = array();
		$query = $this->db->prepare("SELECT * from " . self::INTERVIEWRECORDS . " WHERE interview_id=:interview_id");
        $query->bindValue(':interview_id', $interview_id, SQLITE3_INTEGER);
		
		$result = $query->execute();
		
		while($res = $result->fetchArray(SQLITE3_ASSOC)) {
			array_push($records, $res);
		}
		
		return $records[0];
	}
	
	public function editInterviewRecord($event_id, $scout_name, $team_num, $base_width, $base_length, $base_height, $drive_motors, $wheel_num, $drive_system, $wheel_type, $speed, $shooter_type, $capacity, $ball_rof, $primary_goal, $gear_ability, $scale_ability) {
        $add = $this->db->prepare(
            "UPDATE " . self::INTERVIEWRECORDS . " SET event_id=:event_id, scout_name=:scout_name, team_num=:team_num, base_width=:base_width, base_length=:base_length, base_height=:base_height, drive_motors=:drive_motors, wheel_num=:wheel_num, drive_system=:drive_system, wheel_type=:wheel_type, speed=:speed, shooter_type=:shooter_type, capacity=:capacity, ball_rof=:ball_rof, primary_goal=:primary_goal, gear_ability=:gear_ability, scale_ability=:scale_ability WHERE interview_id=:interview_id");
            
        $add->bindValue(':event_id', $event_id, SQLITE3_INTEGER);
        $add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);
		
        $add->bindValue(':base_width', $base_width, SQLITE3_INTEGER);
        $add->bindValue(':base_length', $base_length, SQLITE3_INTEGER);
        $add->bindValue(':base_length', $base_height, SQLITE3_INTEGER);
        $add->bindValue(':drive_motors', $drive_motors, SQLITE3_TEXT);
        $add->bindValue(':wheel_num', $wheel_num, SQLITE3_INTEGER);
        $add->bindValue(':drive_system', $drive_system, SQLITE3_TEXT);
        $add->bindValue(':wheel_type', $wheel_type, SQLITE3_TEXT);        
    
        $add->bindValue(':speed', $speed, SQLITE3_INTEGER);
		
        $add->bindValue(':shooter_type', $shooter_type, SQLITE3_TEXT);
        $add->bindValue(':capacity', $capacity, SQLITE3_INTEGER);
		$add->bindValue(':ball_rof', $ball_rof, SQLITE3_INTEGER);
		$add->bindValue(':primary_goal', $primary_goal, SQLITE3_TEXT);
		
		$add->bindValue(':gear_ability', $gear_ability, SQLITE3_TEXT);
        $add->bindValue(':scale_ability', $scale_ability, SQLITE3_TEXT);
        $add->execute();
        $add->close();
        
        return $this->db->changes() > 0;
    }
}

?>