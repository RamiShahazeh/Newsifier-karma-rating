<?php


// Seprated the results into two arrays (the upper_results, the desired user and the lower_results)
// returns also the counts for each array        
function seprate_user_positions_query($results, $user_id){
    $upper_flag = true;
    $upper_results = array();
    $user_row = array();
    $lower_results = array();
    $upper_results_count = 0;
    $lower_results_count = 0;
    foreach($results as $row){
        if($row->id != $user_id && $upper_flag){
            $upper_results_count++;
            array_push($upper_results, $row);
        }
        if($row->id == $user_id){
            array_push($user_row, $row);
            $upper_flag = false;
        }
        if(!$upper_flag){
            if($row->id == $user_id)
                continue;
            $lower_results_count++;
            array_push($lower_results, $row);
        }
    }
    return [$upper_results, $user_row, $lower_results, $upper_results_count, $lower_results_count];
}