<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeOption;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeOptionRequest;

class AttributeOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.attribute_options.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Attribute $attribute)
    {
        return view('admin.attribute_options.create', compact('attribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeOptionRequest $request, Attribute $attribute)
    {
        $attribute->attribute_options()->create($request->validated());

        return redirect()->route('admin.attributes.edit', $attribute)->with([
            'message' => 'Berhasil di buat !',
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
    public function edit(Attribute $attribute, AttributeOption $attribute_option)
    {
        return view('admin.attribute_options.edit',compact('attribute', 'attribute_option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeOptionRequest $request, Attribute $attribute,AttributeOption $attribute_option)
    {
        $attribute_option->update($request->validated());

        return redirect()->route('admin.attributes.edit', $attribute)->with([
            'message' => 'Berhasil di edit !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute,AttributeOption $attribute_option)
    {
        $attribute_option->delete();

        return redirect()->back()->with([
            'message' => 'Berhasil di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}
