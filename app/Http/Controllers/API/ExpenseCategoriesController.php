<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExpenseCategories;

class ExpenseCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExpenseCategories::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        ExpenseCategories::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $amountArray = [];
        $labelArray = [];
        $categories = ExpenseCategories::with(['expenses' => function($query) use ($id){
            return $query->where('user_id', $id);
        }])->get();

        foreach($categories as $category){
            array_push($labelArray, $category->name);
            array_push($amountArray, $category->expenses->sum('amount'));
        }


         return response()->json([
             'label' => $labelArray,
             'amount' => $amountArray
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        ExpenseCategories::find($id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = ExpenseCategories::with('expenses')->find($id);
        
        if(count($categories->expenses) > 0){
            return 1;
        }

        $categories->delete();
    }
}
