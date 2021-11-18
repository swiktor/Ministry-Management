<?php

declare(strict_types=1);

namespace App\Repository;

interface DashboardRepository
{
    public function monthSum($month, $year);
    public function incomingMinistries(int $limit);
    public function coworkersBalance($month, $year, $limit);
}
