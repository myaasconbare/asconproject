<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ReferralLevel;
use App\Models\BatchCommission;
use App\Models\ReferralCommission;
use App\Models\Setting;
use App\Models\TeamCommission;
use App\Traits\Admin\Notify;
use Filament\Actions\Action;
// use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Actions\Action as ActionsAction;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;
use Filament\Pages\Page;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;

class Commissions extends Page implements HasTable
{
    use InteractsWithTable, Notify;

    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Settings';


    protected static string $view = 'filament.pages.commissions';

    // tabs
    const TEAM_VOLUME_TAB = "team_volume";
    const REFERRALS_TAB = "referrals";
    const BATCHES_TAB = "batches";

    #[Computed]
    public function referalLevel()
    {
        return referralLevel();
    }

   
    public function getWidgetData(): array
    {
        return [
            'stats' => [
                'total' => 100,
            ],
        ];
    }

    public function getFooter(): ?View
    {
        return view('filament.settings.footer');
    }



    protected function getHeaderActions(): array
    {
        return [
            Action::make('Referral Level')
                ->label('Referral Level : ' . $this->referalLevel)
                ->outlined()
                ->form([
                    TextInput::make('referral_level')
                        ->required()
                        ->integer()
                        ->default($this->referalLevel)
                ])
                ->modalWidth('md')
                ->modalHeading('Change Referral Level')
                ->action(function (array $data) {
                    $setting = Setting::latest()->first();

                    Setting::updateOrCreate(['id' => $setting?->id], ['referral_level' => $data['referral_level']]);

                    return $this->notify('success', 'Level updated successfully', 'Success');
                }),
        ];
    }


    public function getBreadcrumbs(): array
    {
        return [
            Dashboard::getUrl() => 'Dashbaord',
            'Commissions'
        ];
    }



    public string $activeTab = "";

    public $level;
    public $percentage;

    public array $volumeData = [
        'volume',
        'level_range_start',
        'level_range_end',
        'reward',
        'is_all_level',
    ];

    public array $referralData = [
        'level',
        'percentage',
    ];

    public function mount()
    {
        $this->activeTab = request()->query('activeTab', self::BATCHES_TAB);

        $this->teamVolumeForm->fill([
            'is_all_level' => 0,
        ]);


            

        // dd(auth('admin')->user());
    }

    public function query($tab)
    {
        return $this->getUrl(['activeTab' => $tab]);
    }

    public function validateInputs()
    {
        return $this->activeTab == self::TEAM_VOLUME_TAB ? $this->teamVolumeForm->validate() : $this->referralForm->validate();
    }

    public function submit()
    {

        $this->validateInputs();

        return match ($this->activeTab) {
            self::BATCHES_TAB =>  $this->handleSave(BatchCommission::class),
            self::REFERRALS_TAB =>  $this->handleSave(ReferralCommission::class),
            self::TEAM_VOLUME_TAB => $this->handleSave(TeamCommission::class),
        };
    }

    public function dissmissModal()
    {
        $this->dispatch('close-modal', id: 'commission-modal');
        $this->dispatch('close-modal', id: 'team-volume-modal');
    }

    public function resetForm()
    {
        if ($this->activeTab == self::TEAM_VOLUME_TAB) {
            return $this->teamVolumeForm->fill();
        }
        return $this->referralForm->fill();
    }

    public function handleSave($model)
    {
        if ($this->activeTab == self::TEAM_VOLUME_TAB) {
            $model::create($this->teamVolumeForm->getState());
        } else {
            $level = $this->referralForm->getState()['level'];
            if ($model::where('level', $level)->exists()) return $this->notify('error', 'Level aready exists');

            $model::create($this->referralForm->getState());
        }

        $this->resetForm();
        $this->dissmissModal();

        return $this->notify('success', 'saved successfully');
    }

    public function eloquentQuery(): Builder
    {
        return match ($this->activeTab) {
            self::BATCHES_TAB =>  BatchCommission::query(),
            self::REFERRALS_TAB =>  ReferralCommission::query(),
            self::TEAM_VOLUME_TAB =>  TeamCommission::query(),
        };
    }

    protected function getForms(): array
    {
        return [
            'teamVolumeForm',
            'referralForm',
        ];
    }


    public function getReferralForm()
    {
        return [
            TextInput::make('level')
                ->prefix('level_')
                ->integer()
                ->required(),
            TextInput::make('percentage')
                ->suffix('%')
                ->numeric()
                ->required(),
        ];
    }
    public function getTeamVolumeForm()
    {
        return [
            TextInput::make('volume')
                ->placeholder('Enter volume')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
            TextInput::make('reward')
                ->placeholder('Enter reward')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
            Select::make('is_all_level')
                ->label('Levels Range')
                ->options([
                    0 => 'Fixed',
                    1 => 'All',
                ])
                ->live()
                ->default(0),
            TextInput::make('level_range_start')
                ->label('From: ')
                ->hint('Range')
                ->prefix('level_')
                ->integer()
                ->hidden(fn(Get $get) => $get('is_all_level'))
                ->requiredIf('is_all_level', 0),
            TextInput::make('level_range_end')
                ->label('To: ')
                ->hint('Range')
                ->prefix('level_')
                ->integer()
                ->hidden(fn(Get $get) => $get('is_all_level'))
                ->requiredIf('is_all_level', 0),
        ];
    }

    public function teamVolumeForm(Form $form): Form
    {
        return $form
            ->schema($this->getTeamVolumeForm())
            ->statePath('volumeData');
    }

    public function referralForm(Form $form): Form
    {
        return $form
            ->schema($this->getReferralForm())
            ->statePath('referralData');
    }

    public function table(Table $table): Table
    {


        return $table
            ->query($this->eloquentQuery())
            ->columns([
                TextColumn::make('level')
                    ->hidden(fn() => $this->activeTab == self::TEAM_VOLUME_TAB),
                TextColumn::make('percentage')
                    ->suffix('%')
                    ->hidden(fn() => $this->activeTab == self::TEAM_VOLUME_TAB),
                TextColumn::make('volume')
                    ->money('USD')
                    ->visible(fn() => $this->activeTab == self::TEAM_VOLUME_TAB),
                TextColumn::make('reward')
                    ->money('USD')
                    ->visible(fn() => $this->activeTab == self::TEAM_VOLUME_TAB),
                TextColumn::make('level_range_start')
                    ->label('Range')
                    ->state(fn(Model $record) => $record->range)
                    ->visible(fn() => $this->activeTab == self::TEAM_VOLUME_TAB),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(fn() => $this->activeTab == self::TEAM_VOLUME_TAB ? $this->getTeamVolumeForm() : $this->getReferralForm())
                    ->modalWidth('md'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
