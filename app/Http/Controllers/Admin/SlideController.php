<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\SlideRequest;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slide::orderBy('position', 'ASC')->get();

        return view('admin.slides.index', compact('slides'));
    }

    public function moveUp($id)
	{
		$slide = Slide::findOrFail($id);

		if (!$slide->prevSlide()) {
			return redirect('admin/slides');
		}

		\DB::transaction(
			function () use ($slide) {
				$currentPosition = $slide->position;
				$prevPosition = $slide->prevSlide()->position;

				$prevSlide = Slide::find($slide->prevSlide()->id);
				$prevSlide->position = $currentPosition;
				$prevSlide->save();

				$slide->position = $prevPosition;
				$slide->save();
			}
		);

		return redirect('admin/slides');
    }
    
    public function moveDown($id)
	{
		$slide = Slide::findOrFail($id);

		if (!$slide->nextSlide()) {
			\Session::flash('error', 'Invalid position');
			return redirect('admin/slides');
		}

		\DB::transaction(
			function () use ($slide) {
				$currentPosition = $slide->position;
				$nextPosition = $slide->nextSlide()->position;

				$nextSlide = Slide::find($slide->nextSlide()->id);
				$nextSlide->position = $currentPosition;
				$nextSlide->save();

				$slide->position = $nextPosition;
				$slide->save();
			}
		);

		return redirect('admin/slides');
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = Slide::STATUSES;

        return view('admin.slides.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlideRequest $request)
    {
        
        if($request->validated()){
            $image = $request->file('path')->store('assets/slides', 'public'); 
            Slide::create($request->except('path') + ['path' => $image,'position' => Slide::max('position') + 1, 'user_id' => auth()->id()]);
        }

		return redirect('admin/slides')->with([
            'message' => 'berhasil di tambah !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slide $slide)
    {
        $statuses = Slide::STATUSES;

		return view('admin.slides.edit', compact('slide', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SlideRequest $request, Slide $slide)
    {
        if($request->validated()) {
            if($request->path){
                File::delete('storage/'. $slide->path);
                $image = $request->file('path')->store('assets/slides', 'public'); 
                $slide->update($request->except('path') + ['path' => $image,'position' => Slide::max('position') + 1, 'user_id' => auth()->id()]);   
            }else {
                $slide->update($request->validated() + ['position' => Slide::max('position') + 1, 'user_id' => auth()->id()]);   
            }
        }

		return redirect('admin/slides')->with([
            'message' => 'berhasil di edit !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slide $slide)
    {
        File::delete('storage/' . $slide->path);
        $slide->delete();

        return redirect()->back()->with([
            'message' => 'berhasil di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}
