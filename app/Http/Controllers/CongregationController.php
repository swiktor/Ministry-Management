<?php

namespace App\Http\Controllers;

use App\Model\Congregation;
use Illuminate\Http\Request;
use App\Repository\CongregationRepository;
use App\Http\Requests\AddCongregation;

class CongregationController extends Controller
{
    private CongregationRepository $congregationRepository;

    public function __construct(CongregationRepository $congregationRepository)
    {
        $this->congregationRepository = $congregationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $congregations = $this->congregationRepository->allPaginated(10);

        return view('congregation.index', [
            'congregations' => $congregations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
       return view('congregation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCongregation $request)
    {
        $data = $request->validated();

        $this->congregationRepository->add($data);

        return redirect()
            ->route('congregation.index')
            ->with('success', 'Dodano nowy zbór');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Congregation  $congregation
     * @return \Illuminate\Http\Response
     */
    public function show(Congregation $congregation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Congregation  $congregation
     * @return \Illuminate\Http\Response
     */
    public function edit(Congregation $congregation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Congregation  $congregation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Congregation $congregation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Congregation  $congregation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Congregation $congregation)
    {
        //
    }
}
