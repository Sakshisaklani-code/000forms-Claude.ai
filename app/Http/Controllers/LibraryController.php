<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryController extends Controller
{
    
    public function Library()
    {
        return view('Library.htmlTemplates');
    }

    public function ApplicationForm()
    {
        return view('Library.ApplicationFormTemplates');
    }

    public function TenantApplicationForm()
    {
        return view('Library.Tenant-ApplicationForm');
    }

    public function RentalApplicationForm()
    {
        return view('Library.Rental-ApplicationForm');
    }

    public function JobApplicationForm()
    {
        return view('Library.Job-ApplicationForm');
    }

    public function ScholarshipApplicationForm()
    {
        return view('Library.Scholarship-ApplicationForm');
    }

    public function VendorApplicationForm()
    {
        return view('Library.Vendor-ApplicationForm');
    }

    public function InternshipApplicationForm()
    {
        return view('Library.Internship-ApplicationForm');
    }

}
