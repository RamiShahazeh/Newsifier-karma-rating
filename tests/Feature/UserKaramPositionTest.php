<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\User;

class UserKaramPositionTest extends TestCase
{
    public function test_if_it_returns_right_users_count()
    {
        $limit = 10;
        $response = $this->getJson('http://localhost/api/v1/user/500/karma-position?limit=' .$limit);
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->has('data', $limit)
                ->etc()
        );
    }

    public function test_if_it_returns_error_when_passing_negative_limit()
    {
        $limit = -10;
        $response = $this->getJson('http://localhost/api/v1/user/500/karma-position?limit=' .$limit);

        $response->assertStatus(400);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->has('message')
                ->etc()
        );
    }

    public function test_if_it_returns_the_first_user_at_the_top()
    {
        $limit = 25;
        $first_position_user = User::orderBy('karma_score', 'DESC')->first();
        $response = $this->getJson('http://localhost/api/v1/user/' . $first_position_user->id .'/karma-position?limit=' .$limit);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->has('data', $limit)
                ->where('data.0.id', $first_position_user->id)
                ->where('data.0.position', 1)
                ->etc()
        );
    }

    public function test_if_it_returns_the_last_user_at_the_bottom()
    {
        $limit = 10;
        $last_user_index = $limit-1;
        $last_position_user = User::orderBy('karma_score', 'ASC')->first();
        $response = $this->getJson('http://localhost/api/v1/user/' . $last_position_user->id .'/karma-position?limit=' .$limit);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->has('data', $limit)
                ->where('data.'.$last_user_index.'.id', $last_position_user->id)
                ->etc()
        );
    }

    public function test_if_it_returns_the_right_results_for_three_results()
    {
        $limit = 3;
        $desired_user = User::inRandomOrder()->first();

        $upper_user = null;
        $lower_user = null;
        $karma_score_for_upper_result = $desired_user->karma_score + 1;
        $karma_score_for_lower_result = $desired_user->karma_score - 1;
        
        while($upper_user == null){
            $upper_user = User::where('karma_score', $karma_score_for_upper_result)->first();
            $karma_score_for_upper_result += 1;
        }

        while($lower_user== null){
            $lower_user = User::where('karma_score', $karma_score_for_lower_result)->first();
            $karma_score_for_lower_result -= 1;
        }

        $response = $this->getJson('http://localhost/api/v1/user/' . $desired_user->id .'/karma-position?limit=' .$limit);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->has('data', $limit)
                ->where('data.0.id', $upper_user->id)
                ->where('data.1.id', $desired_user->id)
                ->where('data.2.id', $lower_user->id)
                ->etc()
        );
    }
}
