<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Report;
use Illuminate\Support\Collection;

interface ReportRepository
{
    public function updateModel(Report $report, array $data): void;

    public function allActive(): Collection;

    public function get(int $id);

    public function allActivePaginated(int $limit);
}
