<?php

namespace App\Filament\Resources\Student;

use Filament\Forms;
use Filament\Tables;
use App\Models\Classes;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicRecord;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\Student\AcademicRecordsResource\Pages;
use App\Filament\Resources\Student\AcademicRecordsResource\RelationManagers;

class AcademicRecordsResource extends Resource
{
    protected static ?string $model = AcademicRecord::class;

    protected static ?string $modelLabel = 'My Academic Records';
    protected static ?string $slug = "My-Academic-Records";
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        $auth_user = Auth::id();
        $student = Student::where('user_id', $auth_user)->first();

        return $table
            ->query(
                AcademicRecord::query()->where('student_id', $student->student_id)
            )
            ->columns([
                TextColumn::make('class.class_name')
                    ->label('Class Name')
                    ->sortable(),
                TextColumn::make('final_grade')
                    ->numeric(),
                TextColumn::make('semester')
                    ->searchable(),
                TextColumn::make('school_year')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([     
                SelectFilter::make('class_id')
                    ->options(Classes::all()->pluck('class_name', 'class_id')->toArray())
                    ->label('Class Name'),

                SelectFilter::make('semester')
                    ->options([
                        '1st Semester' => '1st Semester',
                        '2nd Semester' => '2nd Semester',
                    ])
                    ->label('Semester')
                ])
                ->bulkActions([
                    BulkActionGroup::make([
                        ExportBulkAction::make(),
                    ]),
                ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicRecords::route('/'),
        ];
    }
}
