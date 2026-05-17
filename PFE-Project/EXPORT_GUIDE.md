# Export Guide: PDF & Excel Generation

This guide provides instructions on how to implement PDF and Excel exports within the Performance Engine system using the established patterns and libraries.

---

## 1. PDF Generation (DomPDF)

The project uses `barryvdh/laravel-dompdf` for PDF generation. This is ideal for receipts, certificates, and fixed-layout reports.

### Implementation Steps

1. **Create a Blade Template**:
   Create your PDF layout in `resources/views/pdfs/`. Use standard HTML and CSS (DomPDF supports CSS 2.1).
   Example: `resources/views/pdfs/my_report.blade.php`.

2. **Controller Logic**:
   Import the `Pdf` facade and use it to load a view and download the result.

   ```php
   use Barryvdh\DomPDF\Facade\Pdf;

   public function downloadReport($id)
   {
       $data = \App\Models\YourModel::findOrFail($id);
       $pdf = Pdf::loadView('pdfs.my_report', compact('data'));
       
       return $pdf->download('report_' . $id . '.pdf');
   }
   ```

### Real-world Example
See [PaymentController.php](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Http/Controllers/Coach/PaymentController.php) (`downloadReceipt` method).

---

## 2. Excel Generation (Laravel Excel)

The project uses `maatwebsite/excel` for Excel exports. This is perfect for data analysis and bulk exports.

### Implementation Steps

1. **Create an Export Class**:
   Run `php artisan make:export MyDataExport --model=MyModel` or create it manually in `app/Exports/`.

   ```php
   namespace App\Exports;

   use App\Models\MyModel;
   use Maatwebsite\Excel\Concerns\FromCollection;
   use Maatwebsite\Excel\Concerns\WithHeadings;

   class MyDataExport implements FromCollection, WithHeadings
   {
       public function collection()
       {
           return MyModel::all();
       }

       public function headings(): array
       {
           return ['ID', 'Name', 'Email', 'Created At'];
       }
   }
   ```

2. **Controller Logic**:
   Import the `Excel` facade and your export class.

   ```php
   use Maatwebsite\Excel\Facades\Excel;
   use App\Exports\MyDataExport;

   public function exportData()
   {
       return Excel::download(new MyDataExport, 'my_data_' . date('Y-m-d') . '.xlsx');
   }
   ```

### Real-world Example
See [NutritionController.php](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Http/Controllers/Coach/NutritionController.php) (`exportPrograms` method) and the corresponding export class [ProgramsExport.php](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Exports/ProgramsExport.php).

---

## Best Practices
- **Memory Limits**: For large exports, use `ini_set('memory_limit', '512M');` in your controller method.
- **Styling PDFs**: Use inline styles or a dedicated CSS file linked in the Blade template. Avoid complex modern CSS (like Flexbox/Grid) as DomPDF has limited support for them.
- **Excel Mapping**: Use the `WithMapping` concern in your Export class to control exactly how data is formatted in the rows (e.g., stripping HTML tags).
