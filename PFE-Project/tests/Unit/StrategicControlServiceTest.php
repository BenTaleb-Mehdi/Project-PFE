<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Staff;
use App\Models\Payment;
use App\Services\StrategicControlService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StrategicControlServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new StrategicControlService();
    }

    public function test_it_returns_team_manifest_with_client_counts()
    {
        $manifest = $this->service->getTeamManifest();

        $this->assertNotEmpty($manifest);
        $this->assertInstanceOf(Staff::class, $manifest->first());
        $this->assertNotNull($manifest->first()->user);
    }

    public function test_it_returns_transaction_logs_without_filter()
    {
        $logs = $this->service->getTransactionLogs();

        $this->assertNotEmpty($logs);
        $this->assertInstanceOf(Payment::class, $logs->first());
        $this->assertNotNull($logs->first()->client);
    }

    public function test_it_returns_transaction_logs_with_filter()
    {
        $payment = Payment::first();
        $status = $payment->status;

        $logs = $this->service->getTransactionLogs($status);

        $this->assertNotEmpty($logs);
        foreach ($logs as $log) {
            $this->assertEquals($status, $log->status);
        }
    }
}
