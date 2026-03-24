<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Client;
use App\Models\Payment;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DashboardService();
    }

    public function test_it_returns_correct_metrics()
    {
        $metrics = $this->service->getMetrics();

        $this->assertArrayHasKey('total_revenue', $metrics);
        $this->assertArrayHasKey('active_pupils', $metrics);
        $this->assertArrayHasKey('compliance_index', $metrics);
        $this->assertArrayHasKey('system_stream', $metrics);

        $expectedRevenue = Payment::whereMonth('date', now()->month)->sum('amount');
        $this->assertEquals($expectedRevenue, $metrics['total_revenue']);

        $expectedActive = Client::where('status', 'active')->count();
        $this->assertEquals($expectedActive, $metrics['active_pupils']);

        $this->assertCount(min(5, Client::count()), $metrics['system_stream']);
    }
}
