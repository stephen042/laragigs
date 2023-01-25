<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\List_;

class ListingController extends Controller
{
    // show all listings
    public function index(){
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]
    );
    }

    //show single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ] ); 
    }

    // show create form
    public function create(){
        return view('listings.create');
    }

    // store created listing to database
    public function store(Request $request)
    {
        // dd(request()->file('logo')->store());
        $formFields = $request->validate(
            [
            'title' => 'required',
            'company' => ['required', Rule::unique('listings','company')],
            'location' => 'required',
            'email' => ['required', ' email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
            ]
        );

        if ($request->hasFile('logo')) {
           $formFields['logo'] = $request->file('logo')->store('logo', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing succefully created');
    }

    // show edit form
    public function edit(Listing $listing)
    {
        // dd($listing);
        return view('listings.edit', ['listing' => $listing]);
    }

    // update the edit form listing to database
    public function update(Request $request, Listing $listing)
    {
        // dd(request()->file('logo')->store());
        $formFields = $request->validate(
            [
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'email' => ['required', ' email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
            ]
        );

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logo', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated succefully');
    }

    // Delete listing
    public function delete(Listing $listing)
    {
        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully');
    }


    // Manage Listing 
    public function manage(){
    
        return view('listings.manage', ['listings' => auth()->user()]);
    }
}
