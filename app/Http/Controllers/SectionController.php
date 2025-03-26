<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionFormRequest;
use App\Models\Section;
use App\Services\SectionService;
use App\Services\AirlineService;
use App\Services\CityService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function index(): View
    {
        // $this->authorize('all', Section::class);
        $data['title'] = 'All Sections';
        $data['sections'] = (new SectionService())->all();
        return view('sections.index', $data);
    }

    public function create(): View
    {
        // $this->authorize('create', Section::class);
        $data['title'] = 'Add Section';
        $data[ 'airlines' ] = ( new AirlineService() ) -> all ();
        $data[ 'cities' ] = ( new CityService() ) -> all ();
        return view('sections.create', $data);
    }

    public function store(SectionFormRequest $request): RedirectResponse
    {
        // $this->authorize('create', Section::class);

        try {
            DB::beginTransaction();
            $section = (new SectionService())->save($request);
            DB::commit();
            
            return redirect()->back()->with('success', 'Section has been added.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function show(Section $section)
    {
        //
    }

    public function edit(Section $section): View
    {
        // $this->authorize('update', $section);
        $data['title'] = 'Edit Section';
        $data['section'] = $section;
        $data[ 'airlines' ] = ( new AirlineService() ) -> all ();
        $data[ 'cities' ] = ( new CityService() ) -> all ();
        return view('sections.update', $data);
    }

    public function update(SectionFormRequest $request, Section $section): RedirectResponse
    {
        // $this->authorize('update', $section);
        try {
            DB::beginTransaction();
            (new SectionService())->edit($request, $section);
            DB::commit();
            
            return redirect()->back()->with('success', 'Section has been updated.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function destroy(Section $section): RedirectResponse
    {
        // $this->authorize('delete', $section);
        try {
            $section->delete();
            return redirect()->back()->with('success', 'Section has been deleted.');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
