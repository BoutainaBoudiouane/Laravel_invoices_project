<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\invoices;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithHeadings;

class invoicesExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retrieve all invoices data
        $invoices = Invoices::all();

        // Get column names efficiently using Schema
        $columns = Schema::getColumnListing('invoices');

        // Combine column names with data
        return collect($invoices)->map(function ($invoice) use ($columns) {
            return array_combine($columns, $invoice->toArray());
        });
    }

    public function headings(): array
    {
        // Get column names directly without relying on collection
        $columns = Schema::getColumnListing('invoices');

        return $columns;
    }
}
