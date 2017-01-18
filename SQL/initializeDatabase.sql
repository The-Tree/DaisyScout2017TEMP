CREATE TABLE Events(
    event_id INTEGER PRIMARY KEY ASC,
    name TEXT UNIQUE NOT NULL,
	event_code TEXT UNIQUE NOT NULL
);
----------------------------------------------------------------------------------------------------------------------
INSERT INTO Events (event_id, name, event_code) VALUES (0, "Hatboro-Horsham", "PAHAT");
INSERT INTO Events (event_id, name, event_code) VALUES (1, "Westtown", "PAWCH");
INSERT INTO Events (event_id, name, event_code) VALUES (2, "MAR Championship", "MRCMP");

CREATE TABLE Teams(
    team_num INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
	locality TEXT,
	region TEXT,
	country TEXT
);

INSERT INTO Teams (team_num, name, locality, region, country) VALUES (25, "Raider Robotix", "North Brunswick", "NJ", "USA");
INSERT INTO Teams (team_num, name, locality, region, country) VALUES (341, "Miss Daisy", "Ambler", "PA", "USA");

CREATE TABLE EventTeams(
	event_id INTEGER,
	team_num INTEGER,
	
	FOREIGN KEY(event_id) REFERENCES Events(event_id),
	FOREIGN KEY(team_num) REFERENCES Teams(team_num)
);

INSERT INTO EventTeams (event_id, team_num) VALUES (0, 25);
INSERT INTO EventTeams (event_id, team_num) VALUES (0, 341);
INSERT INTO EventTeams (event_id, team_num) VALUES (1, 341);
INSERT INTO EventTeams (event_id, team_num) VALUES (2, 341);

CREATE TABLE InterviewRecords(
 
	--basic team info
	interview_id INTEGER PRIMARY KEY ASC,
	event_id INTEGER,
	scout_name TEXT,
	team_num INTEGER,

	--robot specs
	base_width INTEGER,
	base_length INTEGER,
	base_height INTEGER,
	drive_motors TEXT,
	wheel_num INTEGER,
    drive_system TEXT,
    wheel_type TEXT,
	speed INTEGER,

	shooter_type TEXT,
	capacity INT,
	ball_rof INT,
	primary_goal TEXT,

	gear_ability TEXT, 
	scale_ability TEXT,

	FOREIGN KEY(event_id) REFERENCES Events(event_id),
	FOREIGN KEY(team_num) REFERENCES Teams(team_num)
);

CREATE TABLE MatchRecords(

    --basic match/robot info
	match_id INTEGER PRIMARY KEY ASC,
	event_id INTEGER,
	scout_name TEXT,
	team_num INTEGER,
	match_num INTEGER,
	
	--autonomous mode
	auton_midline TEXT,
	auton_scored_high INTEGER,
	auton_shot_high INTEGER,
	auton_scored_low INTEGER,
	auton_shot_low INTEGER,
	auton_gears INTEGER,
	auton_rotors INTEGER,

    -- Teleoperated mode
    bot_type TEXT,
	shooter_range TEXT,
	high_balls_scored INTEGER,
	high_balls_shot INTEGER,
    low_balls_scored INTEGER,
    low_balls_shot INTEGER,
	gears INTEGER,
	teleop_rotors INTEGER,

	balls_acquired TEXT,
    climb TEXT,
	comments TEXT,
	
	FOREIGN KEY(event_id) REFERENCES Events(event_id),
	FOREIGN KEY(team_num) REFERENCES Teams(team_num)
);