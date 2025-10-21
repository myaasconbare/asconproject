<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class RecentTransactions extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static bool $isLazy = false;
   protected int | string | array $columnSpan = "full";

    public function table(Table $table): Table
    {
        return $table
            ->query(
               Transaction::query()
                ->with(['transactionable', 'user'])               
                ->withoutDeleted()
                ->latest()
                ->take(10)
            )
            ->columns([
                ImageColumn::make('user.avatar_url')
                    ->label('Image')
                    ->circular(),
                TextColumn::make('user.name')
                    ->label('user')
                    ->searchable(['user.email', 'user.name'])
                    ->description(fn(Model $record) => $record->user->email),
                TextColumn::make('details'),
                TextColumn::make('source')
                    ->badge()
                    ->color('success'),
                TextColumn::make('created_at')
                    ->label('Initiated At')
            ]);
    }
}
