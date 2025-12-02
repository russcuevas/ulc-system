<?php

namespace Tests\Unit;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_dashboard_status()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
    }
}
