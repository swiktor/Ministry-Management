<?php

namespace App\Http\Controllers;

use App\Model\Report;
use App\Model\Ministry;
use Illuminate\Http\Request;
use App\Repository\TypeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\CoworkerRepository;
use App\Repository\MinistryRepository;

class MinistryController extends Controller
{
    private MinistryRepository $ministryRepository;
    private CoworkerRepository $coworkerRepository;
    private TypeRepository $typeRepository;

    public function __construct(MinistryRepository $ministryRepository, CoworkerRepository $coworkerRepository, TypeRepository $typeRepository)
    {
        $this->ministryRepository = $ministryRepository;
        $this->coworkerRepository = $coworkerRepository;
        $this->typeRepository = $typeRepository;
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

    public function add(Request $request)
    {
        $data = $request->toArray();

        $ministry = new Ministry();
        $ministry->type_id= $data['type'];
        $ministry->when=$data['when'];
        $ministry->user_id=Auth::id();
        $ministry->save();

        $ministry_id=$ministry->id;
        $coworkers = $data['coworker'];

        foreach ($coworkers ?? [] as $coworker) {
            DB::table('coworkerministries')->insert([
                'coworker_id' => $coworker,
                'ministry_id' => $ministry_id
            ]);
        }

        $report = new Report();
        $report->ministry_id = $ministry_id;
        $report->save();

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
