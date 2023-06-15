<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContactsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(ContactsDataTable $dataTable)
    {
        return $dataTable->render('admin.contacts.table.index');
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.details.index', compact('contact'));
    }

    public function destroy(Request $request, Contact $contact)
    {
        if ($request->expectsJson()) {
            $contact->delete();
            return route('admin.contacts.index');    
        } 
    }
}
