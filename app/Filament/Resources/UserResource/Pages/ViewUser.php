<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\ReferralLevels;
use App\Filament\Resources\InvestmentResource;
use App\Filament\Resources\TradeResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\WithdrawalResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\Admin\Notify;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\RawJs;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class ViewUser extends Page
{
    protected static string $resource = UserResource::class;

    use InteractsWithRecord, Notify;

    // protected static ?string $model = User::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public $activeTab = "";

    const PERSONAL_TAB = "personal";
    const BALANCES_TAB = "balances";




    protected static string $view = 'filament.resources.user-resource.pages.view-users';

    public array $walletsData = [
        'deposit_wallet',
        'interest_wallet',
        'residual_wallet',
    ];

    public array $personalData  = [
        'name',
        'firstname',
        'lastname',
        'email',
        'country',
        'city',
        'postcode',
        'state',
        'address',
        'email_verified_at',
    ];

    public array $balancesData = [
        'trade_wallet',
        'trade_practice_wallet',

        'total_invested',
        'total_profits',
        'running_investment',

        'matrix_commission',
        'matrix_referral_commission',
        'matrix_level_commission',


        'total_trading',
        'winning_amount',
        'loss_amount',

        'total_deposited',
        'total_withdrawn',

        'investment_commission',
        'referral_commission',
        'level_commission',

        'direct_team_volume',
        'total_team_volume',
    ];

    public string $investmentsUrl = "";
    public string $tradesUrl = "";
    public string $withdrawalsUrl = "";


  


    public function query($tab)
    {
        return $this->getUrl(['record' => $this->record, 'activeTab' => $tab]);
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }


    // public static function getNavigationItems(array $urlParameters = []): array
    // {
    //     return [];
    // }


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->activeTab = in_array(request()->query('activeTab'), [self::BALANCES_TAB, self::PERSONAL_TAB]) ? request()->query('activeTab') : self::BALANCES_TAB;


        $this->walletsData = [
            'deposit_wallet' => $this->record->deposit_wallet,
            'interest_wallet' => $this->record->interest_wallet,
            'residual_wallet' => $this->record->residual_wallet,
        ];

        $this->personalData = [
            'name' => $this->record->name,
            'firstname' => $this->record->firstname,
            'lastname' => $this->record->lastname,
            'email' => $this->record->email,
            'country' => $this->record->country,
            'city' => $this->record->city,
            'postcode' => $this->record->postcode,
            'state' => $this->record->state,
            'address' => $this->record->address,
            'email_verified_at' => $this->record->email_verified_at,
        ];

        $this->balancesData = [
            'trade_wallet' => $this->record->trade_wallet,
            'trade_practice_wallet' => $this->record->trade_practice_wallet,
    
            'total_invested' => $this->record->total_invested,
            'total_profits' => $this->record->total_profits,
            'running_investment' => $this->record->running_investment,
    
            'matrix_commission' => $this->record->matrix_commission,
            'matrix_referral_commission' => $this->record->matrix_referral_commission,
            'matrix_level_commission' => $this->record->matrix_level_commission,
    
    
            'total_trading' => $this->record->total_trading,
            'winning_amount' => $this->record->winning_amount,
            'loss_amount' => $this->record->loss_amount,
    
            'total_deposited' => $this->record->total_deposited,
            'total_withdrawn' => $this->record->total_withdrawn,
    
            'investment_commission' => $this->record->investment_commission,
            'referral_commission' => $this->record->referral_commission,
            'level_commission' => $this->record->level_commission,
    
            'direct_team_volume' => $this->record->direct_team_volume,
            'total_team_volume' => $this->record->total_team_volume,
        ];

        $this->investmentsUrl = InvestmentResource::getUrl('index', ['tableSearch' => $this->record->email]);
        $this->tradesUrl = TradeResource::getUrl('index', ['tableSearch' => $this->record->email]);
        $this->withdrawalsUrl = WithdrawalResource::getUrl('index', ['tableSearch' => $this->record->email]);
    }

    protected function getForms(): array
    {
        return [
            'walletsForm',
            'personalForm',
            'balancesForm',
        ];
    }

    public function loginAsUser(){
        return resolve(UserService::class)->loginAsUser($this->record, self::getUrl(['record' => $this->record]));
    }

    public function filterInput($form){
        return array_map(fn($wallet) => str_replace(',', '', $wallet), $form);
    }

    public function updateWallet(){
        $this->record->update($this->filterInput($this->walletsData));

        $this->notify('success', "Wallets Updated successfully");
    }

    public function updateBalance(){

        $this->record->update($this->filterInput($this->balancesData));

        $this->notify('success', "Balance Updated successfully");
    }

    public function updatePersonal(){
        $this->record->update($this->personalData);

        $this->notify('success', "Personal Information Updated successfully");
    }


    public function getBalancesForm()
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make('trade_wallet')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('trade_practice_wallet')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),

                    TextInput::make('total_invested')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('total_profits')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('running_investment')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),

                    TextInput::make('matrix_commission')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('matrix_referral_commission')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('matrix_level_commission')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),


                    TextInput::make('total_trading')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('winning_amount')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('loss_amount')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),

                    TextInput::make('total_deposited')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('total_withdrawn')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),

                    TextInput::make('investment_commission')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('referral_commission')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('level_commission')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),

                    TextInput::make('direct_team_volume')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                    TextInput::make('total_team_volume')
                        ->prefix('$')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->columnSpan(1)
                        ->required(),
                ])
        ];
    }

    public function getPersonalForm()
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('firstname')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('lastname')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('email')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('country')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('city')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('postcode')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('state')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('address')
                        ->required()
                        ->columnSpan(1),
                    DateTimePicker::make('email_verified_at')
                ])
        ];
    }

    public function getWalletsForm()
    {
        return [
            TextInput::make('deposit_wallet')
                ->placeholder('Enter volume')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
            TextInput::make('interest_wallet')
                ->placeholder('Enter reward')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
            TextInput::make('residual_wallet')
                ->placeholder('Enter reward')
                ->prefix('$')
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->numeric()
                ->columnSpan(1)
                ->required(),
        ];
    }


    public function walletsForm(Form $form): Form
    {
        return $form
            ->schema($this->getWalletsForm())
            ->statePath('walletsData');
    }

    public function personalForm(Form $form): Form
    {
        return $form
            ->schema($this->getPersonalForm())
            ->statePath('personalData');
    }


    public function balancesForm(Form $form): Form
    {
        return $form
            ->schema($this->getBalancesForm())
            ->statePath('balancesData');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),

                TextEntry::make('email')
            ])
            ->record($this->record);
    }

    // public function render(): View
    // {

    //     return view('filament.resources.user-resource.pages.view-users');
    // }
}
