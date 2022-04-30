<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Image;


class UserService
{

    static function get_user_position($user_id, $limit=5){

        $upper_result_limit = $limit+1;
        $lower_result_limit = $limit;

        // We Get the top $limit rows + the row of the user_id then the lower $limit rows
        // sorted out by rank
        $query_results = DB::select(DB::raw("WITH temp_user_table AS ( select id, username, karma_score, image_id, ROW_NUMBER() over (ORDER BY karma_score DESC) position from users ORDER BY karma_score DESC) select a.id,username,karma_score,position, url as image_url from ((select * from temp_user_table a WHERE a.position >= (select c.position from temp_user_table c WHERE c.id = $user_id) LIMIT $upper_result_limit) UNION (select * from (SELECT * FROM temp_user_table ORDER BY karma_score DESC) a WHERE a.position < (select c.position from temp_user_table c WHERE c.id = $user_id) ORDER BY karma_score ASC LIMIT $lower_result_limit)) a left join images i on i.id = a.image_id ORDER BY position;"));

        $lower_results = array();
        $upper_results = array();
        $user_row = array();
        $data = array();

        // Seprated the results into two arrays (the upper_results, the desired user and the lower_results)
        [$upper_results, $user_row, $lower_results, $upper_results_count, $lower_results_count] = seprate_user_positions_query($query_results, $user_id);

        // The first Case is if We get all the results with desired limit then we have to cut it down
        // By floor($limit/2) which is the index of half of the lower and upper results so ifwe combine them
        // we get the desired array
        if($upper_results_count == $limit && $lower_results_count == $limit){
            $data = array_merge(
                                array_slice($upper_results, floor($limit/2) +1, $limit),
                                $user_row,
                                array_slice($lower_results, 0, floor($limit/2))
                                );
        // if the upper results is 0 then we add the user row with the lower results
        }elseif ($upper_results_count == 0) {
            $data = array_merge(
                                $user_row, 
                                array_slice($lower_results, 0, $limit - 1)
                                );
        // if the lower results is 0 then we add the user row with the upper results
        }elseif ($lower_results_count == 0) {
            $data = array_merge(
                                array_slice($upper_results, 1, $limit - 1),
                                $user_row
                                );
        // if the results are in the semi border cases
        }else{
            // if the desired user row lower results are less than the limit
            if($lower_results_count < $limit && $upper_results_count == $limit){
                // if the required results to show are not in the lower results
                // then we have to add equal rows in the upper results
                if(floor($limit/2) > $lower_results_count){
                    $added_values_from_upper_results =floor($limit/2) - $lower_results_count;
                    $data = array_merge(
                                        array_slice($upper_results,  floor($limit/2) +1 - $added_values_from_upper_results, $limit),
                                        $user_row,
                                        array_slice($lower_results, 0, floor($limit/2))
                                        );
                }else{
                    $data = array_merge(
                                        array_slice($upper_results,  floor($limit/2) +1, $limit),
                                        $user_row,
                                        array_slice($lower_results, 0, floor($limit/2))
                                        );
                }
                // if the desired user row upper results are less than the limit
            }elseif($upper_results_count<$limit && $lower_results_count==$limit){
                // if the required results to show are not in the upper results
                // then we have to add equal rows in the lower results
                if(floor($limit/2) >  $upper_results_count){
                    $added_values_from_lower_results =floor($limit/2) - $upper_results_count;
                    $data = array_merge(
                                        array_slice($upper_results,  0, $limit),
                                        $user_row,
                                        array_slice($lower_results, 0, ceil($limit/2)-1 + $added_values_from_lower_results)
                                        );
                }else{
                    $data = array_merge(
                                        array_slice($upper_results,  $upper_results_count - floor($limit/2), $upper_results_count),
                                        $user_row,
                                        array_merge($data, array_slice($lower_results, 0, ceil($limit/2)-1))
                                        );
                }
            }
            // the results are less than upper and lower we add all the results together
            else{
                $data = array_merge(
                                    $upper_results,
                                    $user_row,
                                    $lower_results
                                    );
            } 
        } 
        
        return $data;

    }
    
    
}
