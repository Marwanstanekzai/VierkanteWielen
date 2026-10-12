<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseUnhappyTest extends TestCase
{
    /**
     * Unhappy Scenario: Database connection failure returns standalone errors.db_error view.
     */
    public function test_database_connection_failure_renders_db_error_view()
    {
        // Force invalid database configuration
        Config::set('database.connections.sqlite.database', 'C:/invalid_path_for_unhappy_test/missing.sqlite');
        DB::purge('sqlite');

        $response = $this->get('/');

        $response->assertStatus(500);
        $response->assertSee('Database Verbindingsfout');
        $response->assertSee('Er is een probleem opgetreden bij het verbinden met de database.');
        $response->assertDontSee('SQLSTATE');
        $response->assertDontSee('missing.sqlite');
    }
}
