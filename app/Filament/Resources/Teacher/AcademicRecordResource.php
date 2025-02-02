<?php

namespace App\Filament\Resources\Teacher;

use Filament\Forms;
use Filament\Tables;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicRecord;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Teacher\AcademicRecordResource\Pages;
use App\Filament\Resources\Teacher\AcademicRecordResource\RelationManagers;

class AcademicRecordResource extends Resource
{
    protected static ?string $model = AcademicRecord::class;
    protected static ?string $slug = 'Academic-Records';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('class_id')
                ->label('Class Name')
                ->options(function (Get $get): Collection {
                    $teacher = Teacher::where('user_id', Auth::id())->first();
                    
                    if (!$teacher) {
                        return collect(); 
                    }
            
                    return collect(
                        Classes::query()
                            ->where('teacher_id', $teacher->teacher_id)
                            ->pluck('class_name', 'class_id')
                    );
                })
                ->searchable()
                ->live()
                ->reactive()
                ->required(),            
                Select::make('student_id')
                    ->options(function (Get $get) {
                        $class_id = $get('class_id');
                        if ($class_id) {
                            $class = Classes::find($class_id);
                            if ($class && $class->students) {
                                $student_ids = $class->students; 
                                $query = Student::query()
                                    ->whereIn('student_id', $student_ids)
                                    ->whereNull('deleted_at')
                                    ->selectRaw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) as full_name, student_id");

                                return $query->pluck('full_name', 'student_id');
                            }
                        }
                        return [];
                    })
                    ->preload()
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('final_grade')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Select::make('semester')
                    ->options([
                        '1st Semester' => '1st Semester',
                        '2nd Semester' => '2nd Semester',
                    ])
                    ->required()
                    ->default(session()->get('semester', '1st Semester')),
                TextInput::make('school_year')
                    ->required()
                    ->maxLength(50)
                    ->default(old('school_year', session()->get('school_year', ''))),
            ]);
    }

    public static function table(Table $table): Table
    {   
        $auth_user = Auth::id();
        $teacher = Teacher::where('user_id', $auth_user)->first();
        $classes = Classes::where('teacher_id', $teacher->teacher_id)->get();

        return $table
            ->query(
                AcademicRecord::query()->whereIn('class_id', $classes->pluck('class_id'))
            )
            ->columns([
                TextColumn::make('class.class_name')
                    ->label('Class Name')
                    ->sortable(),
                TextColumn::make('student_id')
                    ->label("Student Name")
                    ->getStateUsing(function ($record) {
                        return $record->student->first_name . ' ' . $record->student->middle_name . ' ' . $record->student->last_name;
                    })
                    ->sortable(),
                TextColumn::make('final_grade')
                    ->numeric(),
                TextColumn::make('semester')
                    ->searchable(),
                TextColumn::make('school_year')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Default trashed filter
                Tables\Filters\TrashedFilter::make(),
                
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'create' => Pages\CreateAcademicRecord::route('/create'),
            'view' => Pages\ViewAcademicRecord::route('/{record}'),
            'edit' => Pages\EditAcademicRecord::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
