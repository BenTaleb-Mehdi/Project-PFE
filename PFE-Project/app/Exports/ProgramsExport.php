<?php
namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProgramsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $programs = Program::with('items.meal')->get();
        $rows = collect();

        foreach ($programs as $program) {
            if ($program->items->isEmpty()) {
                $rows->push((object)[
                    'program_title' => $program->title,
                    'day' => 'N/A',
                    'slot' => 'N/A',
                    'meal_name' => 'No Meals Assigned',
                    'meal_details' => '',
                    'calories' => 0,
                    'protein' => 0,
                    'carbs' => 0,
                    'fats' => 0
                ]);
            } else {
                foreach ($program->items as $item) {
                    $rows->push((object)[
                        'program_title' => $program->title,
                        'day' => $item->day_of_week,
                        'slot' => $item->time_slot,
                        'meal_name' => $item->meal->name ?? 'Deleted Meal',
                        'meal_details' => $item->meal->details ?? '',
                        'calories' => $item->meal->calories ?? 0,
                        'protein' => $item->meal->protein ?? 0,
                        'carbs' => $item->meal->carbs ?? 0,
                        'fats' => $item->meal->fats ?? 0
                    ]);
                }
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Program Title',
            'Day',
            'Time Slot',
            'Meal Name',
            'Meal Details (Instructions)',
            'Calories (kcal)',
            'Protein (g)',
            'Carbs (g)',
            'Fats (g)',
        ];
    }

    /**
    * @var object $row
    */
    public function map($row): array
    {
        // Strip HTML tags from details for Excel readability
        $cleanDetails = strip_tags($row->meal_details);
        // Replace common HTML entities
        $cleanDetails = html_entity_decode($cleanDetails);

        return [
            $row->program_title,
            $row->day,
            $row->slot,
            $row->meal_name,
            $cleanDetails,
            $row->calories,
            $row->protein,
            $row->carbs,
            $row->fats,
        ];
    }
}
