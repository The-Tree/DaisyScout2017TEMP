<?php
ini_set('display_errors', 'On');
include_once('DaisyScout.php');

$data = json_decode(file_get_contents("php://input"));

echo json_encode(DaisyScout::daisybase()->editMatchRecord(
$data->event_id,
$data->scout_name,
$data->team_num, 
$data->match_num,
$data->auton_midline,
$data->auton_scored_high,
$data->auton_shot_high,
$data->auton_scored_low,
$data->auton_shot_low,
$data->auton_gears,
$data->auton_rotors,
$data->driver_skill,
$data->human_skill,
$data->defense_skill
$data->bot_type,
$data->shooter_range,
$data->high_balls_scored, 
$data->high_balls_shot, 
$data->low_balls_scored,
$data->low_balls_shot,
$data->gears,
$data->teleop_rotors,
$data->balls_acquired,
$data->climb,
$data->comments));

?>