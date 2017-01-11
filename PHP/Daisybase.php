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
                                  $team_num,
                                  $match_num,
                                  $scout_name,
                                  $auton_reach,
                                  $auton_cross,
                                  $auton_midline,
                                  $auton_scored_high,
                                  $auton_shot_high,
                                  $auton_scored_low,
                                  $auton_shot_low,
                                  $bot_type,
                                  $defensive_ability,
                                  $portcullis_crossings,
                                  $chevaldefrise_crossings,
                                  $moat_crossings,
                                  $ramparts_crossings,
                                  $drawbridge_crossings,
                                  $sallyport_crossings,
                                  $roughterrain_crossings,
                                  $rockwall_crossings,
                                  $lowbar_crossings,
                                  $shooter_range,
                                  $primary_goal,
                                  $high_boulders_scored,
                                  $high_boulders_shot,
                                  $low_boulders_scored,
                                  $low_boulders_shot,
                                  $balls_acquired,
                                  $challenge,
                                  $scaled,
                                  $comments) {
        $add = $this->db->prepare(
            "INSERT INTO " . self::MATCHRECORDS . "(event_id, team_num, match_num, scout_name, auton_reach, auton_cross, auton_midline, auton_scored_high, auton_shot_high, auton_scored_low, auton_shot_low, bot_type, defensive_ability, portcullis_crossings, chevaldefrise_crossings, moat_crossings, ramparts_crossings, drawbridge_crossings, sallyport_crossings, roughterrain_crossings, rockwall_crossings, lowbar_crossings, shooter_range, primary_goal, high_boulders_scored, high_boulders_shot, low_boulders_scored, low_boulders_shot, balls_acquired, challenge, scaled, comments) values(:event_id, :team_num, :match_num, :scout_name, :auton_reach, :auton_cross, :auton_midline, :auton_scored_high, :auton_shot_high, :auton_scored_low, :auton_shot_low, :bot_type, :defensive_ability, :portcullis_crossings, :chevaldefrise_crossings, :moat_crossings, :ramparts_crossings, :drawbridge_crossings, :sallyport_crossings, :roughterrain_crossings, :rockwall_crossings, :lowbar_crossings, :shooter_range, :primary_goal, :high_boulders_scored, :high_boulders_shot, :low_boulders_scored, :low_boulders_shot, :balls_acquired, :challenge, :scaled, :comments)");
            
        $add->bindValue(':event_id', $event_id, SQLITE3_INTEGER);  
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);  
        $add->bindValue(':match_num', $match_num, SQLITE3_INTEGER);
        $add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
        
        $add->bindValue(':auton_reach', $auton_reach, SQLITE3_TEXT);
        $add->bindValue(':auton_cross', $auton_cross, SQLITE3_TEXT);
        $add->bindValue(':auton_midline', $auton_midline, SQLITE3_TEXT);
        $add->bindValue(':auton_scored_high', $auton_scored_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_high', $auton_shot_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_scored_low', $auton_scored_low, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_low', $auton_shot_low, SQLITE3_INTEGER);
        
        $add->bindValue(':bot_type', $bot_type, SQLITE3_TEXT);
        $add->bindValue(':defensive_ability', $defensive_ability, SQLITE3_INTEGER);
        
        $add->bindValue(':portcullis_crossings', $portcullis_crossings, SQLITE3_INTEGER);
        $add->bindValue(':chevaldefrise_crossings', $chevaldefrise_crossings, SQLITE3_INTEGER);
        $add->bindValue(':moat_crossings', $moat_crossings, SQLITE3_INTEGER);
        $add->bindValue(':ramparts_crossings', $ramparts_crossings, SQLITE3_INTEGER);
        $add->bindValue(':drawbridge_crossings', $drawbridge_crossings, SQLITE3_INTEGER);
        $add->bindValue(':sallyport_crossings', $sallyport_crossings, SQLITE3_INTEGER);
        $add->bindValue(':roughterrain_crossings', $roughterrain_crossings, SQLITE3_INTEGER);
        $add->bindValue(':rockwall_crossings', $rockwall_crossings, SQLITE3_INTEGER);
        $add->bindValue(':lowbar_crossings', $lowbar_crossings, SQLITE3_INTEGER);
        
        $add->bindValue(':shooter_range', $shooter_range, SQLITE3_TEXT);
        $add->bindValue(':primary_goal', $primary_goal, SQLITE3_TEXT);

        $add->bindValue(':high_boulders_scored', $high_boulders_scored, SQLITE3_INTEGER);
        $add->bindValue(':high_boulders_shot', $high_boulders_shot, SQLITE3_INTEGER);
        $add->bindValue(':low_boulders_scored', $low_boulders_scored, SQLITE3_INTEGER);
        $add->bindValue(':low_boulders_shot', $low_boulders_shot, SQLITE3_INTEGER);
        
        $add->bindValue(':balls_acquired', $balls_acquired, SQLITE3_TEXT);
        
        $add->bindValue(':challenge', $challenge, SQLITE3_TEXT);
        $add->bindValue(':scaled', $scaled, SQLITE3_TEXT);

        $add->bindValue(':comments', $comments, SQLITE3_TEXT);
		
        $add->execute();
        $add->close();
        
        return $this->db->changes() > 0;
	}
	
	public function editMatchRecord($match_id,
	                              $event_id,
                                  $team_num,
                                  $match_num,
                                  $scout_name,
                                  $auton_reach,
                                  $auton_cross,
                                  $auton_midline,
                                  $auton_scored_high,
                                  $auton_shot_high,
                                  $auton_scored_low,
                                  $auton_shot_low,
                                  $bot_type,
                                  $defensive_ability,
                                  $portcullis_crossings,
                                  $chevaldefrise_crossings,
                                  $moat_crossings,
                                  $ramparts_crossings,
                                  $drawbridge_crossings,
                                  $sallyport_crossings,
                                  $roughterrain_crossings,
                                  $rockwall_crossings,
                                  $lowbar_crossings,
                                  $shooter_range,
                                  $primary_goal,
                                  $high_boulders_scored,
                                  $high_boulders_shot,
                                  $low_boulders_scored,
                                  $low_boulders_shot,
                                  $balls_acquired,
                                  $challenge,
                                  $scaled,
                                  $comments) {
        $add = $this->db->prepare(
            "UPDATE " . self::MATCHRECORDS . " SET event_id=:event_id, team_num=:team_num, match_num=:match_num, scout_name=:scout_name, auton_reach=:auton_reach, auton_cross=:auton_cross, auton_midline=:auton_midline, auton_scored_high=:auton_scored_high, auton_shot_high=:auton_shot_high, auton_scored_low=:auton_scored_low, auton_shot_low=:auton_shot_low, bot_type=:bot_type, defensive_ability=:defensive_ability, portcullis_crossings=:portcullis_crossings, chevaldefrise_crossings=:chevaldefrise_crossings, moat_crossings=:moat_crossings, ramparts_crossings=:ramparts_crossings, drawbridge_crossings=:drawbridge_crossings, sallyport_crossings=:sallyport_crossings, roughterrain_crossings=:roughterrain_crossings, rockwall_crossings=:rockwall_crossings, lowbar_crossings=:lowbar_crossings, shooter_range=:shooter_range, primary_goal=:primary_goal, high_boulders_scored=:high_boulders_scored, high_boulders_shot=:high_boulders_shot, low_boulders_scored=:low_boulders_scored, low_boulders_shot=:low_boulders_shot, balls_acquired=:balls_acquired, challenge=:challenge, scaled=:scaled, comments=:comments WHERE match_id=:match_id");
            
        $add->bindValue(':event_id', $event_id, SQLITE3_INTEGER);  
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);  
        $add->bindValue(':match_num', $match_num, SQLITE3_INTEGER);
        $add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
        
        $add->bindValue(':auton_reach', $auton_reach, SQLITE3_TEXT);
        $add->bindValue(':auton_cross', $auton_cross, SQLITE3_TEXT);
        $add->bindValue(':auton_midline', $auton_midline, SQLITE3_TEXT);
        $add->bindValue(':auton_scored_high', $auton_scored_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_high', $auton_shot_high, SQLITE3_INTEGER);
        $add->bindValue(':auton_scored_low', $auton_scored_low, SQLITE3_INTEGER);
        $add->bindValue(':auton_shot_low', $auton_shot_low, SQLITE3_INTEGER);
        
        $add->bindValue(':bot_type', $bot_type, SQLITE3_TEXT);
        $add->bindValue(':defensive_ability', $defensive_ability, SQLITE3_INTEGER);
        
        $add->bindValue(':portcullis_crossings', $portcullis_crossings, SQLITE3_INTEGER);
        $add->bindValue(':chevaldefrise_crossings', $chevaldefrise_crossings, SQLITE3_INTEGER);
        $add->bindValue(':moat_crossings', $moat_crossings, SQLITE3_INTEGER);
        $add->bindValue(':ramparts_crossings', $ramparts_crossings, SQLITE3_INTEGER);
        $add->bindValue(':drawbridge_crossings', $drawbridge_crossings, SQLITE3_INTEGER);
        $add->bindValue(':sallyport_crossings', $sallyport_crossings, SQLITE3_INTEGER);
        $add->bindValue(':roughterrain_crossings', $roughterrain_crossings, SQLITE3_INTEGER);
        $add->bindValue(':rockwall_crossings', $rockwall_crossings, SQLITE3_INTEGER);
        $add->bindValue(':lowbar_crossings', $lowbar_crossings, SQLITE3_INTEGER);
        
        $add->bindValue(':shooter_range', $shooter_range, SQLITE3_TEXT);
        $add->bindValue(':primary_goal', $primary_goal, SQLITE3_TEXT);

        $add->bindValue(':high_boulders_scored', $high_boulders_scored, SQLITE3_INTEGER);
        $add->bindValue(':high_boulders_shot', $high_boulders_shot, SQLITE3_INTEGER);
        $add->bindValue(':low_boulders_scored', $low_boulders_scored, SQLITE3_INTEGER);
        $add->bindValue(':low_boulders_shot', $low_boulders_shot, SQLITE3_INTEGER);
        
        $add->bindValue(':balls_acquired', $balls_acquired, SQLITE3_TEXT);
        
        $add->bindValue(':challenge', $challenge, SQLITE3_TEXT);
        $add->bindValue(':scaled', $scaled, SQLITE3_TEXT);

        $add->bindValue(':comments', $comments, SQLITE3_TEXT);
        
        $add->bindValue(':match_id', $match_id, SQLITE3_INTEGER);
		
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
	public function addInterviewRecord($eventID, $team_num, $scout_name, $base_width, $base_length, $drive_motors, $wheel_num, $drive_system, $wheel_type, $speed, $shooter_type, $primary_area, $primary_goal, $portcullis, $chevel, $moat, $ramparts, $drawbridge, $sally, $rough, $rockwall, $low_bar, $challenge_ability, $scale_ability) {
        $add = $this->db->prepare("INSERT INTO " . self::INTERVIEWRECORDS . "(event_id, team_num, scout_name, base_width, base_length, drive_motors, wheel_num, drive_system, wheel_type, speed, shooter_type, primary_area, primary_goal, portcullis, chevel, moat, ramparts, drawbridge, sally, rough, rockwall, low_bar, challenge_ability, scale_ability) values(:eventID, :team_num, :scout_name, :base_width, :base_length, :drive_motors, :wheel_num, :drive_system, :wheel_type, :speed, :shooter_type, :primary_area, :primary_goal, :portcullis, :chevel, :moat, :ramparts, :drawbridge, :sally, :rough, :rockwall, :low_bar, :challenge_ability, :scale_ability)");
            
        $add->bindValue(':eventID', $eventID, SQLITE3_INTEGER);
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);
        $add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
		
        $add->bindValue(':base_width', $base_width, SQLITE3_INTEGER);
        $add->bindValue(':base_length', $base_length, SQLITE3_INTEGER);
        $add->bindValue(':drive_motors', $drive_motors, SQLITE3_TEXT);
        $add->bindValue(':wheel_num', $wheel_num, SQLITE3_INTEGER);
        $add->bindValue(':drive_system', $drive_system, SQLITE3_TEXT);
        $add->bindValue(':wheel_type', $wheel_type, SQLITE3_TEXT);        
    
        $add->bindValue(':speed', $speed, SQLITE3_INTEGER);
		
        $add->bindValue(':shooter_type', $shooter_type, SQLITE3_TEXT);
        $add->bindValue(':primary_area', $primary_area, SQLITE3_TEXT);
        $add->bindValue(':primary_goal', $primary_goal, SQLITE3_TEXT);
        $add->bindValue(':portcullis', $portcullis, SQLITE3_TEXT);
        $add->bindValue(':chevel', $chevel, SQLITE3_TEXT);
        $add->bindValue(':moat', $moat, SQLITE3_TEXT);
        $add->bindValue(':ramparts', $ramparts, SQLITE3_TEXT);
        $add->bindValue(':drawbridge', $drawbridge, SQLITE3_TEXT);
        $add->bindValue(':sally', $sally, SQLITE3_TEXT);
        $add->bindValue(':rough', $rough, SQLITE3_TEXT);
        $add->bindValue(':rockwall', $rockwall, SQLITE3_TEXT);
        $add->bindValue(':low_bar', $low_bar, SQLITE3_TEXT);
        $add->bindValue(':challenge_ability', $challenge_ability, SQLITE3_TEXT);
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
	
	public function editInterviewRecord($interview_id, $event_id, $team_num, $scout_name, $base_width, $base_length, $drive_motors, $wheel_num, $drive_system, $wheel_type, $speed, $shooter_type, $primary_area, $primary_goal, $portcullis, $chevel, $moat, $ramparts, $drawbridge, $sally, $rough, $rockwall, $low_bar, $challenge_ability, $scale_ability) {
        $add = $this->db->prepare(
            "UPDATE " . self::INTERVIEWRECORDS . " SET event_id=:event_id, team_num=:team_num, scout_name=:scout_name, base_width=:base_width, base_length=:base_length, drive_motors=:drive_motors, wheel_num=:wheel_num, drive_system=:drive_system, wheel_type=:wheel_type, speed=:speed, shooter_type=:shooter_type, primary_area=:primary_area, primary_goal=:primary_goal, portcullis=:portcullis, chevel=:chevel, moat=:moat, ramparts=:ramparts, drawbridge=:drawbridge, sally=:sally, rough=:rough, rockwall=:rockwall, low_bar=:low_bar, challenge_ability=:challenge_ability, scale_ability=:scale_ability WHERE interview_id=:interview_id");
            
        $add->bindValue(':interview_id', $interview_id, SQLITE3_INTEGER);
        $add->bindValue(':event_id', $event_id, SQLITE3_INTEGER);
        $add->bindValue(':team_num', $team_num, SQLITE3_INTEGER);
        $add->bindValue(':scout_name', $scout_name, SQLITE3_TEXT);
        $add->bindValue(':base_width', $base_width, SQLITE3_INTEGER);
        $add->bindValue(':base_length', $base_length, SQLITE3_INTEGER);
        $add->bindValue(':drive_motors', $drive_motors, SQLITE3_TEXT);
        $add->bindValue(':wheel_num', $wheel_num, SQLITE3_INTEGER);
        $add->bindValue(':drive_system', $drive_system, SQLITE3_TEXT);
        $add->bindValue(':wheel_type', $wheel_type, SQLITE3_TEXT);        
        $add->bindValue(':speed', $speed, SQLITE3_INTEGER);
        $add->bindValue(':shooter_type', $shooter_type, SQLITE3_TEXT);
        $add->bindValue(':primary_area', $primary_area, SQLITE3_TEXT);
        $add->bindValue(':primary_goal', $primary_goal, SQLITE3_TEXT);
        $add->bindValue(':portcullis', $portcullis, SQLITE3_TEXT);
        $add->bindValue(':chevel', $chevel, SQLITE3_TEXT);
        $add->bindValue(':moat', $moat, SQLITE3_TEXT);
        $add->bindValue(':ramparts', $ramparts, SQLITE3_TEXT);
        $add->bindValue(':drawbridge', $drawbridge, SQLITE3_TEXT);
        $add->bindValue(':sally', $sally, SQLITE3_TEXT);
        $add->bindValue(':rough', $rough, SQLITE3_TEXT);
        $add->bindValue(':rockwall', $rockwall, SQLITE3_TEXT);
        $add->bindValue(':low_bar', $low_bar, SQLITE3_TEXT);
        $add->bindValue(':challenge_ability', $challenge_ability, SQLITE3_TEXT);
        $add->bindValue(':scale_ability', $scale_ability, SQLITE3_TEXT);
        $add->execute();
        $add->close();
        
        return $this->db->changes() > 0;
    }
}

?>