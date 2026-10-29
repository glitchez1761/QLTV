<?php
require_once APP_ROOT . '/app/services/ReportService.php';

class AdminController
{
    private ReportService $service;

    public function __construct()
    {
        $this->service = new ReportService();
    }

    public function dashboard()
    {
        $stats = $this->service->getDashboardStats();
        $latestLoans = $this->service->getLatestLoans();
        include APP_ROOT . '/app/views/admin/dashboard.php';
    }

    public function reports()
    {
        $stats = $this->service->getDashboardStats();
        $latestLoans = $this->service->getLatestLoans();
        include APP_ROOT . '/app/views/admin/reports.php';
    }
}
