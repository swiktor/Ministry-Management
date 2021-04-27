<?php

namespace App\Http\Controllers;

use App\Model\Report;
use App\Model\Ministry;
use Illuminate\Http\Request;
use App\Http\Requests\AddMinistry;
use App\Repository\TypeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\CoworkerRepository;
use App\Repository\MinistryRepository;
use App\Repository\ReportRepository;

class MinistryController extends Controller
{
    private MinistryRepository $ministryRepository;
    private CoworkerRepository $coworkerRepository;
    private TypeRepository $typeRepository;
    private ReportRepository $reportRepository;

    public function __construct(MinistryRepository $ministryRepository, CoworkerRepository $coworkerRepository, TypeRepository $typeRepository, ReportRepository $reportRepository)
    {
        $this->ministryRepository = $ministryRepository;
        $this->coworkerRepository = $coworkerRepository;
        $this->typeRepository = $typeRepository;
        $this->reportRepository = $reportRepository;
    }

    public function dashboard()
    {
        return view('ministry.dashboard');
    }

    public function list()
    {
        $ministries = $this->ministryRepository->allPaginated(10);

        return view('ministry.list', [
            'ministries' => $ministries,
        ]);
    }

    public function addForm()
    {
        $coworkers = $this->coworkerRepository->allActive();
        $types = $this->typeRepository->all();

        return view('ministry.add', [
            'coworkers' => $coworkers,
            'types' => $types,
        ]);
    }

    public function add(AddMinistry $request)
    {
        $data = $request->validated();

        $ministry_id = $this->ministryRepository->add($data);

        $this->coworkerRepository->addToMinistry($data['coworker'], $ministry_id);

        $this->reportRepository->add($ministry_id);

        return redirect()
            ->route('ministry.list')
            ->with('success', 'Pomyślnie dodano nową służbę');
    }

    public function listForCoworker(int $id)
    {
        $ministries = $this->ministryRepository->listForCoworkerPaginated($id, 10);

        return view('ministry.list', [
            'ministries' => $ministries,
        ]);
    }
}
