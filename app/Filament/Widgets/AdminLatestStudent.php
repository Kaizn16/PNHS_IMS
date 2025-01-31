<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Student;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\Admin\StudentResource\Pages\ViewStudent;

class AdminLatestStudent extends BaseWidget
{
    protected static ?string $heading = 'Recently Added Student';
    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('index')
                    ->label('#')
                    ->rowIndex(), 
                TextColumn::make('student_name')
                    ->icon('heroicon-o-user')
                    ->label('Student Name')
                    ->getStateUsing(fn (Student $record) => 
                        $record->first_name . ' ' . ($record->middle_name ?? '') . ' ' . $record->last_name
                    ),
                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->dateTime(),
            ])
            ->recordUrl(fn (Student $record) => ViewStudent::getUrl(['record' => $record->getKey()]
        ));
    }

    public static function getPages(): array
    {
        return [
            'view' => ViewStudent::route('/{record}'),
        ];
    }
}
