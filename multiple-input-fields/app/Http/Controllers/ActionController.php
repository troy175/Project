<?php

namespace App\Http\Controllers;

use App\Models\Action; // Ensure the model name is correct (case-sensitive)
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all actions from the database
        $actions = Action::all();
        return view('index', compact('actions')); // Pass actions to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create'); // Return the view for creating a new action
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log the incoming request data for debugging
        \Log::info('Request Data:', $request->all());

        // Validate the incoming request
        $request->validate([
            'inputs.*.name' => 'required|string|max:255'
        ], [
            'inputs.*.name.required' => 'The name field is required!'
        ]);

        // Store each input in the database
        foreach ($request->inputs as $input) {
            Action::create($input);
        }

        return redirect()->route('actions.index')->with('success', 'The action has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Action $action)
    {
        return view('show', compact('action')); // Return the view for displaying a specific action
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Action $action)
    {
        return view('edit', compact('action')); // Return the view for editing the action
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Action $action)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255'
        ], [
            'name.required' => 'The name field is required!'
        ]);

        // Update the action in the database
        $action->update($request->only('name'));

        return redirect()->route('actions.index')->with('success', 'The action has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        $action->delete(); // Delete the action from the database
        return redirect()->route('actions.index')->with('success', 'The action has been deleted!');
    }
}