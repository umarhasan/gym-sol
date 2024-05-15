<?php 
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembersExport implements FromCollection, WithHeadings
{
    
    
    private $headers;
    private $data;

    public function __construct(array $headers, array $data)
    {
        $this->headers = $headers;
        $this->data = $data;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return $this->headers;
    }
}
