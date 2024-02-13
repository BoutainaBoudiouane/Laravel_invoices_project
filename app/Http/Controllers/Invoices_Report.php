<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class Invoices_Report extends Controller
{
    public function index(){

     return view('reports.invoices_report');
        
    }

    public function Search_invoices(Request $request){

    $rdio = $request->rdio;

    if ($rdio == 1) {
        if ($request->type && $request->start_at =='' && $request->end_at =='') {
            
           $invoices = invoices::select('*')->where('Status','=',$request->type)->get();
           $type = $request->type;
           return view('reports.invoices_report',compact('type'))->with('details', $invoices);
        }
        
        else {
           
          $start_at = date($request->start_at);
          $end_at = date($request->end_at);
          $type = $request->type;
          
          $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
          return view('reports.invoices_report',compact('type','start_at','end_at'))->with('details', $invoices);
          
        }  
    } 

    else {
        
        $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
        return view('reports.invoices_report')->with('details', $invoices); 
    }
    }
    
}