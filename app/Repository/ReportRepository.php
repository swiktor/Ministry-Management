<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Report;
use Illuminate\Support\Collection;

interface ReportRepository
{
    public function updateModel(Report $report, array $data): void;

    public function all(): Collection;

    public function get(int $id);

    public function allPaginated(int $month, int $year, int $limit);

    public function edit($data);

    public function add($ministry_id);

    public function compare($data);
}
