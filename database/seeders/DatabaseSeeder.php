<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserOauthToken;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create test user
        $user = User::firstOrCreate([
            'email' => 'group5@gmail.com',
        ], [
            'name' => 'G5',
            'password' => bcrypt('password123'),
        ]);

        // Insert Google OAuth token info (access token only, no refresh token in your example)
        UserOauthToken::updateOrCreate([
            'user_id' => $user->id,
            'provider' => 'google',
        ], [
            'access_token' => json_encode([
                'access_token' => 'ya29.a0AW4XtxiEUQM8140PuCvgviib7xmnxTZNPQf5JbNmOFsVYX-fP_TU-Mq-bZK2SvUdxZI-KtHaDUTB2KrifHFSrldtXCWp2fK35g3H9BLT9ifO0pc0rI1owEkX6mBum5iBfe4Ze0XAj1RBRRbsSmlGl__K3FeflMNOFjf3acoXbAaCgYKASkSARISFQHGX2Min29X3BKKlFFoSiKDvzzEzQ0177',
                'expires_in' => 3599,
                'scope' => 'https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/calendar',
                'token_type' => 'Bearer',
                'created' => time(),
            ]),
            'refresh_token' => null,  // No refresh token provided
            'expires_at' => Carbon::now()->addSeconds(3599),
        ]);

        // Insert Slack User Token
        UserOauthToken::updateOrCreate([
            'user_id' => $user->id,
            'provider' => 'slack',
        ], [
            'access_token' => 'xoxb-8912848241072-8926476231680-osNYjwLRII369AkY7GvXJHt8',  // replace with your actual user token if different
            'refresh_token' => null,
            'expires_at' => null,
        ]);

        // Insert OpenAI token (optional, using API key from env for global access)
        UserOauthToken::updateOrCreate([
            'user_id' => $user->id,
            'provider' => 'openai',
        ], [
            'access_token' => env('JATRAIL_API_KEY'),
            'refresh_token' => null,
            'expires_at' => null,
        ]);
    }
}
