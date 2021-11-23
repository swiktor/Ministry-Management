<?php

namespace App\Http\Controllers;

use App\Repository\CongregationRepository;
use App\Http\Requests\AddCongregation;

class CongregationController extends Controller
{
    private CongregationRepository $congregationRepository;

    public function __construct(CongregationRepository $congregationRepository)
    {
        $this->congregationRepository = $congregationRepository;
    }

    public function list()
    {
        $congregations = $this->congregationRepository->allPaginated(10);

        return view('congregation.list', [
            'congregations' => $congregations,
        ]);
    }

    public function add(AddCongregation $request)
    {
        $data = $request->validated();

        $this->congregationRepository->add($data);

        return redirect()
            ->route('congregation.list')
            ->with('success', 'Dodano nowy zbór');
    }

    public function addForm()
    {
        return view('congregation.add');
    }


}
