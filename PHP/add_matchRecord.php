<?php
ini_set('display_errors', 'On');
include_once('DaisyScout.php');

$data = json_decode(file_get_contents("php://input"));

echo json_encode(DaisyScout::daisybase()->addMatchRecord(
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
$data->bot_type,
$data->primary_goal,
$data->high_boulders_scored, 
$data->high_boulders_shot, 
$data->low_boulders_scored,
$data->low_boulders_shot,
$data->balls_acquired,
$data->climb,
$data->comments));

?>