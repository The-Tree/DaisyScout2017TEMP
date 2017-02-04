<?php
ini_set('display_errors', 'On');
include_once('DaisyScout.php');

<<<<<<< HEAD
echo json_encode(DaisyScout::daisybase()->getMatchRecords());
=======
echo json_encode(DaisyScout::daisybase()->getMatchRecords($data->eventID), $data->dataID);
>>>>>>> origin
// TODO: Success/Error reporting
?>