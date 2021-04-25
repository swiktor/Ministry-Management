<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Report;
use App\Model\Ministry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Repository\ReportRepository as ReportRepositoryInterface;
class ReportRepository implements ReportRepositoryInterface
{
    private Report $reportModel;
    private Ministry $ministryModel;

    public function __construct(Report $reportModel, Ministry $ministryModel)
    {
        $this->reportModel = $reportModel;
        $this->ministryModel = $ministryModel;
    }

    public function updateModel(Report $report, array $data): void
    {
        $report->ministry_id = $data['ministry_id'] ?? $report->ministry_id;
        $report->hours = $data['hours'] ?? $report->hours;
        $report->placements = $data['placements'] ?? $report->placements;
        $report->videos = $data['videos'] ?? $report->videos;
        $report->returns = $data['returns'] ?? $report->returns;
        $report->studies = $data['studies'] ?? $report->studies;

        $report->save();
    }

    public function all(): Collection
    {
        return $this->ministryModel
            ->with('types')
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->with('reports')
            ->where('user_id', Auth::id())
            ->orderBy('when', 'desc')
            ->get();
    }

    public function allPaginated(int $limit = 10)
    {
          return $this->ministryModel
            ->with('types')
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->with('reports')
            ->where('user_id', Auth::id())
            ->orderBy('when', 'desc')
            ->paginate($limit);
    }

    public function get(int $id): Report
    {
        return $this->reportModel->find($id);
    }
}
