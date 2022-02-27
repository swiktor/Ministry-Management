<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMinistry;
use App\Http\Requests\EditMinistry;
use App\Model\Ministry;
use App\Model\Report;
use App\Repository\CoworkerRepository;
use App\Repository\MinistryRepository;
use App\Repository\ReportRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MinistryController extends Controller
{
    private MinistryRepository $ministryRepository;
    private CoworkerRepository $coworkerRepository;
    private ReportRepository $reportRepository;

    public function __construct(MinistryRepository $ministryRepository, CoworkerRepository $coworkerRepository, ReportRepository $reportRepository)
    {
        $this->ministryRepository = $ministryRepository;
        $this->coworkerRepository = $coworkerRepository;
        $this->reportRepository = $reportRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if (!empty($request->get('when'))) {
            $when = $request->get('when');
            $monthYear = explode('-', $when);
            $year = $monthYear[0];
            $month = $monthYear[1];
        } else {
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $when = $year . '-' . $month;
        }

        $ministries = $this->ministryRepository->allPaginated($month, $year, 10);

        return view('ministry.index', [
            'ministries' => $ministries,
            'when' => $when,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $coworkers = $this->coworkerRepository->allActive();

        return view('ministry.create', [
            'coworkers' => $coworkers,
            'title' => 'Umów',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddMinistry $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['status'] = 'accepted';

        $ministry_id = $this->ministryRepository->add($data);

        $this->coworkerRepository->addToMinistry($data['coworker'], $ministry_id);

        $this->reportRepository->add($ministry_id);

        // $this->ministryRepository->setInGoogleCalendar($ministry_id, Auth::user());

        $this->ministryRepository->ministryProposalForUser($data['coworker'], $ministry_id, $this->coworkerRepository, $this->reportRepository);

        return redirect()
            ->route('ministry.index')
            ->with('success', 'Pomyślnie dodano nową służbę');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    //    public function show(Ministry $ministry)
    //    {
    //        //
    //    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ministry  $ministry
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Ministry $ministry)
    {
        $ministry_db = $this->ministryRepository->get($ministry->id)->first();
        $coworkers = $this->coworkerRepository->allActive();
        $report = $this->reportRepository->get(Report::where('ministry_id', $ministry->id)->first()->id);

        return view('ministry.edit', [
            'coworkers' => $coworkers,
            'ministry' => $ministry_db,
            'report' => $report,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function update(EditMinistry $request, Ministry $ministry)
    {
        $data = $request->validated();

        $ministryCompare = $this->ministryRepository->compare($data);
        $reportCompare = $this->reportRepository->compare($data);

        if ($ministryCompare && $reportCompare) {
            return redirect()
                ->route('ministry.index')
                ->with('info', 'Nie potrzeba edytować służby');
        } else {
            $isMinistryEdited = $this->ministryRepository->edit($data);
            $isReportEdited = $this->reportRepository->edit($data);
            if ($isMinistryEdited && $isReportEdited) {
                if ($isMinistryEdited) {
                    // $this->ministryRepository->deleteFromGoogleCalendar($ministry_form['id']);
                    // $this->ministryRepository->setInGoogleCalendar($ministry_form['id'], Auth::user());
                }
                return redirect()
                    ->route('ministry.index')
                    ->with('success', 'Pomyślnie edytowano służbę');
            } else {
                return redirect()
                    ->route('ministry.index')
                    ->with('error', 'Nie udało się edytować służby');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ministry  $ministry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ministry $ministry)
    {
        $deleted = $this->ministryRepository->delete($ministry->id);

        if ($deleted) {
            return redirect()
                ->route('ministry.index')
                ->with('success', 'Pomyślnie usunięto służbę');
        } else {
            return redirect()
                ->route('ministry.index')
                ->with('error', 'Nie udało się usunąć służby');
        }
    }

    public function proposal()
    {
        $proposalList = $this->ministryRepository->ministryProposalList(Auth::id(), 10);
        return view('ministry.proposal', [
            'ministries' => $proposalList,
        ]);
    }

    public function proposalAccept(int $id)
    {
        $this->ministryRepository->ministryProposalAccept($id, $this->reportRepository);
        return redirect()
            ->route('ministry.index')
            ->with('success', 'Pomyślnie zaakceptowano propozycję');
    }

    public function proposalReject(int $id)
    {
        $this->ministryRepository->ministryProposalReject($id);
        return redirect()
            ->route('ministry.proposal')
            ->with('success', 'Pomyślnie odrzucono propozycję');
    }
}
