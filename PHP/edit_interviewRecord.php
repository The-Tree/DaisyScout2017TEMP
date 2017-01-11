<?php
ini_set('display_errors', 'On');
include_once('DaisyScout.php');

$data = json_decode(file_get_contents("php://input"));

echo json_encode(DaisyScout::daisybase()->editInterviewRecord(
$data->interview_id,
$data->event_id,
$data->team_num,
$data->scout_name,
$data->base_width,
$data->base_length,
$data->drive_motors,
$data->wheel_num,
$data->drive_system,
$data->wheel_type,
$data->speed,
$data->shooter_type,
$data->primary_area,
$data->primary_goal,
$data->portcullis,
$data->chevel,
$data->moat,
$data->ramparts,
$data->drawbridge,
$data->sally,
$data->rough,
$data->rockwall,
$data->low_bar,
$data->challenge_ability, 
$data->scale_ability));

?>