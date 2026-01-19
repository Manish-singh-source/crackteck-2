<?php

namespace App\Http\Controllers;

use App\Models\Contact;

class ContactController extends Controller
{
    //
    public function index()
    {
        $contacts = Contact::all();
        return view('/e-commerce/contacts/index', compact('contacts'));
    }

    public function view($id)
    {
        $contact = Contact::find($id);
        return view('/e-commerce/contacts/view', compact('contact'));
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact.index')->with('success', 'Contact deleted successfully.');
    }
}
