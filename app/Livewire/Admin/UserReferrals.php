<?php

namespace App\Livewire\Admin;

use App\Enums\ReferralLevels;
use App\Filament\Resources\UserResource;
use App\Models\Referral;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
// use Filament\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class UserReferrals extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;
    
    protected static string $view = 'livewire.admin.user-referrals';

    public $record;

    public function mount(int | string $record): void
    {
        // $this->record = $record);
        
    }

    public function form(Form $form): Form
    {
        return $form
           
            ->schema([
                Fieldset::make('user details')
                    ->relationship('referred')
                    ->schema([
                        TextInput::make('username')->required(),
                        TextInput::make('firstname')->required(),
                        TextInput::make('lastname')->required(),
                        TextInput::make('email')->required(),
                    ]),
                    DateTimePicker::make('created_at')
                    ->label('Referral Date')
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Referral::query()->where('user_id', $this->record))
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('referred.avatar_url')
                ->label('Image')
                ->circular(),
                TextColumn::make('referred.name')
                    ->label('user')
                    ->searchable(['email', 'name'])
                    ->description(fn(Model $record) => $record->referred->email),
                TextColumn::make('level')
                    ->label('User Referral level')
                    ->prefix('Level : '),
               
                TextColumn::make('referred.rank')
                    ->label('Rank')
                    ->state(fn (Model $record) => "Level {$record->referred->rank?->level} : {$record->referred->rank?->name}"),
            ])
            ->filters([
                SelectFilter::make('level')
                    ->options(ReferralLevels::options()),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make()->color('success'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make()
                //     ->label('Edit Referral Details'),
                // Action::make('Edit Full Details')
                //     ->action(fn(Model $record) => redirect(UserResource::getUrl('edit', ['record' => $record->referred->id]))),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    // public function render()
    // {
    //     return view('livewire.admin.user-referrals');
    // }
}
