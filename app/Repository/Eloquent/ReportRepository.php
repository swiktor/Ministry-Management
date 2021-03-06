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

    public function allPaginated($month, $year, $limit)
    {
        return $this->ministryModel
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->with('reports')
            ->where('user_id', Auth::id())
            ->whereRaw("id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year)")
            ->orderBy('when', 'desc')
            ->paginate($limit);
    }

    public function get(int $id): Report
    {
        return $this->reportModel->find($id);
    }

    public function edit($data)
    {
        $report = $this->reportModel->find($data['report_id']);

        $report->hours = $data['hours'] ?? "00:00";
        $report->placements = $data['placements'] ?? 0;
        $report->videos = $data['videos'] ?? 0;
        $report->returns = $data['returns'] ?? 00;
        $report->studies = $data['studies'] ?? 0;

        if ($report->save()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function add($ministry_id)
    {
        $report = new Report();
        $report->ministry_id = $ministry_id;
        $report->save();

        return $report->id;
    }

    public function compare($data)
    {
        $report_db = Report::find($data['report_id']);
        $report_db->hours = $data['hours'];
        $report_db->placements = $data['placements'];
        $report_db->videos = $data['videos'];
        $report_db->returns = $data['returns'];
        $report_db->studies = $data['studies'];

        return($report_db->isClean());
    }
}
