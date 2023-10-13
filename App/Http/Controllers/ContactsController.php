<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

Paginator::useBootstrap();

class ContactsController extends Controller
{

    public function index()
    {
        $perPage = 5;
        $contacts = Contacts::query()->paginate($perPage);
        return view('home/index', ['contacts' => $contacts]);
    }

    public function create()
    {
        return view("home/create");
    }

    public function store(Request $request)
    {
        $arr = $request->post();
        $name = ($request->has('name')) ? $arr['name'] : "";
        $email = ($request->has('email')) ? $arr['email'] : '';
        $phone = ($request->has('phone')) ? $arr['phone'] : "";
        $dateOfBirth = ($request->has('dateOfBirth')) ? $arr['dateOfBirth'] : "";
        $company = ($request->has('company')) ? $arr['company'] : '';
        $address = ($request->has('address')) ? $arr['address'] : "";

        $name = trim(strip_tags($name));
        $email = trim(strip_tags($email));
        $phone = trim(strip_tags($phone));
        $dateOfBirth = date('Y-m-d', strtotime($dateOfBirth));
        $company = trim(strip_tags($company));
        $address = trim(strip_tags($address));

        $sp = new Contacts;
        $sp->name = $name;
        $sp->email = $email;
        $sp->phone = $phone;
        $sp['date_of_birth'] = $dateOfBirth;
        $sp->company = $company;
        $sp->address = $address;

        $sp->save();
        return redirect('/');
    }

    public function edit(Request $request, int $id)
    {
        $contact = Contacts::find($id);
        return view("home/edit", ['contact' => $contact]);
    }

    public function destroy($id)
    {
        $sp = Contacts::find($id);
        if ($sp == null) {

        }

        $sp->delete();
        return back()->withInput();
    }


}